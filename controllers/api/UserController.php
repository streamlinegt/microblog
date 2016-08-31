<?
class UserController extends AbstractController
{
	public function Follow(){
		$followeeId = $this->getParam("followeeId");
		$followerId = $this->getParam("followerId");
		UserManager::followUser($followerId, $followeeId);

		echo json_encode(array("response"=>true, "data"=>""));
	}
}