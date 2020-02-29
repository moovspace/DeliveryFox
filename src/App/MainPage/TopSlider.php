<?php
namespace MyApp\App\MainPage;

class TopSlider
{
	static function Html($arr)
	{
		$img1 = $arr['img1'];

		$txt1 = $arr['txt1'];
		$txt2 = $arr['txt2'];

		$href1 = $arr['href1'];
		$title1 = $arr['title1'];

		$href2 = $arr['href2'];
		$title2 = $arr['title2'];

		$h = '<div class="top-slider">';

		$h .= '
			<div class="top-slider-center" style="background-image: url('.$img1.');">
				<h1> '.$txt1.' </br> '.$txt2.' </h1>
				<p>
					<a href="'.$href1.'" class="a-orange">'.$title1.'</a>
					<a href="'.$href2.'" class="a-white">'.$title2.'</a>
				</p>
			</div>
		';

		$h .= '</div>';

		return $h;
	}

	static function Style()
	{
		$style = '
		<link href="https://fonts.googleapis.com/css?family=Anton&display=swap&subset=latin-ext" rel="stylesheet">

		<style>
		.top-slider{
			float: left; width: 100%; overflow: hidden;
			position: relative
		}
		.top-slider-center{
			float: left; width: 100%; min-height: 600px; overflow: hidden;
			background-position: center;
			background-size: cover;
			text-align: center;
			padding-bottom: 50px;
		}
		.top-slider-center h1{
			margin-top: 200px; font-size: 55px; color: #fff; font-weight: 400; text-transform: uppercase;
			overflow: hidden; text-shadow: 0px 1px 3px rgba(0,0,0,0.5);
			font-family: Anton;
		}
		.top-slider-center .a-orange{
			color: #fff; background: #ffad16;
			padding: 10px 35px;
			border-radius: 50px;
			border: 2px solid #ffad16;
			font-weight: 900;
			transition: all .5s;
		}
		.top-slider-center .a-orange:hover{
			background: #ffad1699; color: #fff;
		}
		.top-slider-center .a-white{
			color: #fff;
			padding: 10px 35px;
			border-radius: 50px;
			border: 2px solid #fff;
			font-weight: 900;
			transition: all .5s;
		}
		.top-slider-center .a-white:hover{
			background: #ffad1699; color: #fff;
		}
		.fixed-menu{
			background: rgba(255,255,255,.01) !important
		}
		.fixed-menu .middle .fixed-link{
			color: #fff;
		}
		#cart-btn-show{
			display: none;
		}

		@media all and (max-width: 1024px){
			.top-slider-center h1{
				margin-top: 180px; font-size: 45px;
			}
		}

		@media all and (max-width: 480px){
			.top-slider-center h1{
				margin-top: 180px; font-size: 35px;
			}
		}
		</style>
		';

		return $style;
	}
}