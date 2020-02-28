<?php
namespace MyApp\App\Email;

use Exception;
use PhpApix\Mysql\Db;

class SendNewsletter
{
	static function Send($title, $file, $quantity = 100)
	{
		try
		{
			if(file_exists($file) && !empty($title))
			{
				$html = file_get_contents($file);

				// Save template to newsletter_html
				$tid = self::AddHtmlTheme($title, $html);

				if($tid > 0)
				{
					// Count users
					$cnt = self::CountUsers();

					// For each 100
					for ($i=0; $i < $cnt; $i = $i + $quantity)
					{
						// Send emails here
						$users = self::GetUsers($i, $quantity);

						if(!empty($users))
						{
							foreach($users as $u){
								// Save user to newsletter table
								self::AddEmail($u['email'], $u['username'], $tid);
							}
						}
					}
					return 1;
				}
			}
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
		return 0;
	}

	static function CountUsers()
	{
		$db = Db::getInstance();
		$r = $db->Pdo->prepare("SELECT COUNT(*) as cnt FROM user WHERE send_news = 1");
		$r->execute();
		$rows = $r->fetchAll();

		if(!empty($rows))
		{
			return $rows[0]['cnt'];
		}
		return 0;
	}

	static function GetUsers($offset, $limit = 100)
	{
		$db = Db::getInstance();
		$r = $db->Pdo->prepare("SELECT username, email FROM user WHERE send_news = 1 LIMIT :offset,:limit");
		$r->execute([':offset' => $offset, ':limit' => $limit]);
		return $r->fetchAll();
	}

	static function AddHtmlTheme($subject, $html)
	{
		$db = Db::getInstance();
		$r = $db->Pdo->prepare("INSERT INTO newsletter_html(subject,html) VALUES(:s,:h)");
		$r->execute([':s' => $subject, ':h' => $html]);
		return $db->Pdo->lastInsertId();
	}

	static function AddEmail($email, $name = '', $rf_newsletter_html = 0)
	{
		if($rf_newsletter_html > 0 && filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$db = Db::getInstance();
			$r = $db->Pdo->prepare("INSERT INTO newsletter(email,name,rf_newsletter_html) VALUES(:e,:n,:id)");
			$r->execute([':e' => $email, ':n' => $name, ':id' => $rf_newsletter_html]);
			return $db->Pdo->lastInsertId();
		}
	}
}