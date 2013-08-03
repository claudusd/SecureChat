<?php

namespace Claudusd\SecureChat\Tests\Serializer;

use Claudusd\SecureChat\Tests\SecureChatTest;

use Claudusd\SecureChat\Exception\InvalidClassException;
use Claudusd\SecureChat\Serializer\Handler\HandlerMessageText;

class HandlerMessageTextTest extends SecureChatTest
{
    public function testHandlerMessageTextConstruct()
    {
        try {
            $handlerMessageText = new HandlerMessageText('Claudusd\SecureChat\Tests\Model\MessageTextNotExist');
            $this->fail('An expected exception of type InvalidClassException has not been raised.');
        } catch (InvalidClassException $e) {}
    }

    public function testHandlerMessageTextDeserialization()
    {
        $handlerMessageText = new HandlerMessageText('Claudusd\SecureChat\Tests\Model\MessageText');
        
    }
}