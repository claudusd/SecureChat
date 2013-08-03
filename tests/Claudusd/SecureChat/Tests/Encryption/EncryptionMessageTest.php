<?php

namespace Claudusd\SecureChat\Tests\Encryption;

use Claudusd\SecureChat\Tests\SecureChatTest;
use Claudusd\SecureChat\Tests\Model\User;

use Claudusd\SecureChat\Encryption\MessageEncryption;
use Claudusd\SecureChat\Encryption\UserKey;
use Claudusd\SecureChat\Encryption\AES\EncryptionAES256;
use Claudusd\SecureChat\Encryption\Hash\SHA1;
use Claudusd\SecureChat\Encryption\RSA\EncryptionRSA;
use Claudusd\SecureChat\Encryption\RSA\GenerateKeyRSA4096;
use Claudusd\SecureChat\Exception\EncryptionException;
use Claudusd\SecureChat\Exception\InvalidClassException;

class EncryptionMessageTest extends SecureChatTest
{
    private $encryption;

    private $userKey;

    protected function setUp()
    {
        $this->encryption = new EncryptionRSA();

        $encryptionAES = new EncryptionAES256();
        $sha1 = new SHA1();
        $generateKey = new GenerateKeyRSA4096();
        $this->userKey = new UserKey($encryptionAES, $sha1, $generateKey);
    }

    public function testMessageEncryptionMessageTextClassNotExist() 
    {
        try {
            $messageEncryption = new MessageEncryption($this->encryption, $this->userKey, 'Claudusd\SecureChat\Tests\Model\MessageTextNotExist');
        } catch (InvalidClassException $expected) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testMessageEncryptionMessageTextClassInvalid()
    {
        try {
            $messageEncryption = new MessageEncryption($this->encryption, $this->userKey, 'Claudusd\SecureChat\Tests\Model\User');
        } catch (InvalidClassException $expected) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    public function testMessageEncryptionMessageTextClassEncryptionException()
    {
        $hashExceptionRise = false;
        $messageEncryption = new MessageEncryption($this->encryption, $this->userKey, 'Claudusd\SecureChat\Tests\Model\MessageText');
        $user = new User();

        try {
            $messageEncryption->encryptMessage($user, null);
            $hashExceptionRise = true;
        } catch(EncryptionException $expected) {}

        try {
            $messageEncryption->encryptMessage($user, '');
            $hashExceptionRise = true;
        } catch(EncryptionException $expected) {}

        try {
            $messageEncryption->encryptMessage($user, new \DateTime());
            $hashExceptionRise = true;
        } catch(EncryptionException $expected) {}

        try {
            $messageEncryption->encryptMessage($user, 'toto');
            $hashExceptionRise = true;
        } catch(EncryptionException $expected) {}

        if($hashExceptionRise) {
            $this->fail('An expected exception has not been raised.');
        }
    }

    public function testMessageEncryptionMessageTextClass()
    {
        $messageEncryption = new MessageEncryption($this->encryption, $this->userKey, 'Claudusd\SecureChat\Tests\Model\MessageText');
        $user = new User();

        $encryptionAES = new EncryptionAES256();
        $sha1 = new SHA1();
        $generateKeyRSA4096 = new GenerateKeyRSA4096();
        $key = 'my key';

        $this->userKey->encryptKey($user, $key);
        $messageText = $messageEncryption->encryptMessage($user, 'toto');

        $messageEncryption->decryptMessage($messageText, $key);

        $reflectionMethod = new \ReflectionMethod('Claudusd\SecureChat\Tests\Model\MessageText', 'setUser');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invoke($messageText, new User());
        try {
            $messageEncryption->decryptMessage($messageText, $key);
            $this->fail('An expected exception of type EncryptionException has not been raised.');
        } catch(EncryptionException $expected) {}
    }
}