<?

abstract class AbstractController
{
	public function AbstractController(){
		//SANITIZE YOUR INPUTS
		$_POST = self::sanitize($_POST);
		$_GET = self::sanitize($_GET);
	}

	//GRABS PARAMETER FROM POST FIRST, THEN GET
	public function getParam($name){
		return $this->getPostParam($name) ? $this->getPostParam($name) : $this->getGetParam($name);
	}

	//GETS THE POST PARAMETER BY NAME
	public function getPostParam($name){
		return (isset($_POST[$name])) ? mysql_real_escape_string($_POST[$name]) : null;
	}

	//GETS THE GET PARAMETER BY NAME
	public function getGetParam($name){
		return (isset($_GET[$name])) ? mysql_real_escape_string($_GET[$name]) : null;
	}

	//RETURNS THE ENTIRE POST ARRAY
	public static function getAllPostParams(){
		return $_POST;
	}

	//RETURNS THE ENTIRE GET ARRAY
	public static function getAllGetParams(){
		return $_GET;
	}

	//RUNS THROUGH MYSQL FUNCTION TO MAKE SURE ITS OK
	private function sanitize($array){
		$return = array();
		foreach($array as $key => $value){
			$return[$key] = mysql_real_escape_string($value);
		}
		return $return;
	}


	
}