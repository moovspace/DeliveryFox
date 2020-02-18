<?php
namespace MyApp\Web\Page\TopMenu;

class TopMenuFixed
{
	/**
	 * Top menu fixed transparent
	 *
	 * @param array $arr Links array ['title' =>'', 'name' => '', 'href' => '']
	 * @return string Html string
	 */
	function Show(array $arr)
	{
		$o = '
		<div class="fixed-menu">
			<div class="left">
				<img src="/media/img/logo.png">
			</div>
			<div class="middle">';

			foreach ($arr as $k => $v)
			{
				$active = '';
				if($_SERVER['REQUEST_URI'] == $v['href']){
					$active = 'fixed-link-active';
				}
				$o .= '<a href="'.$v['href'].'" title="'.$v['title'].'" class="fixed-link '.$active.'"> <span> '.$v['name'].' </span> </a>';
			}

			$o .= '</div>
			<div class="right">
				<a href="/cart" class="cart-btn"> <i class="fas fa-shopping-cart"></i> </a>
			</div>
		</div>
		';

		return $o;
	}

	function Css()
	{
		return '
		.fixed-menu{background: rgba(255,255,255,.95); position: fixed; top: 0px; left: 0px; width: 100%; padding: 5px; color: #222; display: inline-flex; align-items: center;}
		.fixed-menu > div{padding: 10px;}
		.fixed-menu .left{float: left; flex-grow: 1}
		.fixed-menu .left img{float: left; height: 40px;}
		.fixed-menu .middle{float: left; flex-grow: 10; display: flex; align-items: center; justify-content: flex-end; text-align: right}
		.fixed-menu .middle a{float: right; width: auto; padding: 5px; color: #222; font-weight: 600}
		.fixed-menu .middle a:hover{color: #21b973}
		.fixed-menu .middle .fixed-link-active span{float: left; overflow; hidden; padding: 5px; border-top: 2px solid #21b973}
		.fixed-menu .right{float: right; flex-grow: 1; text-align: right}
		.fixed-menu .right a{float; right; padding: 5px; margin-right: 30px; color: #222; font-weight: 600}
		.fixed-menu .right a:hover{color: #f60}
		';
	}
}
?>