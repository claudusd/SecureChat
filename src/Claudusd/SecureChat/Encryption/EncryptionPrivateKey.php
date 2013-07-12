<?php

namespace Claudusd\SecureChat\Encryption;

use Claudusd\SecureChat\Model\User;

/**
 * @author Claude Dioudonnat
 */
final class EncryptionPrivateKey
{
	private $hashSystemForKey;

	private $encryptionSystemForPrivateKey;

	private $generateKeyClassName;

	/**
	 *
	 * @param EncryptionInterface The encryption system for encrypt the private key.
	 * @param HashInterface The hash system for encrypt the key who encrypt the private key.
	 * @param GenerateKey
	 */
	public function __construct(EncryptionInterface $encryptionSystemForPrivateKey, HashInterface $hashSystemForKey, GenerateKey $generateKey)
	{
		$this->encryptionSystemForPrivateKey = $encryptionSystemForPrivateKey;
		$this->hashSystemForKey = $hashSystemForKey;
		$this->generateKeyClassName = get_class($generateKey);
	}

	public function encryptKey(User $user, $keyClear)
	{
		$generateKey = new $this->generateKeyClassName();
		$user->setPublicKey($generateKey->getPublicKey());
		$user->setPrivateKey($this->encryptionSystemForPrivateKey->encrypt($generateKey->getPrivateKey(), $keyClear));
		$user->setHashKeyForPrivateKey($this->hashSystemForKey->hash($keyClear));
	}
}