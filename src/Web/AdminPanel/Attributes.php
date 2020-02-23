<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\AttributesView;
use MyApp\Web\AdminPanel\View\EditAttributesView;

class Attributes
{
	function Index($r)
	{
		Html::Header(AttributesView::Title(), AttributesView::Description(), AttributesView::Keywords(), AttributesView::Head());

		if(!empty($_GET['edit']))
		{
			// Edit attr
			echo EditAttributesView::Show();
		}
		else
		{
			// Attr list
			echo AttributesView::Show();
		}

		Html::Footer();
	}
}
?>