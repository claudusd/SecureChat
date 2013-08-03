<?php
namespace Claudusd\SecureChat\Exception;

/**
 * @author Claude Dioudonnat
 */
class InvalidClassException extends \Exception
{
    const TYPE_CLASS = '1';

    const TYPE_INTERFACE = '2';

    public function __construct($className, $classNameToUse, $type = 0)
    {
        if(is_object($className)) {
            $className = get_class($className);
        }
        switch ($type) {
            case self::TYPE_CLASS:
                $message = sprintf('The class %s don\'t extend of %s.', $className, $classNameToUse);
                break;
            case self::TYPE_INTERFACE:
                $message = sprintf('The class %s don\'t implement the interface %s.', $className, $classNameToUse);
                break;
            default:
                $message = null;
                break;
        }
        parent::__construct($message);
    }
}