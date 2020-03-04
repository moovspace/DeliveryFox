# Online delivery website and admin panel
Menu online system for restaurants. License price 100$ per website.

<img src="https://github.com/moovspace/DeliveryFox/blob/master/screen-shots/delivery-home.jpg" style="width: 100%; height: auto">

### After clone (if vendor does not exists)
```bash
# after clone repo and unzip refresh composer autoload
cd /path/to/dir

# import mysql tables
mysql -u root -p < sql/app.sql
mysql -u root -p < sql/user.sql
# And it should works ...

# update composer class if vendor folder does not exists
composer update
composer dump-autoload -o

# change Config.php
# mysql and smtp credentials
vendor/moovspace/phpapix/src/Settings/Config.php

# Allow write to folders
chmod -R 775 /path/to/dir
```

### Cron files
/src/Api/cron
```bash
crontab -e
# At every 5th minute send 300 emails
*/5 * * * * /path/to/document_root/src/Api/cron/send-newsletter.php
```

### Directories
- src/Api ***klasy z api (Json api)***
- src/App ***klasy z dodatkami (Component, Menu, Email ...)***
- src/Web ***klasy stron php (Auth, login, Register ...)***

### Web page component (optional)
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
