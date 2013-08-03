<?php

namespace Claudusd\SecureChat\Serializer\Handler;

use Claudusd\SecureChat\Exception\InvalidClassException;
use Claudusd\SecureChat\Model\MessageText;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\JsonDeserializationVisitor;

class HandlerMessageText implements SubscribingHandlerInterface
{
    private static $type;

    /**
     * 
     * @param 
     * @throws 
     */
    public function __construct($type)
    {
        if(!is_a($type, 'Claudusd\SecureChat\Model\MessageText', true))
            throw new InvalidClassException($type, 'Claudusd\SecureChat\Model\MessageText', InvalidClassException::TYPE_CLASS);
        self::$type = $type;
    }

    public static function getSubscribingMethods()
    {
        return array(
            array(
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => self::$type,
                'method' => 'serializeToJson',
            ),
            array(
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => self::$type,
                'method' => 'deserializeFromJson',
            ),
        );
    }

    /**
     * 
     * @param
     * @param
     * @param
     * @return
     */
    public function serializeToJson(JsonSerializationVisitor $visitor, MessageText $messageText, array $type)
    {
        $isRoot = null === $visitor->getRoot();

        $json = array();
        $json['message'] = utf8_encode($messageText->getMessage());
        if ($isRoot) {
            $visitor->setRoot($json);
        }
        return $json;
    }

    /**
     * 
     * @param
     * @param
     * @param
     */
    public function deserializeFromJson(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        var_dump($type);
        return 'deseria';
    }
}