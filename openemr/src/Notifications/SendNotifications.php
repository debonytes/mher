<?php
/*
 * Send Notifications
 *
 * @author	  J. Alvin Harris <jalvin.code@gmail.com>
 *
 * This sends all the required notifications.
 */

namespace OpenEMR\Notifications;

//use PHPMailerOAuthGoogle;
use PHPMailer\PHPMailer\PHPMailer;
use OpenEMR\Common\Crypto\CryptoGen;

class SendNotifications
{
    public function __construct()
    {
        //Maybe some stuff later

    }
	
	/****************************************
	 * RUN
	 * Send all neccessary notification emails 
	 * @param $debug	sends a test email out
	 * @param $
	 ****************************************/
	public function run($debug=false, $continueAfterDebug=false, $testEmail="")
	{
		// list of each Notifcation class derived from Notification Base
		// delcare each one and run
		
		if ($GLOBALS['user_credential_expiration_lockout'] or $GLOBALS['credential_expiration_alert'] >= 0)
		{
			
			$notificationTest = new TestNotification;
			$notificationTest->addRecipient($testEmail);

			// TEST
			if ($debug and !$continueAfterDebug)
			{
				$notificationTest->addMessage("Solo Debug enabled in Notification System");
				$notificationTest->run();
			}
			// NORMAL RUN
			else
			{
				// send all the emails

				// should we send a test email
				if ($debug and $continueAfterDebug)
				{
					$notificationTest->addMessage("Debug enabled in Notification System. Continuing with Notifications");
					$notificationTest->run();
				}

				$credentialNotification = new EmployeeCredentialNotification;
				$credentialNotification->run();

				// ADD NEW NOTIFICATIONS HERE
				/* ie
				$notification = new NotificationClass;
				$notification->run();
				*/
			}
		}
		else
		{
			if ($debug)
			{
				$notificationTest = new TestNotification;
				$notificationTest->addMessage("Notification System Disabled but is in Debug");
				$notificationTest->run();
			}
		}

		return;
	}


}
