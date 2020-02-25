<?php
namespace PhpApix\Api\Home;

class Html
{	
	static function Header($title = 'PhpApix | Php api router with composer autoload', $desc = 'PhpApix | Php api router', $keywords = 'php api router')
	{
		?>
			<!DOCTYPE html>
			<html lang="pl">
			<head>
				<title> <?php echo $title ?> </title>
				<meta charset="UTF-8">
				<meta http-equiv="X-UA-Compatible" content="ie=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
				<meta name="description" content="<?php echo $desc ?>">
				<meta name="keywords" content="<?php echo $keywords ?>">
				<meta name="author" content="">

				<?php 
					self::Favicon();
					self::Cache();
				?>
				
				<!-- fonts -->
				<link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700,900" rel="stylesheet">
				
				<!-- bootstrap -->
				<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">					
				<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
				<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
				<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

				<!-- Style -->
				<link rel="stylesheet" href="/src/Api/Home/style.css">

				<!-- Script -->
				<script src="/src/Api/Home/main.js"></script>

				<script> 
				$(document).ready(function(){				
					console.log("PhpApix works...");
					console.log(document.cookie);
				});
				</script>

				<style type="text/css">
					
				</style>
			</head>
			<body>
		<?php
	}

	static function Footer()
	{
		?>
			</body>
			</html>
		<?php
	}

	static function Cache(){
		?>
			<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
			<meta http-equiv="Cache-Control" content="post-check=0, pre-check=0">
			<meta http-equiv="Pragma" content="no-cache" />
			<meta http-equiv="Expires" content="0" />
		<?php
	}

	static function Favicon()
	{
		?>
			<link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
			<link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
			<link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
			<link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
			<link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
			<link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
			<link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
			<link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
			<link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
			<link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
			<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
			<link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
			<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">	

			<meta name="msapplication-TileColor" content="#ffffff">
			<meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
			<meta name="theme-color" content="#ffffff">

			<link rel="shortcut icon" href="/favicon/favicon.ico" type="image/x-icon">
			<link rel="icon" href="/favicon/favicon.ico" type="image/x-icon">
		<?php
	}
}
?>