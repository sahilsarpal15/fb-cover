<?php
use Acme\Repositories\UserRepositoryInterface;

class UserController extends \BaseController {
	protected $USER;

	public function __construct(UserRepositoryInterface $USER)
	{
		$this->USER=$USER;
	}


	public function index()
	{

		$user = $this->_getUser();


		if($user)
		{
			Session::put('uid', $user['id']);
			Session::put('user_accesstoken', $user['access_token']);
			Session::put('user_name',$user['name']);

			return Redirect::to('/pages');
		}
		return View::make('users.index');
	}


	public function facebook()
	{
		$fb = OAuth::consumer('Facebook');
		
		$code=Input::get('code');

		if($code)
		{
			$token = $fb->requestAccessToken($code);	

			$user = json_decode($fb->request('/me'), true);
			
			$user['oauth_provider'] = 'facebook';
			$user['user_accesstoken'] = $token->getAccessToken();

			$uid = $this->_saveUser($user);

			return Redirect::to('/')->withCookie(Cookie::make('uid', $uid,10));
		}
		else
		{			
			$user = $this->_getUser();
			if($user)
			{
				return Redirect::to('/');
			}
			else
			{
				$url = $fb->getAuthorizationUri();
				return Redirect::to((string)$url); 			
			}
		}
	}


	private function _saveUser($user)
	{
		$uid=$this->USER->saveUser($user);
		return $uid;
	}


	private function _getAccessTokenByUser($uid)
	{	
		$user = $this->USER->getAccessTokenByUser($uid);
		return $user;
	}

	private function _getUser()
	{
		$fb = OAuth::consumer('Facebook');

		if(Cookie::get('uid'))
		{
			$accessToken = $this->_getAccessTokenByUser(Cookie::get('uid'));

			if($accessToken)
			{
				$token = new OAuth\OAuth2\Token\StdOAuth2Token;
				$token->setAccessToken($accessToken);
				$token->setEndOfLife(time());
				$fb->getStorage()->storeAccessToken('Facebook', $token);
				$user = json_decode($fb->request('/me'), true);
				$user['access_token'] = $accessToken;
				return $user;
			}
		}
		return false;		
	}
}