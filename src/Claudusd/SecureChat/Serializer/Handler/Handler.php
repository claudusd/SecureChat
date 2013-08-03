<?php

namespace Claudusd\SecureChat\Serializer\Handler;

use Claudusd\SecureChat\Model\MessageText;
use Claudusd\SecureChat\Model\UserInterface;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\JsonDeserializationVisitor;

class Handler implements SubscribingHandlerInterface
{
    private static $subHandler;

    public function __construct(HandlerMessageText $handlerMessageText, HandlerUser $handlerUser)
    {
        $subHandler = array();
        $subHandler['messageText'] = $handlerMessageText;
        $subHandler['user'] = $handlerUser;
        self::$subHandler = $subHandler;
    }

    public static function getSubscribingMethods()
    {
        if(is_null(self::$subHandler)) {
            return array();
        }
        $config = array();
        foreach (self::$subHandler as $handlerName => $handler) {
            foreach ($handler->getSubscribingMethods() as $value) {
                $param = array();
                $param['direction'] = $value['direction'];
                $param['format'] = $value['format'];
                $param['type'] = $value['type'];
                $param['method'] = $handlerName.ucfirst($value['method']);
                $config[] = $param;
            }
        }
        return $config;
    }

    public function messageTextSerializeToJson(JsonSerializationVisitor $visitor, MessageText $messageText, array $type)
    {
        $isRoot = null === $visitor->getRoot();

        $json = self::$subHandler['messageText']->serializeToJson($visitor, $messageText, $type);

        $json['user'] = $this->userSerializeToJson($visitor, $messageText->getUser(), $type);

        if ($isRoot) {
            $visitor->setRoot($json);
        }
        return $json;
    }

    public function messageTextDeserializeFromJson(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        echo 'de-message'.count($data);

        foreach ($data as $message) {
            //$messageText = new 
        }
        var_dump($type);
        var_dump($data);
        //$this->userDeserializeFromJson($visitor, $data['user'], $type);
    }

    public function userSerializeToJson(JsonSerializationVisitor $visitor, UserInterface $user, array $type)
    {
        $isRoot = null === $visitor->getRoot();

        $json = self::$subHandler['user']->serializeToJson($visitor, $user, $type);

        if ($isRoot) {
            $visitor->setRoot($json);
        }
        return $json;
    }

    public function userDeserializeFromJson(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        var_dump($data);
    }
}