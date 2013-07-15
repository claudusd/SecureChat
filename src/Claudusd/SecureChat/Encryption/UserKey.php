<?php

namespace Claudusd\SecureChat\Encryption;

use Claudusd\SecureChat\Model\UserInterface;

/**
 * This class is use for create a new public and private for a user and encrypt the private key with a key know only by the user.
 * @author Claude Dioudonnat
 */
final class UserKey
{
	/** The hashing technique to use.*/
	private $hashSystemForKey;

	/** The encryption encryption technique to use. */
	private $encryptionSystemForPrivateKey;

	/** The name of the class to use for create the new pair of key. */
	private $generateKeyClassName;

	/**
	 * The constructeur use to create the gestion of creation of key.
	 * @param EncryptionInterface The encryption system for encrypt the private key.
	 * @param HashInterface The hash system for encrypt the key who encrypt the private key.
	 * @param GenerateKey The generator of key use for create the pair of key.
	 */
	public function __construct(EncryptionInterface $encryptionSystemForPrivateKey, HashInterface $hashSystemForKey, GenerateKey $generateKey)
	{
		$this->encryptionSystemForPrivateKey = $encryptionSystemForPrivateKey;
		$this->hashSystemForKey = $hashSystemForKey;
		$this->generateKeyClassName = get_class($generateKey);
	}

	/**
	 * This method create new public and private key and encrypt the private key with a encryption technique with another key know only by the user.
	 * @param UserInterface The user for who we want create the new key.
	 * @param string The key use to encrypt the private key.
	 */
	public function encryptKey(UserInterface $user, $keyClear)
	{
		$generateKey = new $this->generateKeyClassName();
		$user->setPublicKey($generateKey->getPublicKey());
		$user->setPrivateKey($this->encryptionSystemForPrivateKey->encrypt($generateKey->getPrivateKey(), $keyClear));
		$user->setHashKeyForPrivateKey($this->hashKey($keyClear));
	}

	/**
	 * This method decrypt the private key for an user with the key to decrypted.
	 * @param UserInterface The user who want decrypt the key.
	 * @param string The key to decrypt the user's private key.
	 * @return The private key decrypted.
	 */ 
	public function decryptKey(UserInterface $user, $keyClear)
	{
		return $this->encryptionSystemForPrivateKey->decrypt($user->getPrivateKey(), $keyClear);
	}

	/**
	 * To hash the key the use to encrypt the private key.
	 * @param string The key to hash.
	 * @return string The key hashed.
	 */
	public function hashKey($keyClear)
	{
		return $this->hashSystemForKey->hash($keyClear);
	}

	public function isKeysAreInitialized(UserInterface $user)
	{
		return (!is_null($user->getPublicKey()) || !is_null($user->getPrivateKey()));
	}
}