<?php
namespace MyApp\Web\Home\Gallery;

use MyApp\Web\Page\Main\Content;
use MyApp\Web\Page\TopMenu\TopMenuFixed;
use MyApp\Web\Home\Homepage;
// Main page
use MyApp\App\MainPage\TopSliderGallery;
use MyApp\App\MainPage\BoxFourImages;
use MyApp\App\MainPage\BannerLeftText;
use MyApp\App\MainPage\Footer;

class GalleryView
{
    static function Show()
    {
		// Html
		$h = '';
		$h .= TopMenuFixed::Show(Homepage::MenuLinks());

		// Top slider
		$h .= TopSliderGallery::Html(['img1' => '/media/home/lokal.jpg','txt1' => 'Restaurant', 'txt2' => 'gallery', 'href1' => '/category', 'title1' => 'Dania', 'href2' => '/', 'title2' => '<i class="fas fa-home"></i> Home']);
		// 4 boxes
		$h .= BoxFourImages::Html(['img1' => '/media/home/burger.jpg','txt1' => 'Hand crefted burgers!', 'desc1' => 'Taste some today', 'href1' => '/category', 'title1' => 'Nasze dania', 'img2' => '/media/home/pizza.jpg','txt2' => 'Pizza Italiana!', 'desc2' => 'Taste some today', 'href2' => '/category', 'title2' => 'Nasze dania', 'img3' => '/media/home/salad.jpg','txt3' => 'Fresh salads!', 'desc3' => 'Taste some today', 'href3' => '/category', 'title3' => 'Nasze dania', 'img4' => '/media/home/drinks.jpg','txt4' => 'Cold drinks!', 'desc4' => 'Taste some today', 'href4' => '/category', 'title4' => 'Nasze dania']);
		// Banner left
		$h .= BannerLeftText::Html(['img' => '/media/home/banner-pizza.png', 'h1' => 'Always fresh products </br> Never frozen!', 'h2' => 'Order three dishes </br> Get one for free!', 'href' => '/', 'link' => 'Order now']);
		// Footer
		$h .= Footer::Html(['bg' => '/media/home/footer.jpg','img' => '/media/home/logo.png', 'name' => 'Burgeros', 'city' => '00-000 Warsaw', 'address' => 'ul. Niewidoczna 13', 'days' => 'Open: Pn - Nd','hours' => '12:00 - 23:00', 'contact' => 'Contact', 'mobile' => '+48 000 000 000', 'email' => 'email@email.email', 'social' => 'Social', 'tw' => 'https://twitter.com/@burgeros', 'fb' => 'https://fb.com/@burgeros', 'in' => 'https://instagram.com/@burgeros']);

		// Show components
		echo $h;

		// Style, js
		echo Content::Head();
		echo TopMenuFixed::Head();

		echo TopSliderGallery::Style();
		echo BoxFourImages::Style();
		echo BannerLeftText::Style();
		echo Footer::Style();
	}
}
?>