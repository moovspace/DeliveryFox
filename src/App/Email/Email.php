<?php
namespace MyApp\App\Email;

use \InvalidArgumentException;

final class Email
{
	private $email;

	function __construct(string $email)
	{
		$this->IsValidEmail($email);
		$this->email = $email;
	}

	function __toString(): string
	{
		return $this->email;
	}

	static function FromString(string $email): self
	{
		return new self($email);
	}

	function IsValidEmail(string $email): void
	{
		if(preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email) != 1){
			throw new InvalidArgumentException(sprintf('"%s" is not a valid email address', $email));
		}
	}
}
?>
