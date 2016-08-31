<?php

abstract class AbstractModel 
{
	protected static $dataModel;

	public function getColumns(){
		return array_keys(static::$dataModel);
	}

	public function getTableName() {
		return static::$tableName;
	}

	public function populate($parameters){
		$columns = $this->getColumns();
		foreach($columns as $col){
			if(isset($parameters[$col])){
				$this->$col = $parameters[$col];
			}
		}
	}

	public static function getById($id){
		$class = new static;
		$tableName = $class->getTableName();
		$columns = $class->getColumns();
		$colString = implode("`,`", $columns);
		
		//GET INFO OUT OF DB
		$res = self::getList(array('id'=>$id));
		if($res){
			$obj = new static;
			$obj->populate($res[0]);
			return $obj;
		}
	}

	public function insert(){
		$data = self::createDataArray();
		$values = implode("','", $data);
		$columns = implode("`,`", array_keys($data));
		$tableName = $this->getTableName();

		$sql = "INSERT IGNORE INTO {$tableName} (`{$columns}`) VALUES ('{$values}');";
		//echo $sql;

	}

	public function save(){
		if(isset($this->id)){
			return $this->update();
		}
		else
		{
			return $this->insert();
		}
	}

	public function update(){
		$data = self::createDataArray();
		$update = array();
		foreach($data as $column => $value){
			$update[] = "`".$column."` = '".$value."', ";
		}
		$updateString = implode(",", $update);
		$tableName = $this->getTableName();
		$id = $this->id;
		$sql = "UPDATE {$tableName} SET {$updateString} WHERE id = {$id};";
		//QUERY($sql);
		//echo $sql;
	}

	public function createDataArray() {
		$columns = $this->getColumns();
		$return = array();
		foreach($columns as $col){
			if(isset($this->$col)){
				$return[$col] = $this->$col;
			}
		}
		return $return;
	}

	public static function getList($params, $sort = null, $limit = null)
    {
        $caller = new static;
        $table_name = $caller->getTableName();
        $columns = $caller->getColumns();
        $columnsString = implode(", ", $columns);

        global $conn;
        $sql = "SELECT {$columnsString} FROM ".$table_name;
        if($params)
        {
            $sql .= " WHERE 1=1";
            foreach($params as $key=>$value)
            {
                if($key == "OR") {
                    $sql .= " AND (".$value.")";
                }
                elseif(is_array($value))
                {
                    if(is_array($value[1]))
                    {
                        $value[1] = "('".implode("','", $value[1])."')";
                    }
                    elseif(!is_numeric($value[1]) && $value[0] != "BETWEEN")
                    {
                        $value[1] = "'".addslashes($value[1])."'";
                    }

                    $sql .= " AND ".$key." ".$value[0]." ".$value[1];
                }
                else
                {
                    $sql .= " AND `".$key."` = '".addslashes($value)."'";
                }
            }
        }
        if($sort!=null)
        {
        	if(is_array($sort)){
        		$sort = implode(" ", $sort);
        	}
            $sql .= " ORDER BY ".$sort;
        }

        if($limit)
        {
            $sql .= " LIMIT ".$limit;
        }
        
         //echo $sql;
        
        //TESTING CODE, RETURN EXAMPLE STUFF
        $columns = $caller->getColumns();
        $return = array();
        foreach($columns as $col){
        	$return[$col] = "meat";
        }
        return array($return);

        $result = mysql_query($sql, $conn) or die ($sql." ".mysql_error());
        if((mysql_num_rows($result)) < 1){
            return false;
            }//end if
        else{
            while($line = mysql_fetch_array($result))
            {
                 $obj = new $caller();
                 $obj->populate($line);
                 $array_result[] = $obj;
            }
            return $array_result;
        }//end else
    }

    public function validateData(){
		$data = $this->createDataArray();
		foreach($data as $key => $value){
			$dataType = $this->dataModel[$key];
			switch(true){
				case stristr($dataType, "int");
					if(!is_numeric($value)){
						throw new Exception("Invalid Data: {$key} is not an integer");
					}
					break;
				case stristr($dataType, "varchar"):
					preg_match_all('!\d+!', $dataType, $matches);
					$length = $matches[0][0];
					if((int)$length < strlen($value)){
						throw new Exception("Invalid Data: {$key} is longer than {length}");
					}
					break;
				case $dataType == "boolean":
					if(gettype($value) != "boolean"){
						throw new Exception("Invalid Data: {$key} is not a boolean, it is a {gettype($value)}.");
					}
					break;

			}
		}
	}


}

