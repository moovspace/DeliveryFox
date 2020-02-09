<?php
namespace MyApp\Web\Auth\Confirm;

use \Exception;
use PhpApix\Mysql\Db;
use MyApp\App\Component;
use MyApp\App\Translate\Trans;

class View extends Component
{
    static function Data(){
        try
		{
			if(!empty($_GET['code']))
			{
				$code = $_GET['code'];

				if(!empty($code))
				{
					$db = Db::getInstance();
					$r = $db->Pdo->prepare("UPDATE user SET active = 1, code = '' WHERE code = :s1");
					$r->execute([':s1' => $code]);
					return $r->rowCount();
				}
				else
				{
					return -2;
				}
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
			$err = '<div class="green"> '.$t->Get('ACCOUNT_ACTIVATED').' </div>';
		} else if($id == -1) {
			$err = '<div class="red"> '.$t->Get('ACTIVATION_ERROR').' </div>';
		} else {
			$err = '<div class="green"> '.$t->Get('ACCOUNT_ACTIVE').' </div>';
		}

		$arr = new \stdClass();
		$arr->btn = $t->Get('SIGNIN');
		$arr->title = $t->Get('ACTIVATION_TITLE');
		$arr->error = $err;

		echo self::Html($arr);
	}

	static function Html($arr){
		return '
		<div class="box-top">
			<img src="/src/Web/Auth/logo.png" alt="logo" class="logo">
			<a href="/login" class="button-signin">' . $arr->btn . '</a>
		</div>
		<div class="box-100">
			<h1 class="h1"> ' . $arr->title . ' </h1>
			<div id="error-form">' . $arr->error . '</div>
		</div>

		<div id="lang">
			<a data-lang="pl" class="lang" onclick="Lang(this);"> PL </a>
			<a data-lang="en" class="lang" onclick="Lang(this);"> EN </a>
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