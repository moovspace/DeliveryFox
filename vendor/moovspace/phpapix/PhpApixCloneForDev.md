# PhpApix (7.0.0)
Php api router with composer autoload. See how to build a server side api routing system in PHP.

### How to use PhpApix with composer
See: [How to use PhpApix with composer](https://github.com/moovspace/PhpApix/blob/master/PhpApixComposer.md)

### Clone or download latest release - dev sample ***(install git, lamp or lemp server)***
```bash
# install git
sudo apt install git php-mbstring php-curl curl

# clone phpapix repo
git clone --depth=1 https://github.com/moovspace/phpapix
```

### Create class autoloader ***(install composer)***
```bash
cd phpapix
composer update
composer dump-autoload -o
```

### Import mysql database ***(vps)***
Vps server, desktop
```bash
# create db
mysql -u root -p < sql/phpapix.sql

# create db user
mysql -u root -p < sql/user.sql

# dir permissions (only vps linux)
chmod -R 775 /path/to/phpapix
# apache2
chown -R www-data:youruser /path/to/phpapix
# nginx
chown -R nginx:youruser /path/to/phpapix
```

### PhpApix config file: mysql, smtp ***(hosting)***
Hosting with custom mysql database
```bash
nano src/Settings/Config.php
```

### Test api
 - http://localhost/api/user/admin
 - http://localhost/welcome/email/YourUsername


# Api controller class examples in src/Api
```bash
# create dir
mkdir -p src/Api/Sample
```

## Router ***(router.php)***
Default request methods: GET, POST, PUT
```php
<?php
use PhpApix\Router\Router;

try
{
	$r = new Router();

	// Homepage /index route
	$r->Set("/index", "PhpApix/Api/Home/Home", "Index");

	/* Routes here */

	// Error page
	$r->ErrorPage();
}
catch(Exception $e)
{
	echo json_encode(["errorMsg" => $e->getMessage(), "errorCode" => $e->getCode()]);
}
?>
```

### Route with function
Add route: Set(url, callback(), [calback params], [request methods])
```php
<?php
	// GET Request
	$r->Set('/route1', function($p) {
		echo "WORKS WITH GET " . $p[0] . ' ' .$_GET['id'];
	}, ['Param 1'], ['GET']);

	// POST, PUT Request
	$r->Set('/route2', function($p) {
		return "WORKS WITH POST " . ' ' . implode(' ', $_POST);
	}, ['function', 'params', 'here'], ['POST', 'PUT']);
?>
```

### Route with class (7.0.0)
Add route: Set(url, class path, class method, [request methods])
```php
<?php
	// GET Request
	$r->Set("/api/user/{id}", "PhpApix/Api/User/User", "GetId", ['GET']);

	// POST, PUT Request
	$r->Set("/welcome/email/{id}", "PhpApix/Api/Sample/SampleClass", "Index", ['POST', 'PUT']);
?>
```

### Route include with class
Include route.php file with routes from controller folder
```php
<?php
	// Include path from /src folder
	$r->Include('Api/Sample/route');

	// Require
	$r->Include('Api/Sample/route', true);
?>
```

## Router controller class (7.0.0)
nano src/Api/Sample/SampleClass.php
```php
<?php
namespace PhpApix\Api\Sample;

// Import mysql pdo class
use PhpApix\Mysql\MysqlConnect;

// Import your class
use PhpApix\Api\Sample\Email;

// Class controller
class SampleClass extends MysqlConnect
{
	function Index($router)
	{
		echo "Hello from SampleClass !!!";

		try
		{
			// Url parts
			$params = $router->GetParams($_SERVER['REQUEST_URI']);

			// Url param with route {id}
			$id = $router->GetParam('{id}');

			// Mysql pdo sample
			$r = $this->Pdo->prepare("SELECT * FROM users WHERE id != :id");
			$r->execute([':id' => 0]);
			$rows = $r->fetchAll (); // Get rows

			// Use Your class sample
			$e = new Email();
			$e->Send();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	}
}
?>
```

## Custom class for controller
nano src/Api/Sample/Email.php
```php
<?php
// PhpApix namespace
namespace PhpApix\Api\Sample;

// Import classes
use \Exception;

// Import external composer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Email
{
	function Send()
	{
		echo "Send email here ...";

		try
		{
			// PhpMailer
			$m = new PHPMailer(true);
		}
		catch(Exception $e)
		{
			$e->getMessage();
		}
	}
}
?>
```

### Curl requests
```bash
# GET
curl http://phpapi.xx/route1?name=admin&shoesize=1

# POST
curl -d 'name=PhpApix&age=19' http://phpapi.xx/route2
```
