<?php 
/**
* 
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'mailer/Exception.php';
require 'mailer/PHPMailer.php';
require 'mailer/SMTP.php';

class Mail extends PHPMailer
{
	
	function __construct($arg = false)
	{
		parent::__construct($arg);
	}
}
