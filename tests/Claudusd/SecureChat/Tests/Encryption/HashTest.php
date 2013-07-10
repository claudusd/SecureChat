<?php

namespace Claudusd\SecureChat\Tests\Encryption;

use Claudusd\SecureChat\Tests\SecureChatTest;

use Claudusd\SecureChat\Encryption\Hash\SHA1;

class HashTest extends SecureChatTest
{
    public function testSHA1()
    {
        $sha1 = new SHA1();

        $this->assertInstanceOf('Claudusd\SecureChat\Encryption\HashInterface', $sha1);

        $message = 'mon message';
        $this->assertNotEquals($message, $sha1->hash($message));
        $this->assertEquals(sha1($message), $sha1->hash($message));
    }
}