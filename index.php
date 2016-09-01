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


//ACCESS API WITHOUT KEY
echo "TEST: Access api without a key: Result: ";
$expectedResponse = false;
ob_start();
//FAKE THE $_POST ARRAY
$_POST = array('title'=>"My Title", "blog"=>"My Blog djflsdkfj", "published"=>true, "userId"=>12);
try{
	$controller = new BlogController();
	$controller->SaveBlog();
}
catch(Exception $ex){
	echo json_encode(array("response"=>false, "error"=>$ex->getMessage()));
}

$result = ob_get_clean();
$json = json_decode($result);
if($json->response === $expectedResponse)
	Echo "Passed";
else
	echo "Failed";

echo "<br /><br />";




//ADD BLOG WITH TOO LONG OF BLOG, SHOULD FAIL
echo "TEST: Try and post a blog with longer than 80 chars: Result: ";
$expectedResponse = false;
$_GET['apiKey'] = "sdw2423lkslkfm3klk234";
ob_start();
//FAKE THE $_POST ARRAY
$_POST = array('title'=>"My Title", "blog"=>"My Blog klajdlsdkjfslkdfjslkfsdjflsdkfjsdlkfjsdlfkjdsflksdjflsdkfjsldkfjsldkfjsdlkfjslfdkjslkdfjsldkfjsdlkfjsdlkfjsldfkjsldfkjsldfkjsldkfjsldkfjsldkfjsldkfjslkdfjslkdfjlskdfjlskdfjlskdfjslkdfjsdlkfjslkdfjslkdfjslkdfjlsdkfjslkdfjslkdfjsldkfjslkdjflskdjfslkdjflsdkfj", "published"=>true, "userId"=>12);
$controller = new BlogController();
$controller->SaveBlog();
$result = ob_get_clean();
$json = json_decode($result);
if($json->response === $expectedResponse)
	Echo "Passed";
else
	echo "Failed";

echo "<br /><br />";


//ADD BLOG WITH RIGHT BLOG
echo "TEST: Try and post a blog with less than 80 chars: Result: ";
$expectedResponse = true;
$_GET['apiKey'] = "sdw2423lkslkfm3klk234";
ob_start();
//FAKE THE $_POST ARRAY
$_POST = array('title'=>"My Title", "blog"=>"My Blog ksdkfj", "published"=>true, "userId"=>12);
$controller = new BlogController();
$controller->SaveBlog();
$result = ob_get_clean();
$json = json_decode($result);
if($json->response === $expectedResponse)
	Echo "Passed";
else
	echo "Failed";

echo "<br /><br />";



//Update Blog
echo "TEST: Update Blog with is 7: Result: ";
$expectedResponse = true;
$_GET['apiKey'] = "sdw2423lkslkfm3klk234";
ob_start();
//FAKE THE $_POST ARRAY
$_POST = array('id'=>7, 'title'=>"My Title","userId"=>12);
$controller = new BlogController();
$controller->SaveBlog();
$result = ob_get_clean();
$json = json_decode($result);
if($json->response === $expectedResponse)
	Echo "Passed";
else
	echo "Failed<br />".print_r($json);

echo "<br /><br />";



//RETREIVE A BLOG
echo "TEST: get blog 1: Result: ";
$expectedResponse = true;
$_GET['apiKey'] = "sdw2423lkslkfm3klk234";
ob_start();
//FAKE THE $_POST ARRAY
$_POST = array('id'=>1);
$controller = new BlogController();
$controller->GetBlog();
$result = ob_get_clean();
$json = json_decode($result);
if($json->response === $expectedResponse  && $json->data != null)
	Echo "Passed";
else
	echo "Failed<br />".print_r($json);

echo "<br /><br />";

//RETREIVE A Array of BLOGS
echo "TEST: get list of blogs: Result: ";
$expectedResponse = true;
$_GET['apiKey'] = "sdw2423lkslkfm3klk234";
ob_start();
//FAKE THE $_POST ARRAY
$_POST = array('userId'=>1);
$controller = new BlogController();
$controller->GetBlog();
$result = ob_get_clean();
$json = json_decode($result);
if($json->response === $expectedResponse  && $json->data != null)
	Echo "Passed";
else
	echo "Failed<br />".print_r($json);

echo "<br /><br />";




//TEST: add a new user to the DB
//EXPECTED RESULT: Pass
echo "Test: Create new user. Result: ";
$expectedResponse = true;
$_GET['apiKey'] = "sdw2423lkslkfm3klk234";
ob_start();

$_POST = array('nickname'=>'streamlinegt', 'password'=>'meat', 'email'=>'benroberts@sdsnow.net');
$controller = new UserController();
$controller->registerUser();
$result = ob_get_clean();
$json = json_decode($result);
if($json->response === $expectedResponse)
	Echo "Passed";
else
	echo "Failed";

echo "<br /><br />";


//TEST: add a new user to the DB, bad email
//EXPECTED RESULT: Pass
echo "Test: Create new user, bad email address. Result: ";
$expectedResponse = false;
$_GET['apiKey'] = "sdw2423lkslkfm3klk234";
ob_start();

$_POST = array('nickname'=>'streamlinegt', 'password'=>'meat', 'email'=>'benroberts@');
$controller = new UserController();
$controller->registerUser();
$result = ob_get_clean();
$json = json_decode($result);
if($json->response === $expectedResponse)
	Echo "Passed";
else
	echo "Failed";

echo "<br /><br />";


//TEST: Follow a user, both parms
//EXPECTED RESULT: Pass
echo "Test: User 1 to follow user 2. Result: ";
$expectedResponse = true;
$_GET['apiKey'] = "sdw2423lkslkfm3klk234";
ob_start();

$_POST = array("followerId"=>1, "followeeId"=>2);
$controller = new UserController();
$controller->Follow();
$result = ob_get_clean();
$json = json_decode($result);
if($json->response === $expectedResponse)
	Echo "Passed";
else
	echo "Failed";

echo "<br /><br />";


//TEST: Follow a user, One param
//EXPECTED RESULT: Fail
echo "Test: User 1 to follow no one. Result: ";
$expectedResponse = false;
$_GET['apiKey'] = "sdw2423lkslkfm3klk234";
ob_start();

$_POST = array("followerId"=>1);
$controller = new UserController();
$controller->Follow();
$result = ob_get_clean();
$json = json_decode($result);
if($json->response === $expectedResponse)
	Echo "Passed";
else
	echo "Failed";

echo "<br /><br />";