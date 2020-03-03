<?php
namespace MyApp\App\MainPage;

class BoxFourImages
{
	/**
	 * Gallery
	 * Get images from:
	 * media/home/gallery
	 *
	 * @param array $arr Empty here
	 * @return void
	 */
	static function Html($arr = [])
	{
		$images = '';

		$files = glob("media/home/gallery/*.{jpg,png,gif}", GLOB_BRACE);

		foreach ($files as $f)
		{
			if(file_exists($f))
			{
				$images .= '
				<a data-fancybox="gallery" href="'.$f.'">
					<img src="'.$f.'">
				</a>
				';
			}
		}

		$h = '
			<div class="box4">
				<div class="box-gallery">
					'.$images.'
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
		.box4 .box-gallery{
			background: #885342;
			float: left; width: 100%; height: auto;
			text-align: center;
			position: relative;
			overflow: hidden;
		}
		.box4 .box-gallery img{
			float: left; width: 25%; height: 300px;
			object-fit: cover;
			position: relative;
			cursor: pointer;
			transition:  all .8s;
		}
		.box4 .box-gallery img:hover{
			box-shadow: 0px 3px 5px rgba(0,0,0,0.5) inset;
			filter: brightness(60%);
		}

		@media all and (max-width: 1024px){
			.box4{
				display: block;
			}
			.box4 .box-gallery img{
				float: left; width: 50%; height: 300px;
			}
		}

		@media all and (max-width: 640px){
			.box4{
				display: block;
			}
			.box4 .box-gallery img{
				float: left; width: 50%; height: 200px;
			}
		}
		</style>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
		<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
		';

		return $style;
	}
}