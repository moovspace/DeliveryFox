<?php
namespace MyApp\Web\Home;

use MyApp\Web\Page\Main\Content;
use MyApp\Web\Page\TopMenu\TopMenuFixed;
use MyApp\Web\Home\Homepage;
// Main page
use MyApp\App\MainPage\TopSlider;
use MyApp\App\MainPage\BoxFourLinks;

class View
{
    static function Show()
    {
		// Html
		$h = '';
		$h .= TopMenuFixed::Show(Homepage::MenuLinks());

		// Top slider
		$h .= TopSlider::Html(['img1' => '/media/home/top-slider.jpg','txt1' => 'We make and delivers burgers!', 'txt2' => 'Taste some today', 'href1' => '/category', 'title1' => 'Dania', 'href2' => '/gallery', 'title2' => 'Galeria']);
		// 4 boxes
		$h .= BoxFourLinks::Html(['img1' => '/media/home/burger.jpg','txt1' => 'Hand crefted burgers!', 'desc1' => 'Taste some today', 'href1' => '/category', 'title1' => 'Nasze dania', 'img2' => '/media/home/pizza.jpg','txt2' => 'Pizza Italiana!', 'desc2' => 'Taste some today', 'href2' => '/category', 'title2' => 'Nasze dania', 'img3' => '/media/home/salad.jpg','txt3' => 'Fresh salads!', 'desc3' => 'Taste some today', 'href3' => '/category', 'title3' => 'Nasze dania', 'img4' => '/media/home/drinks.jpg','txt4' => 'Cold drinks!', 'desc4' => 'Taste some today', 'href4' => '/category', 'title4' => 'Nasze dania']);

		// Show components
		echo $h;

		// Style, js
		echo Content::Head();
		echo TopMenuFixed::Head();

		echo TopSlider::Style();
		echo BoxFourLinks::Style();
	}
}
?>