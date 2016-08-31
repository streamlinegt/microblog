<?
class UserController extends AbstractController
{
	public function Follow(){
		$followeeId = $this->getParam("followeeId");
		$followerId = $this->getParam("followerId");
		UserManager::followUser($followerId, $followeeId);

		echo json_encode(array("response"=>true, "data"=>""));
	}

	public function RegisterUser(){
		$params = $this->getAllPostParams();
		try{
			$newUser = UserManager::registerUser($params);
		}
		catch(Exception $ex){
			http_response_code(400);
			echo json_encode(array("response"=>http_response_code(),"error"=>$ex->getMessage()));
			return;
		}
		

		echo json_encode(array('response'=>true, "data"=>$newUser));
	}
}