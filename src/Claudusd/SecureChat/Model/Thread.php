<?php

namespace Claudusd\SecureChat\Model;

use Claudusd\SecureChat\Encryption\EncryptionInterface;
use Claudusd\SecureChat\Exception\EncryptionException;

/**
 * @author Claude Dioudonnat
 */
abstract class Thread
{
	public function __construct($participants)
	{
		$this->addParticipant($participants);
		$this->createdAt = new \DateTime();
	}

	protected $createdAt;

	abstract public function addMessage();

	abstract public function getParticipants();

	abstract protected function addParticipant($participants);

	public function getCreatedAt()
	{
		return $this->createdAt;
	}
}