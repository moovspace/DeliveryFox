<?php
namespace MyApp\App\MainPage;

class BannerLeftText
{
	static function Html($arr)
	{
		$h = '
			<div class="box-banner-left">
				<img src="'.$arr['img'].'">

				<div class="left">
					<h1> '.$arr['h1'].' </h1>
					<h2> '.$arr['h2'].' </h2>
					<a href="'.$arr['href'].'"> '.$arr['link'].' </a>
				</div>

			</div>
		';
		return $h;
	}

	static function Style()
	{
		$style = '
		<link href="https://fonts.googleapis.com/css?family=Anton&display=swap&subset=latin-ext" rel="stylesheet">

		<style>
		.box-banner-left{
			position: relative;
			float: left; width: 100%; overflow: hidden;
			padding: 30px 0px 0px 0px;
			background: #fff;
			min-height: 450px;
			overflow: hidden;
		}

		.box-banner-left img{
			position: absolute; top: 0px; left: 0px;
			width: 100%; height: 100%;
			object-fit: cover;
		}

		.box-banner-left .left{
			position: relative;
			float: left; width: 50%;
			margin-left: 10%;
		}

		.box-banner-left .left h1{
			color: #fff; font-size: 30px;
			font-family: Anton;
			text-transform: uppercase
		}

		.box-banner-left .left h2{
			color: #ffad16; font-size: 35px;
			text-transform: uppercase;
			text-shadow: 0px 3px #222
		}

		.box-banner-left .left a{
			color: #ffad16; border: 2px solid #ffad16;
			border-radius: 50px;
			padding: 15px 30px;
			margin-bottom: 20px;
			font-weight: 900;
			transition: all .5s
		}

		.box-banner-left .left a:hover{
			background: #ffad16aa; color: #fff;
		}

		@media all and (max-width: 1024px){
			.box-banner-left .left{
			position: relative;
			float: left; width: 90%;
		}

		@media all and (max-width: 480px){
		}
		</style>
		';

		return $style;
	}
}