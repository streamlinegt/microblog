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

	public static function getBlogs($params, $limit = null){
		return self::getList($params, array('date','DESC'), $limit);
	}


	public function validateData(){
		if(!isset($this->userId)){
			throw new Exception("Invalid user id: {$this->userId}");
		}
		parent::validateData();
	}

	

	public function save() {
		$this->validateData();
		parent::save();
	}



}