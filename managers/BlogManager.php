<?

class BlogManager
{
	/**
	 * @desc
	 * Cretes a new blogmodel
	 * 
	 * @return object BlogModel
	 */
	public static function newBlog(){
		$blog = new BlogModel();
		return $blog;
	}

	/**
	 * @desc
	 * Cretes a new blogmodel and populates it with data
	 * 
	 * @return object BlogModel
	 */
	public static function createBlog($parameters){
		$blog = self::newBlog();
		$blog->populate($parameters);
		$blog->save();
		return $blog;
	}

	//GRAB A BlogModel By Its Id
	public static function getById($id){
		return BlogModel::getById($id);
	}


	//SAVE THE BLOG
	public static function saveBlog($blog){
		$blog->save();
	}
}