<?php
namespace MyApp\Web\Auth\Pass;

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

	static function EmailHtml($pass)
	{
		$theme = EmailTheme::GetTheme('reset-password', ['PASSWORD' => $pass]);
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

				$email = $_POST['email'];
				$pass = substr(uniqid(),0,10);
				$md5 = md5($pass);

				$db = Db::getInstance();
				$r = $db->Pdo->prepare("UPDATE user SET pass = '$md5' WHERE email = :email");
				$r->execute([':email' => $email]);
				$id = $r->rowCount();

				if($id > 0){
					// Send email here
					$em = new SendEmail();
					$ok = $em->Send($email, 'Hi! Your new password.', self::EmailHtml($pass));

					if($ok != 1){
						// Error email send
						return -3;
					}
				}else{
					return -4;
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
		$t = new Trans('/src/Web/Auth/Lang', 'pl');

        // Get data
		$id = self::Data();

		if($id > 0) {
			$err = '<div class="green"> '.$t->Get('PASS_RESET_OK').' </div>';
		} else if($id == -1) {
			$err = '<div class="red"> '.$t->Get('PASS_RESET_DB').' </div>';
		} else if($id == -2) {
			$err = '<div class="red"> '.$t->Get('EMAIL_ERROR').' </div>';
		} else if($id == -3) {
			$err = '<div class="red"> '.$t->Get('SEND_EMAIL_ERROR').' </div>';
		} else if($id == -4) {
			$err = '<div class="red"> '.$t->Get('PASS_RESET_MAIL').' </div>';
		} else {
			$err = '';
		}

		$arr = new \stdClass();
		$arr->btn = $t->Get('SIGNIN');
		$arr->title = $t->Get('RESET_PASS');
		$arr->login = $t->Get('RESET');
		$arr->email = $t->Get('EMAIL_PLACEHOLDER');
		$arr->emailerror = $t->Get('INVALID_EMAIL');
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

					<input type="submit" name="submit" value="' . $arr->login . '" class="btn-login">
				</form>

				<div class="box-small">
					<div class="register-link"> ' . $arr->need . ' <a href="/login">' . $arr->register . '</a> </div>

					<div class="pass-link"> <a href="/password">' . $arr->forgot . '</a> </div>
				</div>
			</div>

			<div class="box-50 bg">
				<img src="/src/Web/Auth/image.png" class="image">
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