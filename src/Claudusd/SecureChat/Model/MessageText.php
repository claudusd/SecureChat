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
	public function __construct($message, UserInterface $user, EncryptionInterface $encryptionSystem)
	{
		$this->setUser($user);
		$this->encryptMessage($message, $encryptionSystem);
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
	 * To the the user who can crypt and decrypt the message.
	 * @param UserInterface The user who can decrypt this message text.
	 */
	abstract protected function setUser(UserInterface $user);

	/**
	 * To get the user wo are able encrypt and decrypt the message
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

	/**
	 * It to encrypt the message.
	 * @param string The message to encrypt.
	 * @param EncryptionInterface The encrytion system to use to encrypt the message.
	 * @throws EncryptionException if the message is incorrect.
	 */
	final private function encryptMessage($message, EncryptionInterface $encryptionSystem)
	{
		if(is_null($message) || empty($message) || !is_string($message)) {
			throw new EncryptionException("The message can't be empty, to be encrypted. ");
		}
		$this->setMessage($encryptionSystem->encrypt($message, $this->getUser()->getPublicKey()));
	}

	/**
	 * It's the 
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