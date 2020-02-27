<?php
namespace MyApp\Web\AdminPanel;
use MyApp\Web\Html\Html;
use MyApp\Web\AdminPanel\View\UsersListView;

class UsersList
{
	function Index($r)
	{
		Html::Header(UsersListView::Title(), UsersListView::Description(), UsersListView::Keywords(), UsersListView::Head());

		echo UsersListView::Show();

		Html::Footer();
	}
}
?>