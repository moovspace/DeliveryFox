<?php
namespace MyApp\App\Menu;

class Menu
{
	protected $MenuRoutes = [];
	protected $Links = [];
	protected $MenuTitle = '';
	protected $MenuIcon = '';
	protected $MenuUrl = '';

	function __construct($url = '/', $name = 'Settings', $title = 'Settings', $icon = '', $icon_open = '')
	{
		// Default icon
		if(empty($icon_open)){
			$icon_open = $icon;
		}

		$this->MenuUrl = $url;
		$this->MenuName = $name;
		$this->MenuTitle = $title;
		$this->MenuIcon = $icon;
		$this->MenuIconOpen = $icon_open;
		// Add url
		$this->AddRoutes($url);
	}

	function AddRoutes($url){
		$this->MenuRoutes[] = $url;
	}

	function AddLink($url = '/', $name = 'Link', $title = 'Title', $icon = '', $icon_open = '')
	{
		// Default icon
		if(empty($icon_open)){
			$icon_open = $icon;
		}

		$link = [];
		$link['url'] = $url;
		$link['name'] = $name;
		$link['title'] = $title;
		$link['icon'] = $icon;
		$link['icon_open'] = $icon_open;
		// Add link
		$this->Links[] = $link;
		// Add url
		$this->AddRoutes($url);
	}

	function CurrentRoute()
	{
		return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	}

	/**
	 * If current route is in menu routes array
	 *
	 * @param array $list
	 * @return void
	 */
	function IsOpen()
	{
		if(in_array($this->CurrentRoute(), $this->MenuRoutes))
		{
			return true;
		}
		return false;
	}

	function GetMenu()
	{
		$open = '';
		$open_title = '';

		if($this->IsOpen()){
			$open = 'submenu-open';
			$open_title = 'title-open';
			$this->MenuIcon = $this->MenuIconOpen;
		}
		$html = '
			<div class="menu-box">
				<a href="'.$this->MenuUrl.'" class="title '.$open_title.'" title="' . $this->MenuTitle . '">' . $this->MenuIcon . ' <hide> ' . $this->MenuName . ' </hide> </a>
			<div class="submenu '.$open.'">
		';

		foreach ($this->Links as $key => $link) {
			if($this->CurrentRoute() == $link['url']){
				$link['icon'] = $link['icon_open'];
				$html .= '<a href="'.$link['url'].'" class="submenu-link submenu-link-active" title="'.$link['title'].'">'.$link['icon'].' <hide> '.$link['name'].' </hide> </a>';
			}else{
				$html .= '<a href="'.$link['url'].'" class="submenu-link" title="'.$link['title'].'" >'.$link['icon'].' <hide>'.$link['name'].' </hide> </a>';
			}
		}

		$html .= '</div></div>';

		return $html;
	}

