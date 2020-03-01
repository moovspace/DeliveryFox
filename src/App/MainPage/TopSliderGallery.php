<?php
namespace MyApp\App\MainPage;

class TopSliderGallery
{
	static function Html($arr)
	{
		$h = '<div class="top-slider">';

		$h .= '
			<div class="top-slider-center" style="background-image: url('.$arr['img1'].');">
				<h1> '.$arr['txt1'].' </br> '.$arr['txt2'].' </h1>
				<p>
					<a href="'.$arr['href2'].'" class="a-orange">'.$arr['title2'].'</a>
					<a href="'.$arr['href1'].'" class="a-white">'.$arr['title1'].'</a>
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
			background-attachment: fixed;
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
			background: rgba(255,255,255,.01)
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

		<script>
			var scrollTop = window.scrollY;

			window.addEventListener("scroll", () => {

				var scrollTop = window.scrollY;
				console.log(scrollTop);

				let el = document.getElementById("fixed-menu");

				if(scrollTop > 100){
					el.style.backgroundColor = "rgba(0,0,0,.3)";
				}else{
					el.style.backgroundColor = "rgba(255,255,255,.01)";
				}
			});
		</script>
		';

		return $style;
	}
}