<?php

namespace Claudusd\SecureChat\Tests\Serializer;

use Claudusd\SecureChat\Tests\SecureChatTest;
use Claudusd\SecureChat\Tests\Model\User;

use Claudusd\SecureChat\Encryption\MessageEncryption;
use Claudusd\SecureChat\Encryption\UserKey;
use Claudusd\SecureChat\Encryption\AES\EncryptionAES256;
use Claudusd\SecureChat\Encryption\Hash\SHA1;
use Claudusd\SecureChat\Encryption\RSA\EncryptionRSA;
use Claudusd\SecureChat\Encryption\RSA\GenerateKeyRSA4096;
use Claudusd\SecureChat\Exception\EncryptionException;
use Claudusd\SecureChat\Serializer\Serializer;

class UserSerializerTest extends SecureChatTest
{
    private $serializer;

    private $encryption;

    private $userKey;

    protected function setUp()
    {
        $this->serializer = new Serializer('Claudusd\SecureChat\Tests\Model\MessageText',
            'Claudusd\SecureChat\Tests\Model\User',
            'Claudusd\SecureChat\Model\CreateUser',
            'Claudusd\SecureChat\Serializer\Handler\HandlerMessageText',
            'Claudusd\SecureChat\Serializer\Handler\HandlerUser',
            'Claudusd\SecureChat\Serializer\Handler\HandlerCreateUser');

        $this->encryption = new EncryptionRSA();

        $encryptionAES = new EncryptionAES256();
        $sha1 = new SHA1();
        $generateKey = new GenerateKeyRSA4096();
        $this->userKey = new UserKey($encryptionAES, $sha1, $generateKey);
    }

    public function testSerialization()
    {
        $messageEncryption = new MessageEncryption($this->encryption, $this->userKey, 'Claudusd\SecureChat\Tests\Model\MessageText');
        $user = new User();

        $key = 'my key';

        $this->userKey->encryptKey($user, $key);
        $messageText = $messageEncryption->encryptMessage($user, 'toto');
        $json = $this->serializer->serializerMessage($messageText);

        $json_decode = json_decode($json, true);

        $this->assertEquals(utf8_encode($messageText->getMessage()), $json_decode['message']);
    }

}