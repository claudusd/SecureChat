<?php

namespace Claudusd\SecureChat\Encryption\AES;

use Claudusd\SecureChat\Encryption\EncryptionInterface;

/**
 * @author Claude Dioudonnat
 */
class EncryptionAES256 implements EncryptionInterface
{
    /** */
    private $iv;

    /**
     *
     */
    public function __construct()
    {
        $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_CFB);
        $this->iv = mcrypt_create_iv($size, MCRYPT_DEV_RANDOM);
    }
	/**
	 * {@inheritdoc}
	 */
    public function encrypt($value, $key)
    {
        return openssl_encrypt($value, 'AES-256-CBC', $key, true, $this->iv);
    }

    /**
	 * {@inheritdoc}
	 */
    public function decrypt($value, $key)
    {
        return openssl_decrypt($value, 'AES-256-CBC', $key, true, $this->iv);
    }
}