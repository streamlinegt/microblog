<?

abstract class AbstractController
{
	public function AbstractController(){}


	public function getParam($name){
		return $this->getPostParam($name) ? $this->getPostParam($name) : $this->getGetParam($name);
	}

	public function getPostParam($name){
		return (isset($_POST[$name])) ? $_POST[$name] : null;
	}

	public function getGetParam($name){
		return (isset($_GET[$name])) ? $_GET[$name] : null;
	}

	public static function getAllPostParams(){
		return $_POST;
	}

	public static function getAllGetParams(){
		return $_GET;
	}


	
}