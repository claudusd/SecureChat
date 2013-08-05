<?php

namespace Claudusd\SecureChat\Model;

use Claudusd\SecureChat\Encryption\EncryptionInterface;
use Claudusd\SecureChat\Exception\EncryptionException;

/**
 * A message text containts the message encrypted and user use it for encrypted and be able to descrypt it.
 * @author Claude Dioudonnat
 */
abstract class MessageText
{
	/**
	 * The constructor is use to create a new message text.
	 * @param string The message will be encrypted.
	 * @param User The user who encrypts the message and going to be able to decrypt it.
	 * @param The Encryption system use it to encrypt the message.
	 */
	public function __construct($message, UserInterface $user)
	{
		$this->setUser($user);
		$this->setMessage($message);
	}

	/**
	 * To set the message encrypted.
	 * @param string
	 */
	abstract protected function setMessage($message);

	/**
	 * To get the message encrypted.
	 * @return string
	 */
	abstract public function getMessage();

	/**
	 * To the the user who can to ecrypt the message.
	 * @param UserInterface The user who can decrypt this message text.
	 */
	abstract protected function setUser(UserInterface $user);

	/**
	 * To get the user wo are able to decrypt the message
	 * @return UserInterface The user.
	 */
	abstract public function getUser();

	/**
	 * To know if the user is owner of this message.
	 * @param UserInterface
	 * @return 
	 */
	final public function isOwner(UserInterface $user)
	{
		return $this->getUser()->equals($user);
	}
}