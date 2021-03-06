<?php
namespace PhpApix\Router;
use \Exception;
use PhpApix\Api\Error\ErrorPage;

class Router
{
	protected $CurrentRoute = '';
	protected $Uri = '';
	protected $UriQuery = [];

	function __construct()
	{
		$this->Uri = $this->GetUrl($_SERVER['REQUEST_URI']); // Current url part
		$this->UriQuery = $this->GetUrlQuery($_SERVER['REQUEST_URI']); // Current url params
		$this->IsIndexPage();
	}

	function IsIndexPage()
	{
		$url = rtrim(trim($this->Uri), '/');
		if(empty($url) || $url == '/' || $url == '/index.php'){
			$this->Uri = '/index';
		}
	}

	function Include($path, $require = false)
	{
		$p = $this->ClearUrl($path);
		$f = "src/" . $p . ".php";
		if($require == true){
			require($f);
		}else{
			include($f);
		}
	}

	function ValidRequestMethod($arr)
	{
		if (!in_array($_SERVER['REQUEST_METHOD'], array_map('strtoupper', $arr))){
			throw new Exception("Error Request Method! Allowed methods: " . implode(', ', $arr), 3);
		}
	}

	function Set($route, $class, $method = 'Index', array $request_methods = ['GET', 'POST', 'PUT'])
	{
		if($route == '/'){
			$route = '/index';
		}

		$regex = preg_replace('/\{(.*?)\}/','[a-zA-z0-9_.-]+',$route); // Replace {slug} from url
		$regex = str_replace("/", "\/", $regex);

		// if url match route
		if(preg_match('/^'.$regex.'[\/]{0,1}$/', $this->Uri))
		{
			$this->ValidRequestMethod($request_methods); // POST, GET ...
			$this->CurrentRoute = $route; // Set route

			if(is_callable($class)){
				if(!empty($method)){
					echo $class($method); // Run function
				}else{
					echo $class(); // Run function
				}
				exit;
			}else{
				$this->LoadClassPath($class, $method); // Load class
			}
		}
	}

	function ClearClassPath($path)
	{
		$x = str_replace('\\','/', rtrim($path, '/'));
		return str_replace('/','\\',ltrim($path,'\\'));
	}

	function LoadClassPath($path, $method)
	{
		// Load full class path (use namespace path)
		$path = $this->ClearClassPath($path);
		// Create object My\\Name\\Space\\Class
		$o = new $path();
		// Run method
		if(method_exists($o, $method)){
			echo $o->$method($this);
			exit;
		}else{
			throw new Exception("Create new controller (".$p.") method: " . $m, 2);
		}
	}

	function LoadClass($path, $method)
	{
		if(!empty($path) || !empty($method))
		{
			$p = $this->ClearUrl($path); // Class Path
			$m = $method; // Method
			$s = explode ('/', $p);
			$c = end ($s); // Class name
			$f = "src/" . $p . ".php";

			if(file_exists($f)){
				require ($f); // Include class
				$o = new $c(); // Create class object

				// Run method
				if(method_exists($o, $m)){
					echo $o->$m($this);
					exit;
				}else{
					throw new Exception("Create new controller (".$p.") method: " . $m, 2);
				}
			}else{
				throw new Exception("Create new controller file: " . $f, 1);
			}
		}
	}

	function ErrorPage()
	{
		ErrorPage::Error404($this);
	}

	function GetParam($id = '{id}')
	{
		if(!empty($this->CurrentRoute)){
			$u = explode('/', $this->GetUrl($_SERVER['REQUEST_URI']));
			$r = explode('/', $this->CurrentRoute);
			foreach ($r as $k => $v) {
				if($v == $id){
					return $u[$k];
				}
			}
		}
	}

	function GetUrl($url)
	{
		return $this->Url = parse_url($url, PHP_URL_PATH);
	}

	function GetUrlQuery($url)
	{
		parse_str(parse_url($url, PHP_URL_QUERY), $this->UrlQuery);
		return $this->UrlQuery;
	}

	function GetParams($url)
	{
		return $this->Params = explode('/', $this->ClearUrl($this->Uri));
	}

	function ClearUrl($url)
	{
		return ltrim(rtrim(trim($url), '/'), '/');
	}

	/**
	 * If method does not exists __call()
	 *
	 * @param $name
	 * @param $arg
	 */
	public function __call($name, $arg)
	{
		echo "Calling object method '$name' with arguments: ". implode(', ', $arg). "\n";
		// call_user_func($arg[1]);
		// $this->CallMethod($args);
	}
}
?>