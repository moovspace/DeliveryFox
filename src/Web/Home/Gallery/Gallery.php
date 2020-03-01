<?php
namespace MyApp\Web\Home\Gallery;

use MyApp\Web\Html\Html;
use MyApp\Web\Home\Gallery\GalleryView;

class Gallery
{
	function Index($r)
	{
		Html::Header('Gallery', 'Restaurant gallery', 'order online gallery');

		GalleryView::Show();

		Html::Footer();
	}
}
?>