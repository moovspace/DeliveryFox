<?php
namespace MyApp\Web\Checkout;

use PhpApix\Mysql\Db;
use MyApp\Web\Page\Main\Content;
use MyApp\Web\Page\TopMenu\TopMenuFixed;
use MyApp\Web\Page\ProductList\ProductBoxStatus;
use MyApp\Web\Home\Homepage;

class OrderStatusView
{
    static function Data($arr = null){
        try
		{
			$db = Db::GetInstance();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
        }
    }

    static function Show()
    {
		// Html
		$h = '';
		$h .= TopMenuFixed::Show(Homepage::MenuLinks());
		// $h .= CategoryMenu::Show();
		$h .= ProductBoxStatus::Show();

		// Content div
		echo Content::Show([$h]);

		// Style, js
		echo Content::Head();
		echo TopMenuFixed::Head();
		// echo CategoryMenu::Head();
		echo ProductBoxStatus::Head();
	}
}
?>