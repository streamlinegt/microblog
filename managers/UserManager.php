<?

class UserManager
{
	public static function registerUser($parameters){
		$newUser = new UserModel();
		$newUser->populate($parameters);
		$newUser->validateData();
		$newUser->save();
		return $newUser;
	}

	public static function login($nickname, $password){
		$user = UserModel::getList(array("nickname"=>$nickname, "password"=>$password));
		if(!$user){
			throw new Exception("Invalid Credentials");
		}

		//SET SESSSION AND/OR COOKIE
		return;
	}

	public static function logout(){

	}

	public static function followUser($followerId, $followeeId){
		$obj = new UserFollowModel();
		$obj->followeeId = $followeeId;
		$obj->followerId = $followeeId;
		$obj->save();
		return $obj;
	}
}