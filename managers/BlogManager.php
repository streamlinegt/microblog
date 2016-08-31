<?

class BlogManager
{
	
	public static function newBlog(){
		$blog = new BlogModel();
		return $blog;
	}

	public static function createBlog($parameters){
		$blog = self::newBlog();
		$blog->populate($parameters);
		$blog->save();
		return $blog;
	}

	public static function getById($id){
		return BlogModel::getById($id);
	}

	public static function saveBlog($blog){
		$blog->save();
	}
}