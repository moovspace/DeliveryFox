<?php
namespace MyApp\App\Email;

use Exception;
use PhpApix\Mysql\Db;
use MyApp\App\Email\SendEmail;

// Test cron
// use MyApp\App\Email\SendNewsletterCron;
// SendNewsletterCron::Send(100);

class SendNewsletterCron
{
	static function Send($quantity = 100)
	{
		try
		{
			$sender = md5(uniqid());

			echo "Wait ... </br></br></br>";

			$msgs = self::GetMessages($quantity = 100);

			if(empty($msgs))
			{
				echo "No more messages.";
			}else{
				echo "I'm sending ". $quantity . " messagess.";
			}

			foreach($msgs as $m)
			{
				self::UpdateSender($m['id'], $sender);
			}

			$all = self::GetSenderMessages($sender);

			foreach($all as $m)
			{
				$sub = str_replace('{NAME}', $m['name'], $m['subject']);
				$htm = str_replace('{NAME}', $m['name'], $m['html']);
				$htm = str_replace('{EMAIL}', $m['email'], $htm);

				// Send message
				$se = new SendEmail();
				$err = $se->Send($m['email'], $sub, $htm);
				if($err == 0)
				{
					$err = $se->ErrorMsg;
				}

				// Update error status
				self::UpdateError($m['id'], $err);

			}

			sleep(1);
		}
		catch(Exception $e)
		{

		}
	}

	static function GetMessages(int $limit = 100)
	{
		if($limit < 10)
		{
			$limit = 10;
		}

		$db = Db::getInstance();
		$r = $db->Pdo->prepare("SELECT newsletter.id, newsletter.name, newsletter.email, newsletter_html.subject, newsletter_html.html FROM newsletter LEFT JOIN newsletter_html ON newsletter.rf_newsletter_html = newsletter_html.id WHERE error = '' ORDER BY RAND() LIMIT :limit");
		$r->execute([':limit' => $limit]);
		return $r->fetchAll();
	}

	static function GetSenderMessages($sender)
	{
		$db = Db::getInstance();
		$r = $db->Pdo->prepare("SELECT newsletter.id, newsletter.name, newsletter.email, newsletter_html.subject, newsletter_html.html FROM newsletter LEFT JOIN newsletter_html ON newsletter.rf_newsletter_html = newsletter_html.id WHERE sender = :s");
		$r->execute([':s' => $sender]);
		return $r->fetchAll();
	}

	static function UpdateError($id, $err)
	{
		$db = Db::getInstance();
		$r = $db->Pdo->prepare("UPDATE newsletter SET error = :err WHERE id = :id");
		$r->execute([':err' => $err, ':id' => $id]);
		return $r->rowCount();
	}

	static function UpdateSender($id, $sender)
	{
		$db = Db::getInstance();
		$r = $db->Pdo->prepare("UPDATE newsletter SET sender = :s WHERE id = :id");
		$r->execute([':s' => $sender, ':id' => $id]);
		return $r->rowCount();
	}
}