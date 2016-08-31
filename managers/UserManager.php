<?

class UserManager
{
	/**
	 * @desc
	 * Called when a user registers
	 * Checks params and saves the user
	 * 
	 * @param array $parameters associaive array of data
	 * @return UserModel
	 */
	public static function registerUser($parameters){
		$newUser = new UserModel();
		$newUser->populate($parameters);
		$newUser->validateData();
		$newUser->save();
		return $newUser;
	}


	/**
	 * @desc
	 * Check a users authenticatoin, normally would require a lot more then this
	 * 
	 * @param string $nickname
	 * @param string $password TODO: use some type of password encryption
	 */
	public static function login($nickname, $password){
		$user = UserModel::getList(array("nickname"=>$nickname, "password"=>$password));
		if(!$user){
			throw new Exception("Invalid Credentials");
		}

		//SET SESSSION AND/OR COOKIE
		return;
	}

	public static function logout(){
		//REMOVE COOKIES ANF/OR SESSION
	}

	/**
	 * @desc
	 * Adda a row to the follow table with data
	 * 
	 * @param int $followerId Id of user who is following someone
	 * @param int $followeeId id of the person being followed
	 * 
	 * @return UserFollowMOdel object
	 */
	public static function followUser($followerId, $followeeId){
		$obj = new UserFollowModel();
		$obj->followeeId = $followeeId;
		$obj->followerId = $followeeId;
		$obj->save();
		return $obj;
	}
}