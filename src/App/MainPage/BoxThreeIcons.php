<?php
namespace MyApp\App\MainPage;

class BoxThreeIcons
{
	static function Html($arr)
	{
		$h = '
			<div class="box3">

				<h1> '.$arr['title'].' </h1>
				<p> '.$arr['txt'].' </p>

				<div class="center">
					<div class="box-img">
						<img src="'.$arr['img1'].'">
						<h2>'.$arr['txt1'].'</h2>
						<p>'.$arr['desc1'].'</p>
					</div>

					<div class="box-img">
						<img src="'.$arr['img2'].'">
						<h2>'.$arr['txt2'].'</h2>
						<p>'.$arr['desc2'].'</p>
					</div>

					<div class="box-img">
						<img src="'.$arr['img3'].'">
						<h2>'.$arr['txt3'].'</h2>
						<p>'.$arr['desc3'].'</p>
					</div>
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
		.box3{
			float: left; width: 100%; height: auto; overflow: hidden;
			text-align: center;
			background: #e0cda9
		}
		.box3 p{
			float: left; width: 80%; margin-left: 10%;
		}
		.box3 .center{
			float: left; width: 70%; margin-left: 15%;
			margin-top: 50px;
			margin-bottom: 50px;
		}
		.box3 .center .box-img{
			display: flex;
			flex-direction: column;
			float: left; width: 31.333%;
			margin: 1%;
			text-align: center;
			align-items: center;
			position: relative;
		}
		.box3 .center .box-img img{
			float: left; width: 50px; height: 50px;
			z-index: 1; object-fit: cover;
			filter: brightness(90%);
		}
		.box3 h1{
			margin-top: 60px;
			font-size: 26px; color: #885342; font-weight: 400;
			float: left; width: 100%; height: 60px;
			z-index: 2;
			font-family: Anton;
		}
		.box3 .box-img h2{
			font-size: 26px; color: #885342; font-weight: 400;
			float: left; width: 100%;
			margin-bottom: 0px;
			z-index: 2;
			font-family: Anton;
		}
		.box3 .center .box-img p{
			float: left; width: 100%; margin-left: 0%;
			font-size: 17px; color: #222; font-weight: 500;
			z-index: 2;
		}

		@media all and (max-width: 1024px){
			.box3{
				display: block;
			}
			.box3 .center .box-img{
				float: left; width: 98%;
				margin: 30px 1%;
			}
			.box3 p{
				float: left; width: 80%; margin-left: 10%;
			}
			.box3 .center .box-img p{
				float: left; width: 100%; margin-left: 0%;
			}
		}

		@media all and (max-width: 480px){
		}
		</style>
		';

		return $style;
	}
}