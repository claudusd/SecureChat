<?php

namespace Claudusd\SecureChat\Tests\Encryption;

use Claudusd\SecureChat\Tests\SecureChatTest;

use Claudusd\SecureChat\Encryption\MessageEncryption;
use Claudusd\SecureChat\Encryption\UserKey;
use Claudusd\SecureChat\Encryption\AES\EncryptionAES256;
use Claudusd\SecureChat\Encryption\Hash\SHA1;
use Claudusd\SecureChat\Encryption\RSA\EncryptionRSA;
use Claudusd\SecureChat\Encryption\RSA\GenerateKeyRSA4096;

class EncryptionTest extends SecureChatTest
{
    public function testEncryptionDecryptionRSA()
    {
        $generateKey = new GenerateKeyRSA4096();
        $encryption = new EncryptionRSA();

        $this->assertInstanceOf('Claudusd\SecureChat\Encryption\EncryptionInterface', $encryption);

        $message = 'mon message';
        $encryptedMessage = $encryption->encrypt($message, $generateKey->getPublicKey());
        $this->assertNotEquals($message, $encryptedMessage);
        $this->assertEquals($message, $encryption->decrypt($encryptedMessage, $generateKey->getPrivateKey()));
    }

    public function testEncryptionDecryptionAES256()
    {
    	$encryption = new EncryptionAES256();

    	$this->assertInstanceOf('Claudusd\SecureChat\Encryption\EncryptionInterface', $encryption);

    	$key = 'toto';
    	$wrongKey = 'titi';
    	$message = 'mon message';

    	$encryptedMessage = $encryption->encrypt($message, $key);
    	$this->assertNotEquals($message, $encryptedMessage);
    	$this->assertNotEquals($message, $encryption->decrypt($encryptedMessage, $wrongKey));
    	$this->assertEquals($message, $encryption->decrypt($encryptedMessage, $key));
    }
}