<?php
/*
 * TestNotification
 * 
 * @author	J. Alvin Harris <jalvin.code@gmail.com>
 * @author	Sherwin Gaddis <>
 *
 * This if the base class for Notifications to be sent
 */

namespace OpenEMR\Notifications;

include 'NotificationBase.php';

//use PHPMailerOAuthGoogle;
use PHPMailer\PHPMailer\PHPMailer;
use OpenEMR\Common\Crypto\CryptoGen;
use OpenEMR\Notifications\Base;

class TestNotification extends NotificationBase
{
    public $Mailer;
    public $SMTPAuth;
    public $Host;
    public $Username;
    public $Password;
    public $Port;
    public $CharSet;

    public function __construct()
    {
       $this->msg = "";
	   $this->recipientEmail = "";
    }
	
	/****************************************
	 * RUN
	 * Send all neccessary emails
	 * get all data, create the body, call sendNotification
	 ****************************************/
	public function run()
	{
		if ($this->recipientEmail != "")
		{
			$email = $this->recipientEmail;
		}
		else
		{
			//$email = "jalvin.code@gmail.com"; // personal test email
			$email = $GLOBALS['SMTP_USER']; // to use system email
		}

		$body = "<h3>This is a test sent to $email from Kuna Counseling Center</h3>";
		
		if ($this->msg != "")
		{
			$msg = $this->msg;
			$body .= "<h4>$msg</h4>";
		}

		$subject = "KCC TEST";
		$this->sendNotification($body, $email, $email, $subject);
		return;
	}

	/****************************************
	 * ADD MESSAGE
	 * Adds a message to the email
	 ****************************************/
	public function addMessage($text)
	{
		$this->msg = $text;
		return;
	}

	/****************************************
	 * ADD RECIPIENT
	 * Sets recipient of test email
	 ****************************************/
	public function addRecipient($email)
	{
		$this->recipientEmail = $email;
		return;
	}

	private $msg;
	private $recipientEmail;
}
