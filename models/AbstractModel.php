<?php

abstract class AbstractModel 
{
	protected static $dataModel;
	protected static $tableName;

	public function isNew(){
		return (isset($this->id));
	}

	/**
	 * @return array of strings
	 * No Parameters
	 */
	public function getColumns(){
		return array_keys(static::$dataModel);
	}


	/**
	 * @desc
	 * get the table associated with the current model
	 * 
	 * @return string
	 * No Parameters
	 */
	public function getTableName() {
		return static::$tableName;
	}


	/**
	 * @desc
	 * Populates member variables based on the columns in the data model
	 */
	public function populate($parameters){
		$columns = $this->getColumns();
		foreach($columns as $col){
			if(isset($parameters[$col])){
				$this->$col = $parameters[$col];
			}
		}
	}


	/**
	 * @desc
	 * uses the tables associated with the called class and grabs a row out of the database based on ID
	 * @param int $id
	 * 
	 * @return object of called class
	 */

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


	/**
	 * @desc
	 * inserts new row into the DB
	 * 
	 */
	public function insert(){
		$data = self::createDataArray();
		foreach($data as $key => &$value) addslashes($value);
		$values = implode("','", $data);
		$columns = implode("`,`", array_keys($data));
		$tableName = $this->getTableName();

		//STRING INTERPOLATE VALUES
		$sql = "INSERT IGNORE INTO {$tableName} (`{$columns}`) VALUES ('{$values}');";
		//echo $sql;
		//FOR NOW CREATE SQL STATEMENT, NO DB TO RUN IT AGAINST!

	}

	/**
	 * @desc
	 * Updates an existing row
	 * 
	 */
	public function update(){
		$data = self::createDataArray();

		$update = array();
		foreach($data as $column => $value){
			if($column != "id") $update[] = "`".$column."` = '".$value."'";
		}

		//USE IMPLODE TO BRING DATA TOGETHER
		$updateString = implode(",", $update);

		$tableName = $this->getTableName();
		$id = $this->id;

		//STRING INTERPOLATE THE VARIABLES
		$sql = "UPDATE {$tableName} SET {$updateString} WHERE id = {$id};";
		//QUERY($sql); //FOR NOW CREATE SQL STATEMENT, NO DB TO RUN IT AGAINST!
		//echo $sql;
	}

	/**
	 * @desc
	 * Abstract save method, chooses whether to update or delete based on the ID column
	 * 
	 */
	public function save(){
		if(isset($this->id)){
			return $this->update();
		}
		else
		{
			return $this->insert();
		}
	}

	/**
	 * @desc
	 * Creates an associative array based on member variables and columns available
	 * 
	 * @return associative array
	 */
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


	/**
	 * @desc 
	 * takes in parameters and queries table for rows.
	 * 
	 * @param array $params associative, key is column, value is what to search for
	 * @param array/string $sort first is column, second is direction
	 * @param array/string $limit first start index, second is count
	 * 
	 * @return array of called class objects
	 */
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
        	if(is_array($limit)){
        		$limit = $limit[0].", ".$limit[1];
        	}
            $sql .= " LIMIT ".$limit;
        }
        
         //echo $sql;
        
        //TESTING CODE, RETURN EXAMPLE STUFF
        $columns = $caller->getColumns();
        $return = array();
        foreach($columns as $col){
        	$return[$col] = "Test Data";
        }
        return array($return);
    }

    /**
     * @desc
     * Validates the data based on the member variables and the data model
     */
    public function validateData(){
		$data = $this->createDataArray();
		foreach($data as $key => $value){
			$dataType = static::$dataModel[$key];
			switch(true){
				case stristr($dataType, "int");
					if(!is_numeric($value)){
						throw new Exception("Invalid Data: {$key} is not an integer");
					}
					break;
				
				case $dataType == "boolean":
					if(gettype($value) != "boolean"){
						throw new Exception("Invalid Data: {$key} is not a boolean, it is a {gettype($value)}.");
					}
					break;

				//ADD MORE CASES IN FURTURE

			}
		}
	}


}

