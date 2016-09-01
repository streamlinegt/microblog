<?
class UserController extends AbstractApiController
{

	/**
	 * @desc
	 * Grabs the params and passes them to the Usermanager to follow
	 */
	public function Follow(){
		$followeeId = $this->getParam("followeeId");
		$followerId = $this->getParam("followerId");
		try{
			UserManager::followUser($followerId, $followeeId);
		} catch(Exception $ex){
			echo json_encode(array("response"=>false,"error"=>$ex->getMessage()));
			return;
		}
		

		echo json_encode(array("response"=>true, "data"=>""));
	}

	/*
	 * @desc
	 * Grabs the post parameters, and passed the,
	 * int the register user function
	 */
	public function RegisterUser(){
		$params = $this->getAllPostParams();
		try{
			$newUser = UserManager::registerUser($params);
		}
		catch(Exception $ex){
			echo json_encode(array("response"=>false,"error"=>$ex->getMessage()));
			return;
		}
		

		echo json_encode(array('response'=>true, "data"=>$newUser));
	}
}