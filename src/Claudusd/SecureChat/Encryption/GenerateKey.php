<?php
namespace Claudusd\SecureChat\Encryption;

/**
 * This method is use to generate the key for the encryption.
 * @author Claude Dioudonnat
 */
abstract class GenerateKey
{
	/** The public key generate */
	protected $publicKey;

	/** The private key generate */
	protected $privateKey;

	/**
	 * The constructor and call the generate key method.
	 */
	public function __construct()
	{
		$this->generateKey();
	}

	/**
	 * Get the public key generated.
	 * @return The public key.
	 */
	final public function getPublicKey()
	{
		return $this->publicKey;
	}

	/**
	 * Get the private key generated, but can be read only once. After this method return null.
	 * @return The private key the first time and null after.
	 */
	final public function getPrivateKey()
	{
		$privateKey = $this->privateKey;
		$this->privateKey = null;
		return $privateKey;
	}

	/**
	 * This method generate the public and private key and add in the right property.
	 */
	abstract protected function generateKey();
}