<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\NewsletterView;

class Newsletter
{
	function Index($r)
	{
		Html::Header(NewsletterView::Title(), NewsletterView::Description(), NewsletterView::Keywords(), NewsletterView::Head());

		echo NewsletterView::Show(); // Page content

		Html::Footer();
	}
}
?>