	function Style1(){
		return '
		<style>
			.menu-box{float: left; width: 100%; padding: 9px; overflow: hidden; position: relative}
			.menu-box *{box-sizing: border-box; text-decoration: none; outline: none}
			.menu-box i{margin-right: 15px; margin-left: 15px;}
			.menu-box .title{float: left; width: 100%; padding: 9px; background: #fff; color: #222}
			.menu-box .title-open{border-left: 0px solid #f9fcfb; font-weight: 900}
			.menu-box .submenu{display: none; float: left; width: 100%; overflow: hidden}
			.menu-box .submenu-open{display: inherit !important}
			.menu-box .submenu-link{float: left; width: 100%; padding: 9px; background: #f9f9f9; color: #263f44}
			.menu-box .submenu-link-active{color: #263f44; font-weight: 900}
		</style>
		';
	}

	function Style2(){
		return '
		<style>
			.menu-box{float: left; width: 100%; overflow: hidden; position: relative}
			.menu-box *{box-sizing: border-box; text-decoration: none; outline: none}
			.menu-box i{margin-right: 10px;}
			.menu-box .title{float: left; width: 100%; padding: 9px; background: #94d3ac; color: #fff; box-shadow: 0px 1px 3px rgba(0,0,0,0.1)}
			.menu-box .title-open{border-left: 0px solid #effcef}
			.menu-box .submenu{display: none;}
			.menu-box .submenu-open{display: inherit !important}
			.menu-box .submenu-link{color: #94d3ac; background: #effcef; float: left; width: 100%; padding: 9px;}
			.menu-box .submenu-link-active{color: #655c56; font-weight: bold;}
		</style>
		';
	}

	function Style3(){
		return  '
		<style>
			.menu-box{float: left; width: 100%; overflow: hidden; position: relative}
			.menu-box *{box-sizing: border-box; text-decoration: none; outline: none}
			.menu-box i{margin-right: 10px;}
			.menu-box .title{float: left; width: 100%; padding: 9px; background: #21bf73; color: #fff; box-shadow: 0px 1px 3px rgba(0,0,0,0.1)}
			.menu-box .title-open{border-left: 0px solid #effcef}
			.menu-box .submenu{display: none;}
			.menu-box .submenu-open{display: inherit !important}
			.menu-box .submenu-link{color: #21bf73; background: #effcef; float: left; width: 100%; padding: 9px;}
			.menu-box .submenu-link-active{color: #fd5e53; font-weight: 900;}
		</style>
		';
	}

	function Style4(){
		return '
		<style>
			.menu-box{float: left; width: 100%; overflow: hidden; position: relative}
			.menu-box *{box-sizing: border-box; text-decoration: none; outline: none}
			.menu-box i{margin-right: 10px;}
			.menu-box .title{float: left; width: 100%; padding: 9px; background: #fd5e53; color: #fff; box-shadow: 0px 1px 3px rgba(0,0,0,0.1)}
			.menu-box .title-open{border-left: 0px solid #f9fcfb;}
			.menu-box .submenu{display: none;}
			.menu-box .submenu-open{display: inherit !important}
			.menu-box .submenu-link{color: #222; background: #f9fcfb; float: left; width: 100%; padding: 9px;}
			.menu-box .submenu-link-active{color: #fd5e53; font-weight: 900;}
		</style>
		';
	}

	function Style5(){
		return '
		<style>
			.menu-box{float: left; width: 100%; overflow: hidden; position: relative}
			.menu-box *{box-sizing: border-box; text-decoration: none; outline: none}
			.menu-box i{margin-right: 10px;}
			.menu-box .title{float: left; width: 100%; padding: 9px; background: #263f44; color: #fff; box-shadow: 0px 1px 3px rgba(0,0,0,0.1)}
			.menu-box .title-open{border-left: 0px solid #f9fcfb;}
			.menu-box .submenu{display: none;}
			.menu-box .submenu-open{display: inherit !important}
			.menu-box .submenu-link{color: #ffd369; background: #fff1cf; float: left; width: 100%; padding: 9px;}
			.menu-box .submenu-link-active{color: #263f44; font-weight: 900;}
		</style>
		';
	}
}
?>

<?php
// use MyApp\App\Menu\Menu;

// $m = new Menu('/','homepage', 'Welcome home', '<i class="fas fa-home"></i>', '<i class="fas fa-home"></i>');
// echo $m->GetMenu();

// $m = new Menu('/product1','Settings', 'Settings title', '<i class="fas fa-chevron-right"></i>', '<i class="fas fa-chevron-down"></i>');
// $m->AddLink('/product1', 'First link', 'First link title', '<i class="far fa-circle"></i>', '<i class="fas fa-dot-circle"></i>');
// $m->AddLink('/product1/add', 'Second link', 'Second link title', '<i class="far fa-circle"></i>', '<i class="fas fa-dot-circle"></i>');
// $m->AddLink('/product2/add', 'Third link', 'Third link title', '<i class="far fa-circle"></i>', '<i class="fas fa-dot-circle"></i>');
// echo $m->GetMenu();

// $m = new Menu('/product', 'Settings 2', 'Settings 2 title', '<i class="fas fa-chevron-right"></i>', '<i class="fas fa-chevron-down"></i>');
// $m->AddLink('/product5', 'First link', 'First link title', '<i class="far fa-circle"></i>', '<i class="fas fa-dot-circle"></i>');
// echo $m->GetMenu();

// $m = new Menu('/product3', 'Settings 3', 'Settings 3 title', '<i class="fas fa-chevron-right"></i>', '<i class="fas fa-chevron-down"></i>');
// $m->AddLink('/product3', 'First link', 'First link title', '<i class="far fa-circle"></i>', '<i class="fas fa-dot-circle"></i>');
// echo $m->GetMenu();

// echo $m->Style1();
?>