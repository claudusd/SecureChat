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
	public function __construct($message, User $user, EncryptionInterface $encryptionSystem)
	{
		$this->setUser($user);
		$this->encryptMessage($message, $encryptionSystem);
	}
	/**
	 * 
	 * @param string
	 */
	abstract protected function setMessage($message);

	/**
	 *
	 * @return string
	 */
	abstract public function getMessage();

	/**
	 *
	 * @param User The user who can decrypt this message text.
	 */
	abstract protected function setUser(User $user);

	/**
	 *
	 * @return User
	 */
	abstract public function getUser();

	/**
	 *
	 * @param User
	 * @return 
	 */
	final public function isOwner(User $user)
	{
		return $this->getUser()->equals($user);
	}

	/**
	 *
	 * @param
	 * @param
	 * @return 
	 * @throws EncryptionException if the encryption system is null.
	 */
	final private function encryptMessage($message, EncryptionInterface $encryptionSystem)
	{
		if(is_null($message) || empty($message) || !is_string($message)) {
			throw new EncryptionException("The message can't be empty, to be encrypted. ");
		}
		$this->setMessage($encryptionSystem->encrypt($message, $this->getUser()->getPublicKey()));
	}

	/**
	 *
	 * @param
	 * @param
	 * @param
	 * @param
	 * @return string The decrypted message.
	 */
	final public function decryptMessage(EncryptionInterface $encryptionSystemForMessage, EncryptionInterface $encryptionSystemForPrivateKey, $keyForDecryptPrivateKey)
	{
		$decryptedKey = $encryptionSystemForPrivateKey->decrypt($this->getUser()->getPrivateKey(), $keyForDecryptPrivateKey);
		return $encryptionSystemForMessage->decrypt($this->getMessage(), $decryptedKey);
	}
}