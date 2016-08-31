<?

class UserFollowModel extends AbstractModel
{
	protected static $tableName = "Data.Follow";
	public $id;
	public $followerId;
	public $followeeId;

	protected $dataModel = array
	(
		"id" => "INT(11)",
		"followeeId" => "INT(11)",
		"followerId" => "INT(11)"
	);


	public function UserFollowModel(){

	}
}