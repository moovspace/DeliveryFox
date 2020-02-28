<?php
namespace MyApp\Web\Home;

use MyApp\Web\Page\Main\Content;
use MyApp\Web\Page\TopMenu\TopMenuFixed;
use MyApp\Web\Home\Homepage;
// Main page
use MyApp\App\MainPage\TopSlider;

class View
{
    static function Show()
    {
		// Html
		$h = '';
		$h .= TopMenuFixed::Show(Homepage::MenuLinks());

		// Top slider
		$h .= TopSlider::Html(['img1' => '/media/home/top-slider.jpg','txt1' => 'We make and delivers burgers!', 'txt2' => 'Taste some today', 'href1' => '/category', 'title1' => 'Nasze dania', 'href2' => '/gallery', 'title2' => 'Nasza galeria']);

		// Show components
		echo $h;

		// Style, js
		echo Content::Head();
		echo TopMenuFixed::Head();

		echo TopSlider::Style();
	}
}
?>