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
	 * @param
	 */
	abstract protected function setMessage($message);

	/**
	 *
	 * @param User The user who can decrypt this message text.
	 */
	abstract protected function setUser(User $user);

	/**
	 *
	 * @param
	 * @param
	 * @return 
	 * @throws EncryptionException if the encryptionSystem is null.
	 */
	final public function encryptedMessage($message, User $user, EncryptionInterface $encryptionSystem)
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
}