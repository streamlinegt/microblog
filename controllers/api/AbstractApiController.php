<?

class AbstractApiController extends AbstractController
{
	
	//CHECK AUTH IF USING APICONTROLLER
	public function AbstractApiController(){
		$apiKey = $this->getParam("apiKey");
		if(!$apiKey)
			throw new Exception('Invalid Api Key Provided');

		//AUTHENTICATE APIKEY AGAINST DATABASE, IF EXPIRED OT NONE EXISITENT, THROW
		//CALL FOR INSTANCE THE ApiManager TO CHECK AUTHENTICITY OF KEY

	}

}