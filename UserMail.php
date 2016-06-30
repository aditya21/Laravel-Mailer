<?php
/*phptext class, version 1.0
created by www.w3schools.in (Gautam kumar)
April 26, 2014
*/
namespace app\Helpers;

class UserMail
{
	public static function send($subject, $email, $data, $view,$extra = array())
	{
	    \Mail::send($view, $data, function($message) use ($data, $email, $subject,$extra)
        {
          self::buildMail($message,$extra,$email, $subject);
        });
	}

	public static function sendToMany($subject, $emails = array(), $data, $view)
	{
	    foreach ($emails as $email) {
			\Mail::send($view, $data, function($message) use ($data, $email, $subject,$extra)
	        {
	          self::buildMail($message,$extra,$email, $subject);
	        });
	    }
	}

	public static function sendToGroup($subject, $emails = array(), $data, $view)
	{
	    \Mail::send($view, $data, function($message) use ($data, $email, $subject)
        {
			\Mail::send($view, $data, function($message) use ($data, $email, $subject,$extra)
	        {
	          self::buildMail($message,$extra,$email, $subject);
	        });
        });
	}

	private static function buildMail($message, $extra, $email, $subject)
	{
		$message->subject($subject);

		$message->from(env('MAIL_FROM'), env('MAIL_NAME'));

		$message->to($email);

		if (isset($extra['cc'])) {
			$message->cc($extra['cc'], $name = null);
		}

		if (isset($extra['bcc'])) {
			$message->bcc($extra['bcc'], $name = null);
		}

		if (isset($extra['replyTo'])) {
			$message->replyTo($extra['replyTo'], $name = null);
		}

		if (isset($extra['attach'])) {
			$message->attach($extra['attach']);
		}
		
		return $message;
	}	


}
?>