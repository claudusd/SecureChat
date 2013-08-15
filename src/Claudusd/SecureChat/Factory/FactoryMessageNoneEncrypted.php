<?php

namespace Claudusd\SecureChat\Factory;

/**
 * @author Claude Dioudonnat
 */
class FactoryMessageNoneEncrypted implements FactoryMessageInterface
{
    public function __construct()
    {

    }

    public function createMessage(Thread $thread, $messages) 
    {
        if(!is_array($messages) || !($messages instanceof \Traversable  && $messages instanceof \Countable) {
            // throws
        }
        if(count($thread->getParticipants()) != count($messages)) {
            // throw
        }
    }
}