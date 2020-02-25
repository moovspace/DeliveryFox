<?php
namespace PhpApix\Settings;

class Config
{
	// Mysql db
	const MYSQL_HOST = 'localhost';
	const MYSQL_USER = 'app';
	const MYSQL_PASS = 'toor';
	const MYSQL_PORT = 3306;
	const MYSQL_DBNAME = 'app';

	// Smtp settings
	const SMTP_USER = '';
	const SMTP_PASS = '';
	const SMTP_HOST = '127.0.0.1';
	const SMTP_PORT = 25; // 25, 587, 465
	const SMTP_FROM_EMAIL = 'no-reply@local.host';
	const SMTP_FROM_USER = 'Newsletter';
	const SMTP_TLS = false;
	const SMTP_AUTH = false;
	const SMTP_DEBUG = 0;
}
?>
