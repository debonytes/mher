<?php
/**
 * Employee Credential Notification
 *
 * @author	  J. Alvin Harris <jalvin.code@gmail.com>
 */


namespace OpenEMR\Notifications;

//use PHPMailerOAuthGoogle;
use PHPMailer\PHPMailer\PHPMailer;
use OpenEMR\Common\Crypto\CryptoGen;

class ExampleNotification extends NotificationBase
{
    public function __construct()
    {
		// nothing for now
    }
	
	/****************************************
	 * RUN
	 * Send all neccessary emails for credential expirations to users
	 ****************************************/
	public function run()
	{
		//$body = buildBody()
		//$this->sendNotification($body, $email, $recipientName='', $subject='', $bcc='', $bccName='', $reply='', $replyName='');
		return;
	}

	/****************************************
	 * BUILD BODY
	 ****************************************/
    public function buildBody()
    {
		return $body;
    }
}
