<?php

namespace Claudusd\SecureChat\Encryption\RSA;

use Claudusd\SecureChat\Encryption\EncryptionInterface;

/**
 * @author Claude Dioudonnat
 */
class EncryptionRSA implements EncryptionInterface
{
	/**
	 * {@inheritdoc}
	 */
    public function encrypt($message, $key)
    {
    	$publicKey = openssl_pkey_get_public($key);
		openssl_public_encrypt($message, $messageEncrypted, $publicKey);
        openssl_free_key($publicKey);
		return $messageEncrypted;
    }

    /**
	 * {@inheritdoc}
	 */
    public function decrypt($message, $key)
    {
    	$privateKey = openssl_pkey_get_private($key);
    	openssl_private_decrypt($message, $messageDecrypted, $privateKey);
        openssl_free_key($privateKey);
    	return $messageDecrypted;
    }
}