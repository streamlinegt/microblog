<?

class AbstractApiController extends AbstractController
{
	
	public function AbstractApiController(){
		$apiKey = $this->getParam("apiKey");
		if(!$apiKey)
			throw new Exception('Invalid Api Key Provided');

		//AUTHENTICATE APIKEY AGAINST DATABASE, IF EXPIRED OT NONE EXISITENT, THROW
		
	}

}