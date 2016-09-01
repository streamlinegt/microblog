<?

class UserFollowModel extends AbstractModel
{
	protected static $tableName = "Data.Follow";
	public $id;
	public $followerId;
	public $followeeId;

	protected static $dataModel = array
	(
		"id" => "INT(11)",
		"followeeId" => "INT(11)",
		"followerId" => "INT(11)"
	);


	public function UserFollowModel(){

	}

	//OVERLOAD SAVE FUNCTION TO CHECK FIRST
	public function save(){
		//MUST HAVE BOTH PARAMS
		if(!isset($this->followeeId) || !isset($this->followerId))
			throw new Exception("Missing one or both user params");

		if(self::getList(array('followeeId'=>$this->followeeId, 'followerId'=>$this->followerId)))
			return; //NO NEED TO THROW, JUST DONT INSERT
		return parent::save();
	}
}