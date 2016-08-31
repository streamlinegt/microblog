<?

//GOING TO TEST EVERYTHInG HERE!

include("models/AbstractModel.php");
include("models/BlogModel.php");
include("models/UserModel.php");
include("models/UserFollowModel.php");
include("managers/BlogManager.php");
include("managers/UserManager.php");
include("controllers/AbstractController.php");
include("controllers/api/AbstractApiController.php");
include("controllers/api/BlogController.php");
include("controllers/api/UserController.php");

$controller = new BlogController();



//FAKE THE $_POST ARRAY
$_POST = array('title'=>"My Title", "blog"=>"My Blog", "published"=>true, "userId"=>12);

//$controller->SaveBlog();


//ADD NEW USER
$_POST = array('nickname'=>'streamlinegt', 'password'=>'meat', 'email'=>'benroberts@sdsnow.net');
$controller = new UserController();
$controller->registerUser();