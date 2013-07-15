<?php

namespace Claudusd\SecureChat\Encryption;

use Claudusd\SecureChat\Exception\EncryptionException;
use Claudusd\SecureChat\Model\MessageText;
use Claudusd\SecureChat\Model\UserInterface;

/**
 * @author Claude Dioudonnat
 */
final class MessageEncryption
{
	private $messageEncryption;

	private $userKey;

	public function __construct(EncryptionInterface $messageEncryption, UserKey $userKey)
	{
		$this->messageEncryption = $messageEncryption;
		$this->userKey = $userKey;
	}

	/**
	 *
	 * @param
	 * @param
	 * @return MessageText
	 * @throws
	 * @throws
	 */
	public function encryptMessage(UserInterface $user, $message)
	{
		if(is_null($message) || empty($message) || !is_string($message)) {
			throw new EncryptionException("The message can't be empty, to be encrypted. ");
		}
		if(!$this->userKey->isKeysAreInitialized($user))
		{
			throw new EncryptionException("The user haven't keys to encrypt message.");
		}
		$encryptedMessage = $this->messageEncryption->encrypt($message, $user->getPublicKey());
		return new MessageText($encryptMessage, $user);
	}

	/**
	 * 
	 * @param
	 * @param
	 * @return
	 * @throws
	 */
	public function decryptMessage(MessageText $message, $keyToDecryptPrivateKey)
	{
		$user = $message->getUser();
		if(!$this->userKey->isKeysAreInitialized($user))
		{
			throw new EncryptionException("The user haven't keys to decrypt message.");
		}
		$decryptedKey = $this->userKey->decryptKey($user, $keyToDecryptPrivateKey);
		return $this->messageEncryption->decrypt($message->getMessage(), $decryptedKey);
	}
}