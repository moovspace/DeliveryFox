<?php
namespace MyApp\App\MainPage;

class BoxFourLinks
{
	static function Html($arr)
	{
		$h = '
			<div class="box4">
				<div class="box-img">
					<img src="'.$arr['img1'].'">
					<h2>'.$arr['txt1'].'</h2>
					<p>'.$arr['desc1'].'</p>
					<a href="'.$arr['href1'].'">'.$arr['title1'].'</a>
				</div>

				<div class="box-img">
					<img src="'.$arr['img2'].'">
					<h2>'.$arr['txt2'].'</h2>
					<p>'.$arr['desc2'].'</p>
					<a href="'.$arr['href2'].'">'.$arr['title2'].'</a>
				</div>

				<div class="box-img">
					<img src="'.$arr['img3'].'">
					<h2>'.$arr['txt3'].'</h2>
					<p>'.$arr['desc3'].'</p>
					<a href="'.$arr['href3'].'">'.$arr['title3'].'</a>
				</div>

				<div class="box-img">
					<img src="'.$arr['img4'].'">
					<h2>'.$arr['txt4'].'</h2>
					<p>'.$arr['desc4'].'</p>
					<a href="'.$arr['href4'].'">'.$arr['title4'].'</a>
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
		.box4{
			display: flex;
			float: left; width: 100%; height: auto; overflow: hidden;
			text-align: center;
		}
		.box4 .box-img{
			float: left; width: 25%; height: 300px;
			text-align: center;
			position: relative;
		}
		.box4 .box-img img{
			float: left; width: 100%; height: 100%;
			position: absolute; top: 0px; left: 0px;
			z-index: 1; object-fit: cover;
			filter: brightness(80%);
		}
		.box4 .box-img h2{
			font-size: 26px; color: #fff; font-weight: 400;
			float: left; width: 80%; height: 60px;
			margin: 60px 10% 0% 10%;
			position: absolute; top: 0px; left: 0px;
			text-shadow: 3px 3px rgba(0,0,0,0.6);
			z-index: 2;
			font-family: Anton;
		}
		.box4 .box-img p{
			font-size: 15px; color: #fff; font-weight: 500;
			float: left; width: 80%; height: 60px;
			margin: 140px 10% 0% 10%;
			position: absolute; top: 0px; left: 0px;
			z-index: 2;
		}
		.box4 .box-img a{
			font-size: 14px; color: #fff; font-weight: 900;
			margin-top: 200px;
			position: absolute; top: 0px; left: 50%;
			transform: translate(-50%, 0%);
			z-index: 2;

			color: #fff;
			padding: 10px 25px;
			border-radius: 50px;
			border: 2px solid #fff;
			font-weight: 900; text-transform: uppercase;
			transition: all .5s;
		}
		.box4 .box-img a:hover{
			background: #ffad1699; color: #fff;
		}

		@media all and (max-width: 1024px){
			.box4{
				display: block;
			}
			.box4 .box-img{
				float: left; width: 50%; height: 300px;
			}
		}

		@media all and (max-width: 480px){
			.box4{
				display: block;
			}
			.box4 .box-img{
				float: left; width: 100%; height: 300px;
			}
		}
		</style>
		';

		return $style;
	}
}