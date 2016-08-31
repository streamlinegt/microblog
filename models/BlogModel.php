<?

class BlogModel extends AbstractModel
{
	protected static $tableName = "Data.Blogs";

	public $id;
	public $title;
	public $blog;
	public $date;
	public $published;
	
	protected static $dataModel = array
	(
		"id"=> "int(11)",
		"userId"=> "int(11)",
		"title" => "VARCHAR(255)",
		"blog" => "VARCHAR(80)",
		"date" => "DATETIME",
		"published" => "boolean"
	);

	private static $_maxBlogLength = 80;


	public function BlogModel(){
		
	}

	/**
	 * @desc 
	 * Gets blogs based on params and returns parent call
	 * 
	 * @param array $params associative array
	 * @param array|string $limit number of blogs to grab
	 */
	public static function getBlogs($params, $limit = null){
		return self::getList($params, array('date','DESC'), $limit);
	}

	//OVERLOADED METHOD, DOES EXTRA CHECK BEFORE CALLING PARENT
	public function validateData(){
		
		//IF NEW MESSAGE, NEED USER ID
		if($this->isNew() && !isset($this->userId)){
			throw new Exception("Invalid user id: {$this->userId}");
		}

		if($this->isNew() && !isset($this->blog))
			throw new Exception("Must have a message to post to timeline");

		if(isset($this->blog) && strlen($this->blog) > static::$_maxBlogLength)
			throw new Exception("Message cannot be longer than 80 characters");

		parent::validateData();
	}

	
	//OVERLOADED SAVE FUNCTION TO VALIDATE THE DATA FIRST
	public function save() {
		$this->validateData();
		parent::save();
	}



}