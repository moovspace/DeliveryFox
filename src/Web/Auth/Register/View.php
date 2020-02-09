<?php
namespace MyApp\Web\Auth\Register;

use \Exception;
use PhpApix\Mysql\Db;
use MyApp\App\Component;
use MyApp\App\Email\Email;
use MyApp\App\Email\SendEmail;
use MyApp\App\Email\EmailTheme;
use MyApp\App\Translate\Trans;

class View extends Component
{
	static function IsValidEmail(string $email)
	{
		try
		{
			// Test email
			Email::FromString($email);
			return 1;
		}
		catch(Exception $e)
		{
			return 0;
		}
	}

	/**
	 * Get activation email with link
	 * params in html theme: {URL}
	 *
	 * @param string $code activation code
	 * @return string Message html code
	 */
	static function ActivationEmailHtml($code)
	{
		$protocol = 'http://';

		if(strtolower(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']) == 'on')
		{
			$protocol = 'https://';
		}

		// Activation url
		$url = $protocol.$_SERVER['HTTP_HOST'].'/confirm?code='.$code;

		// Activation email theme
		$theme = EmailTheme::GetTheme('activation', ['URL' => $url]);

		return (string) $theme;
	}

    static function Data(){
        try
		{
			if(!empty($_POST))
			{
				if(!self::IsValidEmail($_POST['email']))
				{
					return -2;
				}

				if(empty($_POST['pass']) || strlen($_POST['pass']) < 6)
				{
					return -4;
				}

				$p1 = $_POST['email'];
				$p2 = md5($_POST['pass']);
				$p3 = $_SERVER['REMOTE_ADDR'];
				$code = md5(microtime());

				// Mysql from static method with singleton (Db class)
				$db = Db::getInstance();
				$r = $db->Pdo->prepare("INSERT INTO user(username,code,email,pass,ip) VALUES(UUID(),'$code',:s1,'$p2',:s3)");
				$r->execute([':s1' => $p1, ':s3' => $p3]);
				$id = $db->Pdo->lastInsertId();

				if($id > 0){
					// Send email here
					$em = new SendEmail();
					$ok = $em->Send($p1, 'Please confirm your email', self::ActivationEmailHtml($code));

					if($ok != 1){
						// Error email send
						return -3;
					}
				}

				return $id;
			}
		}
		catch(Exception $e)
		{
			// echo "ERROROR " . $e->getMessage();
			return -1;
        }
    }

    static function Show($arr = null)
    {
		// Translate
		$t = new Trans('/src/Web/Auth/Lang', 'pl');

        // Get data
		$id = self::Data();

		if($id > 0) {
			$err = '<div class="green"> '.$t->Get('REGISTER_OK').' </div>';
		} else if($id == -4) {
			$err = '<div class="red"> '.$t->Get('PASS_ERROR').' </div>';
		} else if($id == -3) {
			$err = '<div class="red"> '.$t->Get('SEND_ERROR').' </div>';
		} else if($id == -2) {
			$err = '<div class="red"> '.$t->Get('EMAIL_ERROR').' </div>';
		} else if($id == -1) {
			$err = '<div class="red"> '.$t->Get('REGISTER_ACCOUNT_EXISTS').' </div>';
		} else {
			$err = '';
		}

		$arr = new \stdClass();
		$arr->btn = $t->Get('SIGNIN');
		$arr->title = $t->Get('REGISTER_TITLE');
		$arr->login = $t->Get('SIGNUP');
		$arr->email = $t->Get('EMAIL_PLACEHOLDER');
		$arr->pass = $t->Get('PASS_PLACEHOLDER');
		$arr->emailerror = $t->Get('EMAIL_ERROR');
		$arr->passerror = $t->Get('PASS_ERROR');
		$arr->forgot = $t->Get('FORGOT_PASS');
		$arr->need = $t->Get('LOGIN_NOW');
		$arr->register = $t->Get('LOGIN');
		$arr->error = $err;
		$arr->post_email = '';
		if(!empty($_POST['email'])){
			$arr->post_email = $_POST['email'];
		}

		echo self::Html($arr);
	}

	static function Html($arr){
		return '
		<div class="box-top">
			<img src="/src/Web/Auth/logo.png" alt="logo" class="logo">
			<a href="/login" class="button-signin">' . $arr->btn . '</a>
		</div>
		<div class="box-100">

			<div class="box-50">
				<h1 class="h1"> ' . $arr->title . ' </h1>

				<form method="POST">
					<div id="error-form">' . $arr->error . '</div>

					<div class="box-input">
						<input id="email" value="'.$arr->post_email.'" type="text" name="email" class="input" onfocus="PlaceholderUp(this)" onfocusout="Placeholder(this)" onchange="IsEmail(this)" onkeyup="IsEmail(this)" data-error="' . $arr->emailerror . '">
						<div class="placeholder">' . $arr->email . '</div>
						<i class="fas fa-at icon"></i>
					</div>
					<div id="error-email"></div>

					<div class="box-input">
						<input id="pass" type="password" name="pass" class="input" onfocus="PlaceholderUp(this)" onfocusout="Placeholder(this)" onchange="IsPass(this)" onkeyup="IsPass(this)" data-error="' . $arr->passerror . '">
						<div class="placeholder">' . $arr->pass . '</div>
						<i class="fas fa-lock icon"></i>
					</div>
					<div id="error-pass"></div>

					<input type="submit" name="add" value="' . $arr->login . '" class="btn-login">
				</form>

				<div class="box-small">
					<div class="register-link"> ' . $arr->need . ' <a href="/login">' . $arr->register . '</a> </div>

					<div class="pass-link"> <a href="/password">' . $arr->forgot . '</a> </div>
				</div>
			</div>

			<div class="box-50 bg">
				<img src="/src/Web/Auth/image.png" class="image">
			</div>

			<div id="lang">
				<a data-lang="pl" class="lang" onclick="Lang(this);"> PL </a>
				<a data-lang="en" class="lang" onclick="Lang(this);"> EN </a>
			</div>

		</div>
		';
	}

	static function Head()
	{
		return [
			'<link rel="stylesheet" href="/src/Web/Auth/auth.css">',
			'<script defer src="/src/Web/Auth/auth.js"></script>'
		];
	}
}
?>