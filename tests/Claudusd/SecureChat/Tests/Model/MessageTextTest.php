<?php

namespace Claudusd\SecureChat\Tests\Model;

use Claudusd\SecureChat\Encryption\EncryptionPrivateKey;
use Claudusd\SecureChat\Encryption\AES\EncryptionAES256;
use Claudusd\SecureChat\Encryption\Hash\SHA1;
use Claudusd\SecureChat\Encryption\RSA\EncryptionRSA;
use Claudusd\SecureChat\Encryption\RSA\GenerateKeyRSA4096;
use Claudusd\SecureChat\Exception\EncryptionException;
use Claudusd\SecureChat\Tests\SecureChatTest;

class MessageTextTest extends SecureChatTest
{
    public function testMessageTest()
    {
    	$message = 'mon message';
    	$key = 'my key';
    	
    	$user = new User();
    	
    	$encryptionAES = new EncryptionAES256();
    	$sha1 = new SHA1();
    	$generateKeyRSA4096 = new GenerateKeyRSA4096();

    	$encryptionPrivateKey = new EncryptionPrivateKey($encryptionAES, $sha1, $generateKeyRSA4096);
    	$encryptionPrivateKey->encryptKey($user, $key);

    	
    	$encryptionRSA = new EncryptionRSA();

    	$messageText = new MessageText($message, $user, $encryptionRSA);
    	$this->assertInstanceOf('Claudusd\SecureChat\Model\MessageText', $messageText);
    	$this->assertNotEquals($message, $messageText->getMessage());
        $this->assertEquals($message, $messageText->decryptMessage($encryptionRSA, $encryptionAES, $key));
        $this->assertTrue($messageText->isOwner($user));
        $this->assertNotNull($messageText->getUser());

        $messageText2 = new MessageText($message, $user, $encryptionRSA);
        $this->assertEquals($messageText->decryptMessage($encryptionRSA, $encryptionAES, $key), $messageText2->decryptMessage($encryptionRSA, $encryptionAES, $key));

        $encryptionPrivateKey->encryptKey($user, $key);
        $this->assertNotEquals($message, $messageText->decryptMessage($encryptionRSA, $encryptionAES, $key));
        $this->assertNull($messageText->decryptMessage($encryptionRSA, $encryptionAES, $key));

        try {
            $messageText = new MessageText('', $user, $encryptionRSA);
            $this->fail("No EncryptionException thrown");
        } catch(EncryptionException $e) {
        
        }
    }
}