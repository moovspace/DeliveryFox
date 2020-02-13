<?php
namespace MyApp\Web\AdminPanel;
use MyApp\App\Translate\Trans;

class CategoriesList
{
	static function Title(array $title){
		$t = '<ul class="header"><li>';
		foreach ($title as $k => $v) {
			$t .= '<div> ' . $v . ' </div>';
		}
		return $t .= '</li></ul>';
	}

	static function Data(array $d){
		$t = '<ul>';

		// Translate
		$trans = new Trans('/src/Web/AdminPanel/Lang', 'pl');

		if(empty($d)){
			$t .= '<h3> ' . $trans->Get('NO_RECORDS'). ' <h3>';
		}else{
			foreach ($d as $k => $v) {
				$id = $v['id'];

				$visible = '<span> <i class="fas fa-eye"></i> </span>';
				if($v['visible'] == 0)
				{
					$visible = '<span> <i class="fas fa-eye-slash"></i> </span>';
				}

				$t .= '<li>';
				$t .= '<div> ' . $v['id'] . ' </div>';
				$t .= '<div> ' . $v['name'] . ' </div>';
				$t .= '<div> ' . $v['slug'] . ' </div>';
				$t .= '<div> ' . $visible . ' </div>';
				$t .= '
				<div>
					<a href="?edit='.$id.'" class="btn-small-li click-edit" data-id="'.$id.'"> <i class="fas fa-edit"></i> </a>
					<a href="?delete='.$id.'" class="btn-small-li click-del" data-id="'.$id.'"> <i class="fas fa-trash"></i> </a>
				</div>
				</li>
				';
			}
		}
		return $t .= '</ul>';
	}

	static function Pagine(int $page, int $maxrows, int $perpage = 10)
	{
		if(!empty($_GET['perpage'])){
			$perpage = (int) $_GET['perpage'];
		}

		$q = '';
		if(!empty($_GET['q'])){
			$q = '&q='.$_GET['q'];
		}

		if($perpage < 1){ $perpage = 1; }
		$maxpage = (int) ($maxrows / $perpage);
		if($maxpage == 0){ $maxpage = 1; }
		if($maxrows > $perpage){
			if(($maxrows % $perpage) > 0){ $maxpage++; }
		}
		if($page < 1){ $page = 1; }
		if($page > $maxpage){ $page = $maxpage; }
		$prev = $page - 1;
		$next = $page + 1;
		if($prev < 1){ $prev = 1; }
		if($next > $maxpage){ $next = $maxpage; }

		if($maxpage != 1)
		{
			return '
			<div class="pages">
				<a href="?page='.$prev.'&perpage='.$perpage.$q.'"> <i class="fas fa-chevron-left"></i> </a>
				<a href="?page='.$page.'&perpage='.$perpage.$q.'"> '.$page.' / '.$maxpage.' </a>
				<a href="?page='.$next.'&perpage='.$perpage.$q.'"> <i class="fas fa-chevron-right"></i> </a>
			</div>
			';
		}
		return '';
	}

	/**
	 * Get attr list
	 *
	 * @param array $title Table titles
	 * @param array $rows Table  rows
	 * @param integer $page Current page
	 * @param integer $maxrows Max number of rows in db
	 * @param integer $perpage Elements on page
	 * @return string Html string
	 */
	static function Get(array $title, array $rows, int $page = 1, int $maxrows = 1, int $perpage = 10)
	{
		$t = self::Title($title);
		$t .= self::Data($rows);
		if(!empty($rows)){
			$t .= self::Pagine($page, $maxrows, $perpage);
		}
		return $t;
	}
}

// Draw list
// $title = ['Id','Name', 'Actions'];
// $rows = [[1,'size'],[2, 'Sos']];
// $maxrows = 13;
// $menu['list'] = AttrList::Get($title, $rows, $_GET['page'], $maxrows);