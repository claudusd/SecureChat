<?php

namespace Claudusd\SecureChat\Tests\Model;

use Claudusd\SecureChat\Model\MessageText as BaseMessageText;
use Claudusd\SecureChat\Model\UserInterface as BaseUser;

class MessageText extends BaseMessageText
{
	private $message;

	private $user;

	protected function setMessage($message)
	{
		$this->message = $message;
	}

	public function getMessage()
	{
		return $this->message;
	}

	protected function setUser(BaseUser $user)
	{
		$this->user = $user;
	}

	public function getUser()
	{
		return $this->user;
	}
}