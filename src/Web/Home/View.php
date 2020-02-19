<?php
namespace MyApp\Web\Home;

use PhpApix\Mysql\Db;
use MyApp\Web\Page\Main\Content;
use MyApp\Web\Page\TopMenu\TopMenuFixed;
use MyApp\Web\Page\Menu\CategoryMenu;
use MyApp\Web\Page\ProductList\ProductBox;

class View
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
		$arr[0] = ['name' => 'homepage', 'title' => 'Main page', 'href' => '/'] ;
		$arr[1] = ['name' => 'menu', 'title' => 'Menu', 'href' => '/menu'] ;
		$arr[2] = ['name' => 'login', 'title' => 'Login page', 'href' => '/login'] ;

		// Html
		$h = '';
		$h .= TopMenuFixed::Show($arr);
		$h .= CategoryMenu::Show();
		$h .= ProductBox::Show();

		// Content div
		echo Content::Show([$h]);

		// Style, js
		echo Content::Head();
		echo TopMenuFixed::Head();
		echo CategoryMenu::Head();
		echo ProductBox::Head();
	}
}
?>