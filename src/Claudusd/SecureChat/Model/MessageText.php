<?php

namespace Claudusd\SecureChat\Model;

use Claudusd\SecureChat\Encryption\EncryptionInterface;
use Claudusd\SecureChat\Exception\EncryptionException;

/**
 * @author Claude Dioudonnat
 */
abstract class MessageText
{
	/**
	 * 
	 * @param string
	 */
	abstract protected function setMessage($message);

	/**
	 *
	 * @return string
	 */
	abstract protected function getMessage();

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
	final public function encryptMessage($message, User $user, EncryptionInterface $encryptionSystem)
	{
		if(is_null($message) || empty($message)) {

		}
		if(is_null($user)) {

		}
		if(is_null($encryptionSystem)) {
			throw new EncryptionException();
		}
		$this->setMessage($encryptionSystem->encrypt($message, $user->getPublicKey()));
		$this->setUser($user);
	}

	/**
	 *
	 * @param
	 * @param
	 * @param
	 * @param
	 * @return
	 */
	final public function decryptMessage(User $user, EncryptionInterface $encryptionSystemForMessage, EncryptionInterface $encryptionSystemForPrivateKey, $keyForDecryptPrivateKey)
	{
		return $encryptionSystem->decrypt($this->getMessage())
	}
}