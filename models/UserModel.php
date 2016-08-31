<?

class UserModel extends AbstractModel
{
	protected static $tableName = "Data.Users";

	public $dataModel;

	public $id;
	public $nickname;
	public $email;
	public $isActive;

	public function UserModel(){
		//CREATE DATA MODEL
		$this->dataModel["id"] = "int(11)";
		$this->dataModel["nickname"] = "varchar(20)";
		$this->dataModel["email"] = "varchar(255)";
		$this->dataModel["password"] = "varchar(255)";
		$this->dataModel["isActive"] = "boolean";
	}
	


	public function validateData(){
		if (!isEmailValid($this->email))
			throw new Exception("Email address {$this->email} is not a valid email address.");
	}

	private function isEmailValid($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL)
	}

	
}