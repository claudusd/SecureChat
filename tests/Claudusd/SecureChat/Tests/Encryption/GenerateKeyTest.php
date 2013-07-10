<?php

namespace Claudusd\SecureChat\Tests\Encryption;

use Claudusd\SecureChat\Tests\SecureChatTest;

use Claudusd\SecureChat\Encryption\RSA\GenerateKeyRSA4096;

class GenerateKeyTest extends SecureChatTest
{
    public function testGenerateKey()
    {
        $generateKey = new GenerateKeyRSA4096();

        $this->assertInstanceOf('Claudusd\SecureChat\Encryption\GenerateKey', $generateKey);
    	$this->assertNotNull($generateKey->getPublicKey());
    	$this->assertNotNull($generateKey->getPrivateKey());
    	$this->assertNull($generateKey->getPrivateKey());
    }

    public function testDifferentKeyPair()
    {
        $generateKey1 = new GenerateKeyRSA4096();
        $generateKey2 = new GenerateKeyRSA4096();

        $this->assertNotEquals($generateKey1->getPublicKey(), $generateKey2->getPublicKey());
        $this->assertNotEquals($generateKey1->getPrivateKey(), $generateKey2->getPrivateKey());
    }
}