<?php

namespace Claudusd\SecureChat\Tests\Model;

use Claudusd\SecureChat\Tests\SecureChatTest;

use Claudusd\SecureChat\Encryption\EncryptionPrivateKey;
use Claudusd\SecureChat\Encryption\AES\EncryptionAES256;
use Claudusd\SecureChat\Encryption\Hash\SHA1;
use Claudusd\SecureChat\Encryption\RSA\GenerateKeyRSA4096;

class UserTest extends SecureChatTest
{
    public function testUser()
    {
    	$user = new User();
    	$this->assertInstanceOf('Claudusd\SecureChat\Model\User', $user);

    	$this->assertTrue($user->equals($user));
    	$this->assertFalse($user->isKeysAreInitialized());

    	$encryptionAES = new EncryptionAES256();
    	$sha1 = new SHA1();
    	$generateKeyRSA4096 = new GenerateKeyRSA4096();
    	$key = 'my key';

    	$encryptionPrivateKey = new EncryptionPrivateKey($encryptionAES, $sha1, $generateKeyRSA4096);
    	$encryptionPrivateKey->encryptKey($user, $key);

    	$this->assertTrue($user->isKeysAreInitialized());
    }
}