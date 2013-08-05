<?php

namespace Claudusd\SecureChat\Tests\Signature;

use Claudusd\SecureChat\Tests\SecureChatTest;

use Claudusd\SecureChat\Encryption\RSA\GenerateKeyRSA4096;
use Claudusd\SecureChat\Signature\Implementation\SignatureSHA1;

class SignatureTest extends SecureChatTest
{
    public function testSignature()
    {
        $messageToSigned = "My Message";
        $signature = new SignatureSHA1();

        $generateKey1 = new GenerateKeyRSA4096();

        $signature_data = $signature->sign($messageToSigned, $generateKey1->getPrivateKey());

        $this->assertTrue($signature->verify($messageToSigned, $signature_data, $generateKey1->getPublicKey()));

        $generateKey2 = new GenerateKeyRSA4096();
        $this->assertFalse($signature->verify($messageToSigned, $signature_data, $generateKey2->getPublicKey()));

        $messageToSignedWrong = "Not My Message";
        $this->assertFalse($signature->verify($messageToSignedWrong, $signature_data, $generateKey1->getPublicKey()));

        //$this->assertFalse($signature->verify($messageToSignedWrong, $signature_data, 'hgfds'));
    }
}