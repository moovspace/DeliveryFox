<?php
namespace MyApp\App\MainPage;

class About
{
	static function Html($arr)
	{
		$h = '
			<div class="box-about">
				<img src="'.$arr['img'].'">

				<div class="right">
					<h1>'.$arr['h1'].'</h1>
					<h2>'.$arr['h2'].'</h2>
					<p>'.$arr['p'].'</p>
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
		.box-about{
			float: left; width: 100%; overflow: hidden;
			padding: 50px 0px 90px 0px;
		}

		.box-about img{
			float: left; width: 46%; height: 400px;
			object-fit: cover;
			object-position: 50% 50%;
			border: 10px solid #885342;
			border-left: 0px;
		}

		.box-about .right{
			float: right; width: 46%; min-height: 400px;
			padding: 20px 40px;
			margin-top: 50px;
			background: #885342;
			text-align: right;
		}

		.box-about .right h1{
			color: #ffad16; font-size: 18px;
			font-family: Anton;
		}
		.box-about .right h2{
			color: #fff; font-size: 30px;
			font-family: Anton;
		}
		.box-about .right p{
			color: #fff; font-size: 15px; font-weight: 500;
			text-align: justify;
    		text-justify: auto;
		}


		@media all and (max-width: 1024px){

		}

		@media all and (max-width: 480px){
			.box-about img{
				float: left; width: 90%;
			}
			.box-about .right{
				width: 90%;
			}
		}
		</style>
		';

		return $style;
	}
}