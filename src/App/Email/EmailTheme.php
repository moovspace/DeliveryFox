<?php
namespace MyApp\App\Email;

use PhpApix\Mysql\Db;

class EmailTheme
{
	/**
	 * Get html theme from database table: email_theme
	 *
	 * @param string $name Theme name
	 * @param array $data Array with param {PARAM} ['param' => 123]
	 * @return string Email html content
	 */
	static function GetTheme($name = 'activation', $data = [])
	{
		$html = self::LoadTheme($name);

		if(!empty($html))
		{
			return self::ChangeParams($html, $data);
		}

		return 'Email template does not exists!';
	}

	protected static function LoadTheme($name)
	{
		if(!empty($name))
		{
			$db = Db::getInstance();
			$r = $db->Pdo->prepare("SELECT html FROM email_theme WHERE name = :name");
			$r->execute([':name' => $name]);
			return $r->fetchAll()[0]['html'];
		}
		return '';
	}

	protected static function ChangeParams($html, $data)
	{
		foreach ($data as $k => $v) 
		{
			$html = \str_replace('{'.\strtoupper($k).'}', $v, $html);
		}
		return $html;
	}	
}
?>