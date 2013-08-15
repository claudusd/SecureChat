<?php

namespace Claudusd\SecureChat\Factory;

/**
 * @author Claude Dioudonnat
 */
interface FactoryMessageInterface
{
    /**
     *
     */
    public function createMessage(Thread $thread, $messages);
}