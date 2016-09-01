<?

class BlogController extends AbstractApiController
{
	/**
	 * @desc
	 * gets a single blog based on a get or post id
	 */
	public function GetBlog(){
		$id = $this->getParam("id");
		$blog = BlogManager::getById($id);
		if(!$blog){
			echo json_encode(array("response"=>false, "error"=>"Blog with id {$id} not found"));
			return;
		}
		echo json_encode(array("response"=>true,"data"=>$blog));
	}

	/**
	 * @desc
	 * gets a list of blogs based on the userId,
	 * if none provided, will grab list of all users
	 */
	public function GetBlogs(){
		$params = array();
		$params['userId'] = $this->getParam("userId");
		$blogs = BlogModel::getBlogs($params);
		echo json_encode(array("response"=>true,"data"=>$blogs));
	}

	/**
	 * @desc
	 * Attempts to save the blog, will return with an error if one throw, 
	 * or return with success and the blog object
	 */
	public function SaveBlog(){
		try{
			$blog = BlogManager::createBlog(self::getAllPostParams());
		}
		catch(Exception $ex){
			http_response_code(400);
			echo json_encode(array("response"=>false,"error"=>$ex->getMessage()));
			return;
		}
		

		echo json_encode(array("response"=>true,"data"=>$blog));
	}

}