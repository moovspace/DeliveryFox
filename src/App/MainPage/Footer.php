<?php
namespace MyApp\App\MainPage;

class Footer
{
	static function Html($arr)
	{
		$h = '
			<div class="box-footer">
				<img src="'.$arr['bg'].'" class="bg">

				<div class="right">
					<img src="'.$arr['img'].'">
				</div>

				<div class="right">
					<h1>'.$arr['name'].'</h1>
					<h2> '.$arr['city'].'</h2>
					<h2>'.$arr['address'].'</h2>
					<h2>'.$arr['days'].'</h2>
					<h2>'.$arr['hours'].'</h2>
				</div>

				<div class="right">
					<h1>'.$arr['contact'].'</h1>
					<h2> <i class="fas fa-envelope"></i> '.$arr['email'].'</h2>
					<h2> <i class="fas fa-mobile"></i> '.$arr['mobile'].'</h2>
				</div>

				<div class="right">
					<h1>'.$arr['social'].'</h1>
					<h2> <a href="'.$arr['tw'].'"> <i class="fab fa-twitter"></i> </a> </h2>
					<h2> <a href="'.$arr['fb'].'"> <i class="fab fa-facebook"></i> </a> </h2>
					<h2> <a href="'.$arr['in'].'"> <i class="fab fa-instagram"></i> </a> </h2>
				</div>

				<div class="bottom">
					All rights reserved 2020r.
				</div>

			</div>
		';
		return $h;
	}

	static function Style()
	{
		$style = '
		<link href="https://fonts.googleapis.com/css?family=Anton&display=swap&subset=latin-ext" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css">

		<style>
		.box-footer{
			position: relative;
			float: left; width: 100%; overflow: hidden;
			padding: 30px 0px 0px 0px;
			background: #885342;
		}
		.box-footer .bg{
			position: absolute;
			top: -10px; left: -10px;
			width: 110%; height: 110%;
			z-index: 1;
			object-fit: cover;
			filter: blur(2px) brightness(80%);
		}
		.box-footer .right img{
			float: left;
			height: 125px;
			margin-left: 20px;
			z-index: 2;
		}

		.box-footer .right{
			position: relative;
			float: left; width: 25%;
			padding: 10px 10px;
			margin-top: 10px;
			text-align: left;
			z-index: 2;
		}

		.box-footer .right h1{
			color: #ffad16; font-size: 18px;
			font-family: Anton;
		}
		.box-footer .right h2{
			color: #fff; font-size: 16px;
		}
		.box-footer .right h2 a{
			color: #fff;
		}
		.box-footer .right h2 i{
			min-width: 20px;
		}
		.box-footer .right h2 a:hover{
			color: #ffad16;
		}
		.box-footer .right p{
			color: #fff; font-size: 15px; font-weight: 500;
			text-align:justify;
    		text-justify:auto;
		}

		.box-footer .bottom{
			position: relative;
			float: left; width: 100%;
			margin-top: 50px;
			padding: 30px 0px;
			text-align:center;
			background: rgba(0,0,0,.3); color: #e0cda9;
			box-shadow: 0px 1px 3px rgba(0,0,0,0.2) inset;
			z-index: 2;
		}

		@media all and (max-width: 1024px){
			.box-footer .right{
				float: left; width: 50%;
			}
			.box-footer .right:nth-child(4){
				padding-left: 30px;
			}
		}

		@media all and (max-width: 480px){
			.box-footer .right{
				float: left; width: 50%;
			}
			.box-footer .right:nth-child(4){
				padding-left: 30px;
			}
		}
		</style>
		';

		return $style;
	}
}