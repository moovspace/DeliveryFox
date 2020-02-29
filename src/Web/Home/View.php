<?php
namespace MyApp\Web\Home;

use MyApp\Web\Page\Main\Content;
use MyApp\Web\Page\TopMenu\TopMenuFixed;
use MyApp\Web\Home\Homepage;
// Main page
use MyApp\App\MainPage\TopSlider;
use MyApp\App\MainPage\BoxFourLinks;
use MyApp\App\MainPage\BoxThreeIcons;
use MyApp\App\MainPage\About;
use MyApp\App\MainPage\Footer;

class View
{
    static function Show()
    {
		// Html
		$h = '';
		$h .= TopMenuFixed::Show(Homepage::MenuLinks());

		// Top slider
		$h .= TopSlider::Html(['img1' => '/media/home/top-slider-smoked.jpg','txt1' => 'We make and delivers burgers!', 'txt2' => 'Taste some today', 'href1' => '/category', 'title1' => 'Dania', 'href2' => '/gallery', 'title2' => 'Galeria']);
		// 4 boxes
		$h .= BoxFourLinks::Html(['img1' => '/media/home/burger.jpg','txt1' => 'Hand crefted burgers!', 'desc1' => 'Taste some today', 'href1' => '/category', 'title1' => 'Nasze dania', 'img2' => '/media/home/pizza.jpg','txt2' => 'Pizza Italiana!', 'desc2' => 'Taste some today', 'href2' => '/category', 'title2' => 'Nasze dania', 'img3' => '/media/home/salad.jpg','txt3' => 'Fresh salads!', 'desc3' => 'Taste some today', 'href3' => '/category', 'title3' => 'Nasze dania', 'img4' => '/media/home/drinks.jpg','txt4' => 'Cold drinks!', 'desc4' => 'Taste some today', 'href4' => '/category', 'title4' => 'Nasze dania']);
		// 3 Icons order
		$h .= BoxThreeIcons::Html(['title' => 'How Do I Order?', 'txt' => 'Some text or long description. Some text or long description. Some text or long description.','img1' => '/media/home/pizza-icon.png','txt1' => 'Take Step One', 'desc1' => 'Choose dishes', 'img2' => '/media/home/address-icon.png','txt2' => 'Take Step Two', 'desc2' => 'Enter your Address', 'img3' => '/media/home/plate-icon.png','txt3' => 'And Step Three', 'desc3' => 'Enjoy Your Order', 'href3' => '/category', 'title3' => 'Nasze dania', 'img4' => '/media/home/drinks.jpg']);
		// About
		$h .= About::Html(['img' => '/media/home/lokal.jpg', 'h1' => 'Welcome', 'h2' => 'About Restaurant', 'p' => 'Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome. Some text incrediblr awesome.']);
		// Footer
		$h .= Footer::Html(['bg' => '/media/home/lokal.jpg','img' => '/media/home/logo.png', 'name' => 'Borgeros', 'city' => '00-100 Warsaw', 'address' => 'ul. Platynowa 36', 'days' => 'Open: Pn - Nd','hours' => '12:00 - 23:00', 'contact' => 'Contact', 'mobile' => '+48 100 100 100', 'email' => 'email@email.email', 'social' => 'Social', 'tw' => 'twitter.com/@burgeros', 'fb' => 'fb.com/@burgeros', 'in' => 'instagram.com/@burgeros']);

		// Show components
		echo $h;

		// Style, js
		echo Content::Head();
		echo TopMenuFixed::Head();

		echo TopSlider::Style();
		echo BoxFourLinks::Style();
		echo BoxThreeIcons::Style();
		echo About::Style();
		echo Footer::Style();
	}
}
?>