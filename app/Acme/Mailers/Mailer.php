<?php namespace Acme\Mailers;

use Mail;
class Mailer{
	public function sendTo($user,$subject,$view,$data=array())
	{
		Mail::send($view,$data,function($message) use($user,$subject)
		{
			$message->to($user)
			->subject($subject);
		});
	}
}