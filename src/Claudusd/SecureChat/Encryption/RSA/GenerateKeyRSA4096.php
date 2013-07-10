<?php

namespace Claudusd\SecureChat\Encryption\RSA;

use Claudusd\SecureChat\Encryption\GenerateKey;

/**
 * This class generate public and private key of RSA type with 4096 bits.
 * @author Claude Dioudonnat
 */
class GenerateKeyRSA4096 extends GenerateKey
{
	/**
	 * {@inheritdoc}
	 */
	protected function generateKey()
	{
		$config = array(
    		"digest_alg" => "sha512",
    		"private_key_bits" => 4096,
    		"private_key_type" => OPENSSL_KEYTYPE_RSA,
		);
		$res = openssl_pkey_new($config);
		openssl_pkey_export($res, $privKey);
		$this->privateKey = $privKey;
		$pubKey = openssl_pkey_get_details($res);
		$this->publicKey = $pubKey["key"];
	}
}