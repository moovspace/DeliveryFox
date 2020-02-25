<?php
/* Your class PhpApix namespace !!! */
namespace PhpApix\Api\Sample;

// Import classes
use \Exception;

// Import composer class (require phpmailer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Email
{
    function Send($email = '', $subject = '', $html = ''){
		echo "<br> Send email with smtp here ...";

		// Send email with local smtp
		// $this->MailerSmtp($email, $subject, $html);

		// Send email with external smtp
		// Config file: src/Setings/Config.php
		// $this->MailerSmtp($email, $subject, $html, self::SMTP_FROM_EMAIL, self::SMTP_FROM_USER, self::SMTP_USER, self::SMTP_PASS, self::SMTP_HOST, self::SMTP_TLS, self::SMTP_AUTH, self::SMTP_DEBUG);
	}

    function MailerSmtp($email, $subject, $html, $files = [], $from_email = 'admin@local.host', $from_user = 'Admin', $smtpUser = '', $smtpPass = '', $smtpHost = '127.0.0.1', $smtpTls = false, $smtpAuth = false, $smtpPort = 25, $smtpDebug = 0){
		$m = new PHPMailer(true); // Passing `true` enables exceptions
		try {
			//Server settings
			$m->SMTPDebug = (int) $smtpDebug;
			$m->isSMTP();
			$m->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));
			$m->CharSet = "UTF-8";
			// Host, port
			$m->Host = $smtpHost;
			$m->Port = $smtpPort;
			// Auth
			$m->SMTPAuth = $smtpAuth;
			$m->Username = $smtpUser;
			$m->Password = $smtpPass;
			// Ssl
			if($smtpTls == true){
				$m->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
			}
			// Sender
			$m->setFrom($from_email, $from_user);
			$m->addReplyTo($from_email, $from_user);
			// Add a recipient
			$m->addAddress($email);
			// Subject
			$m->Subject = $subject;
			// Html
			$m->isHTML(true); // Set email format to HTML
			$m->Body    = $html;
			$m->AltBody = 'This is html message!';
			// Add files from array
			foreach ($files as $path) {
				if(file_exists($path)){
					$m->addAttachment($path);
				}
			}
			// Send
			if (!$m->send()) {
				$this->ErrorMsg = $m->ErrorInfo;
				$this->Error = 0;
				return 0;
			}else{
				$this->ErrorMsg = "Email has been sent.";
				$this->Error = 1;
				return 1;
			}
		} catch (Exception $e) {
			// echo $e->getMessage();
			$this->ErrorMsg = $m->ErrorInfo;
			$this->Error = 0;
			return 0;
		}
	}
}
?>
