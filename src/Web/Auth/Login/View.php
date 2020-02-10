<?php
namespace MyApp\Web\Auth\Login;

use \Exception;
use PhpApix\Mysql\Db;
use MyApp\App\Component;
use MyApp\App\Email\Email;
use MyApp\App\Translate\Trans;
// Html
use MyApp\Web\Auth\Html\TopMenu;
use MyApp\Web\Auth\Html\ChangeLang;

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

    static function Data(){
        try
		{
			if(!empty($_POST)){

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

				$db = Db::getInstance(); // Singleton
				$r = $db->Pdo->prepare("SELECT id,role,active FROM user WHERE email = :s1 AND pass = :s2");
				$r->execute([':s1' => $p1, ':s2' => $p2]);
				$user = $r->fetchAll();

				if(!empty($user))
				{
					// Set user session
					if($user[0]['id'] > 0){
						$_SESSION['user'] = $user[0];
						header("Location: /panel");
						exit;
					}
				}

				return -3;
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

		// Get data from db
		$id = self::Data();

		if($id > 0) {
			$err = '<div class="green"> '.$t->Get('WELCOME').' </div>';
		} else if($id == -4) {
			$err = '<div class="red"> '.$t->Get('PASS_ERROR').' </div>';
		} else if($id == -3) {
			$err = '<div class="red"> '.$t->Get('INVALID_CREDENTIALS').' </div>';
		} else if($id == -2) {
			$err = '<div class="red"> '.$t->Get('EMAIL_ERROR').' </div>';
		} else if($id == -1) {
			$err = '<div class="red"> '.$t->Get('LOGIN_ERROR').' </div>';
		} else {
			$err = '';
		}

		$arr = new \stdClass();
		$arr->btn = $t->Get('SIGNIN');
		$arr->title = $t->Get('TITLE');
		$arr->login = $t->Get('SIGNIN');
		$arr->email = $t->Get('EMAIL_PLACEHOLDER');
		$arr->pass = $t->Get('PASS_PLACEHOLDER');
		$arr->emailerror = $t->Get('INVALID_EMAIL');
		$arr->passerror = $t->Get('INVALID_PASS');
		$arr->forgot = $t->Get('FORGOT_PASS');
		$arr->need = $t->Get('NEW_ACCOUNT');
		$arr->register = $t->Get('REGISTER');
		$arr->error = $err;
		$arr->post_email = '';
		if(!empty($_POST['email'])){
			$arr->post_email = $_POST['email'];
		}

		echo TopMenu::Show($arr);

		echo self::Html($arr);

		echo ChangeLang::Show($arr);
	}

	static function Html($arr){
		return '
		<div class="box-100">

			<div class="box-50">
				<h1 class="h1"> ' . $arr->title . ' </h1>

				<form method="POST">
					<div id="error-form">' . $arr->error . '</div>
					<div class="box-input">
						<input id="email" value="' . $arr->post_email . '" type="text" name="email" class="input" onfocus="PlaceholderUp(this)" onfocusout="Placeholder(this)" onchange="IsEmail(this)" onkeyup="IsEmail(this)" data-error="' . $arr->emailerror . '">
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
					<input type="submit" name="submit" value="' . $arr->login . '" class="btn-login">
				</form>

				<div class="box-small">
					<div class="register-link"> ' . $arr->need . ' <a href="/register" title="' . $arr->register . '">' . $arr->register . '</a> </div>

					<div class="pass-link"> <a href="/password" title="' . $arr->forgot . '">' . $arr->forgot . '</a> </div>
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