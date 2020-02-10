<?php
namespace MyApp\Web\Auth\Confirm;

use \Exception;
use PhpApix\Mysql\Db;
use MyApp\App\Component;
use MyApp\App\Translate\Trans;
// Html
use MyApp\Web\Auth\Html\TopMenu;
use MyApp\Web\Auth\Html\ChangeLang;

class View extends Component
{
    static function Data($arr = null){
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

		echo TopMenu::Show($arr);

		echo self::Html($arr);

		echo ChangeLang::Show($arr);
	}

	static function Html($arr = null, $html = ""){
		return '
		<div class="box-100">
			<h1 class="h1"> ' . $arr->title . ' </h1>
			<div id="error-form">' . $arr->error . '</div>
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