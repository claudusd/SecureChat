<?php

namespace Claudusd\SecureChat\Signature\Implementation;

use Claudusd\SecureChat\Exception\SignatureException;
use Claudusd\SecureChat\Signature\SignatureInterface;

/**
 * @author Claude Dioudonnat
 */
class SignatureSHA1 implements SignatureInterface
{
    /**
     * {@inheritdoc}
     */
    public function sign($data, $key)
    {
        $privateKey = openssl_pkey_get_private($key);
        openssl_sign($data, $signature, $privateKey);
        openssl_free_key($privateKey);
        return $signature;
    }

    /**
     * {@inheritdoc}
     * @throws SignatureException 
     */
    public function verify($data, $signature, $key)
    {
        $publicKey = openssl_pkey_get_public($key);
        if(is_bool($publicKey) && $publicKey == false)
            throw new SignatureException(openssl_error_string());
        $verify = openssl_verify($data, $signature, $publicKey);
        openssl_free_key($publicKey);

        if($verify == -1)
            throw new SignatureException(openssl_error_string());

        if($verify == 1)
            return true;
        return false;
    }
}