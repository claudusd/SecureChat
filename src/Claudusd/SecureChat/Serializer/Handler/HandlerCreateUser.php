<?php

namespace Claudusd\SecureChat\Serializer\Handler;

use Claudusd\SecureChat\Model\MessageText;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\JsonDeserializationVisitor;

class HandlerCreateUser implements SubscribingHandlerInterface
{
    private static $type = 'Claudusd\SecureChat\Model\CreateUser';

    public function __construct($type = null)
    {
        if(!is_null($type))
            self::$type = $type;
    }

    public static function getSubscribingMethods()
    {
        return array(
            array(
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => self::$type,
                'method' => 'deserializeFromJson',
            ),
        );
    }

    public function deserializeFromJson(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        
    }
}