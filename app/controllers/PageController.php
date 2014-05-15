<?php
use Acme\Repositories\PageRepositoryInterface;
use Acme\Services\ImageCreator;
use Acme\Services\CurlServices;
use Acme\Mailers\Mailer as Mailer;
use Acme\Repositories\UserRepositoryInterface;

class PageController extends \BaseController {

	protected $PAGES;
	protected $image;
	protected $request;
	protected $mailer;
	protected $USER;

	public function __construct(PageRepositoryInterface $PAGES,ImageCreator $image,CurlServices $request,Mailer $mailer,UserRepositoryInterface $USER)
	{
		$this->USER=$USER;
		$this->mailer=$mailer;
		$this->request=$request;
		$this->image=$image;
		$this->PAGES=$PAGES;				
	}


	public function index()
	{

		$pages = $this->_getPages();

		if($pages)
		{
			return View::make('pages.index')->with('pages',$pages);
		}
		return Redirect::to('/facebookpages');
	}


	private function _getPages()
	{
		$pages=$this->PAGES->getPages(Session::get('uid'));
		return $pages;
	}


	public function facebookpages()
	{
		$code = Input::get( 'code' );

		$fb = OAuth::consumer( 'Facebook' );

		if ( !empty( $code ) ) {
			$token = $fb->requestAccessToken( $code );
			$a=$token->getAccessToken();

			$result = json_decode( $fb->request( '/me/accounts' ),true );

			$pid=$this->savePages($result);

			return Redirect::to('/pages')->withCookie(Cookie::make('pid', $pid,10));;
		}

		else {
			$url = $fb->getAuthorizationUri();
			return Redirect::to( (string)$url);
		}

	}

	private function savepages($pages){

		$pid= $this->PAGES->savepages($pages);
		return $pid;
	}

	public function show($id)
	{
		Session::put('page_id',$id);
		$b= $this->request->getPage($id);

		Session::put('likes',$b->likes);
		Session::put('cover_id',$b->cover->cover_id);
		Session::put('offset_y',$b->cover->offset_y);
		Session::put('offset_x',$b->cover->offset_x);

//		dd();

		$user=$this->USER->getemailid(Session::get('page_id'));
		$data=array('likes'=>Session::get('likes'));


//i have closed this to stop the emails send to the client
		
		//$result=$this->sendmail($user,$data);

		$getyou=$this->getimage();
		return;
	}

	public function sendmail($user,$data)
	{
		$result= $this->mailer->sendTo($user,'Welcome to owlgrin','emails.welcome',$data);
		return;
	}

	private function get_accesstoken($id)
	{
		$page = $this->PAGES->getPageAccessToken($id);
		return $page;
	}

	public function storeimage()
	{
		$photo_access_token=$this->get_accesstoken(Session::get('page_id'));				
		$text=Session::get('likes');

		$img =$this->image->makeimage($text);
		
		$offset_y=Session::get('offset_y');
		$offset_x=Session::get('offset_x');
		$page_id=Session::get('page_id');

		$id=$this->image->postimagefb($offset_y,$offset_x,$photo_access_token,$page_id);
		return $id;		
	}

	public function getimage()
	{
		$result=$this->storeimage();
		$photo_access_token=$this->get_accesstoken(Session::get('page_id'));		
		$offset_y=Session::get('offset_y');
		$offset_x=Session::get('offset_x');

		$id=$this->image->postcoverfb($result,$offset_x,$offset_y,$photo_access_token);
		return;		
	}


	public function getcronjob()
	{
		$pages = DB::table('pages')
		->get();

		foreach ($pages as $index => $page) 
		{
			$this->show($page->pid);		
		}		
		return false;
	}

}