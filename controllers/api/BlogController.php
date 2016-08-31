<?

class BlogController extends AbstractController
{
	public function GetBlog(){
		$id = $this->getParam("id");
		$blog = BlogManager::getById($id);
		echo json_encode(array("response"=>http_response_code(200),"data"=>$blog));
	}

	public function GetBlogs(){
		$params = array();
		$params['userId'] = $this->getParam("userId");
		$blogs = BlogModel::getBlogs($params);
		echo json_encode(array("response"=>true,"data"=>$blogs));
	}

	public function SaveBlog(){
		try{
			$blog = BlogManager::createBlog(self::getAllPostParams());
		}
		catch(Exception $ex){
			http_response_code(400);
			echo json_encode(array("response"=>http_response_code(),"error"=>$ex->getMessage()));
			return;
		}
		

		echo json_encode(array("response"=>http_response_code(200),"data"=>$blog));
	}

}