# PhpApix applicatiopn
namespace MyApp

### After clone
```bash
# after clone repo and unzip refresh composer autoload
cd /path/to/dir

# update composer class
composer update
composer dump-autoload -o

# change Config.php
vendor/moovspace/phpapix/src/Settings/Config.php

# Allow write to folders
chmod -R 775 /path/to/dir
```

### Directories
- src/Api ***klasy z api (Json api)***
- src/App ***klasy z dodatkami (Component, Menu, Email ...)***
- src/Web ***klasy stron php (Auth, login, Register ...)***

### Web page component
```php
<?php
namespace MyApp\Web\Home;

use PhpApix\Mysql\Db;
use MyApp\App\Component;

class View extends Component
{
	// Page html content (required)
	static function Show($arr = null)
	{
		$json =  self::Data();

		return "<h1>Hello from homepage</h1>";
	}

	// Style and javascript head tags (required)
	static function Head()
	{
		return "<link rel="stylesheet" href="/src/Web/Home/style.css">";
	}

	// Input data
	static function Data(){
        try
		{
			$db = Db::GetInstance();

			$stm = $db->Pdo->query("SELECT * FROM users");

			$rows = $stm->fetchAll();

			return json_encode($rows);

			// $db->Pdo->lastInsertId();
			// PDO::lastInsertId();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
        }
    }
}
?>
```

### Menu class
```php
<?php
use MyApp\App\Menu\Menu;

$m = new Menu('/','homepage', 'Welcome home', '<i class="fas fa-home"></i>', '<i class="fas fa-home"></i>');
echo $m->GetMenu();

// Menu title
$m = new Menu('/product1','Settings', 'Settings title', '<i class="fas fa-chevron-right"></i>', '<i class="fas fa-chevron-down"></i>');
// Submenu
$m->AddLink('/product1', 'First link', 'First link title', '<i class="far fa-circle"></i>', '<i class="fas fa-dot-circle"></i>');
$m->AddLink('/product1/add', 'Second link', 'Second link title', '<i class="far fa-circle"></i>', '<i class="fas fa-dot-circle"></i>');
$m->AddLink('/product2/add', 'Third link', 'Third link title', '<i class="far fa-circle"></i>', '<i class="fas fa-dot-circle"></i>');
// Get menu html
echo $m->GetMenu();

echo $m->Style1();
?>
```