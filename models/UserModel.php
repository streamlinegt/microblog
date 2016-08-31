<?

class UserModel extends AbstractModel
{
	protected static $tableName = "Data.Users";

	protected static $dataModel = array
	(
		"id" => "INT(11)",
		"nickname" => "VARCHAR(255)",
		"email" => "VARCHAR(255)",
		"password" => "VARCHAR(100)",
		"isActive" => "BOOLEAN"
	);

	public $id;
	public $nickname;
	public $email;
	public $isActive;

	public function UserModel(){
		
	}
	
	//ADD A CHECK TO SEE IF EMAIL IS VALID
	public function validateData(){
		if (!self::isEmailValid($this->email))
			throw new Exception("Email address {$this->email} is not a valid email address.");

		parent::validateData();
	}

	//PRIVATE FUNCTION FOR CHECKING EMAIL ADDRESS
	private function isEmailValid($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	
}