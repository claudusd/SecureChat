<?php

namespace Claudusd\SecureChat\Encryption;

use Claudusd\SecureChat\Exception\EncryptionException;
use Claudusd\SecureChat\Exception\InvalidClassException;
use Claudusd\SecureChat\Model\MessageText;
use Claudusd\SecureChat\Model\UserInterface;

/**
 * 
 * @author Claude Dioudonnat
 */
final class MessageEncryption
{
	/** The encryption system for encrypt or decrypt message. */
	private $messageEncryption;

	/** */
	private $userKey;

	/** */
	private $messageTextClass;

	/**
	 * 
	 * @param
	 * @param
	 * @param
	 * @throws
	 * @throws
	 */
	public function __construct(EncryptionInterface $messageEncryption, UserKey $userKey, $messageTextClass)
	{
		$this->messageEncryption = $messageEncryption;
		$this->userKey = $userKey;
		if(!is_a($messageTextClass, 'Claudusd\SecureChat\Model\MessageText', true))
			throw new InvalidClassException($messageTextClass, 'Claudusd\SecureChat\Model\MessageText', InvalidClassException::TYPE_CLASS);
		$this->messageTextClass = $messageTextClass;
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
		return new $this->messageTextClass($encryptedMessage, $user);
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
			throw new EncryptionException("The user haven't keys to decrypt message.");
		$decryptedKey = $this->userKey->decryptKey($user, $keyToDecryptPrivateKey);
		return $this->messageEncryption->decrypt($message->getMessage(), $decryptedKey);
	}
}