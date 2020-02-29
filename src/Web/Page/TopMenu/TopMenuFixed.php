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
	static function Show(array $arr)
	{
		$o = '
		<div class="fixed-menu" id="fixed-menu">
			<div class="left">
				<a href="/" title="Homepage">
					<img src="/media/img/logo.png">
				</a>
			</div>
			<div class="middle">';

			foreach ($arr as $k => $v)
			{
				$active = '';
				if(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == $v['href']){
					$active = 'fixed-link-active';
				}
				$o .= '<a href="'.$v['href'].'" title="'.$v['title'].'" class="fixed-link '.$active.'"> <span> '.$v['name'].' </span> </a>';
			}

			$o .= '</div>
			<div class="right">
				<a class="cart-btn" id="cart-btn-show"> <div class="product-quantity" id="cart-product-quantity">0</div> <i class="fas fa-shopping-cart"></i> </a>
			</div>
		</div>
		';

		return $o;
	}

	static function Head()
	{
		return '
		<link rel="stylesheet" href="/src/Web/Page/TopMenu/top-menu.css">
		<script defer src="/src/Web/Page/TopMenu/top-menu.js"></script>
		';
	}
}
?>