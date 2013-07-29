<?php

namespace Claudusd\SecureChat\Serializer;

use Claudusd\SecureChat\Model\CreateUser;
use Claudusd\SecureChat\Serializer\Handler\Handler;
use Claudusd\SecureChat\Serializer\Handler\HandlerMessageText;
use Claudusd\SecureChat\Serializer\Handler\HandlerUser;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Handler\HandlerRegistry;

/**
 * @author Claude Dioudonat
 */
class Serializer
{
    /**
     * 
     */
    private $serializer;

    /**
     *
     */
    private $createUser;

    /**
     * 
     * @param string The name class of the message text model to use.
     * @param string The name class of the user model to use.
     * @param string The name class of the create user model to use.
     * @param string The name class of the handler of Message Text to use for the serialization.
     * @param string The name class of the handler of User to use for the serialization.
     * @param string The name class of the handler of Create User to use for the serialization.
     */
    public function __construct($messageTextClass, $userClass, $createUserClass, $handlerMessageTextClass, $handlerUserClass, $handlerCreateUserClass) 
    {
        $builder = SerializerBuilder::create();

        $handlerMessageText = new $handlerMessageTextClass($messageTextClass);
        $handlerUser = new $handlerUserClass($userClass);
        $handler = new Handler($handlerMessageText, $handlerUser);

        $handlerCreateUser = new $handlerCreateUserClass($createUserClass);

        $builder->configureHandlers(function(HandlerRegistry $registry) use ($handler, $handlerCreateUser) {
            $registry->registerSubscribingHandler($handler);
            $registry->registerSubscribingHandler($handlerCreateUser);
        });

        $this->serializer = $builder->build();

        $this->createUser = $createUserClass;
    }

    /**
     * 
     * @param
     * @return 
     */
    public function serializerMessage($messageTexts)
    {
        if(is_array($messageTexts) || $messageTexts instanceof \Traversable ||  is_a($messageTexts, 'Claudusd\SecureChat\Model\MessageText'))
            return $this->serializer->serialize($messageTexts, 'json');
    }

    /**
     *
     */
    public function deserializerCreateUser($createUserJsonData)
    {
        return $this->serializer->deserialize($createUserJsonData, $this->createUser, 'json');
    }
}