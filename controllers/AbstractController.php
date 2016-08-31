<?

abstract class AbstractController
{
	public function AbstractController(){
		//SANITIZE YOUR INPUTS
		
	}

	//GRABS PARAMETER FROM POST FIRST, THEN GET
	public function getParam($name){
		return $this->getPostParam($name) ? $this->getPostParam($name) : $this->getGetParam($name);
	}

	//GETS THE POST PARAMETER BY NAME
	public function getPostParam($name){
		return (isset($_POST[$name])) ? $_POST[$name] : null;
	}

	//GETS THE GET PARAMETER BY NAME
	public function getGetParam($name){
		return (isset($_GET[$name])) ? $_GET[$name] : null;
	}

	//RETURNS THE ENTIRE POST ARRAY
	public static function getAllPostParams(){
		return $_POST;
	}

	//RETURNS THE ENTIRE GET ARRAY
	public static function getAllGetParams(){
		return $_GET;
	}


	
}