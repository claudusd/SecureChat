<?php

namespace Claudusd\SecureChat\Model;

use Claudusd\SecureChat\Encryption\EncryptionInterface;
use Claudusd\SecureChat\Exception\EncryptionException;

/**
 * A message text containts the message encrypted and user use it for encrypted and be able to descrypt it.
 * @author Claude Dioudonnat
 */
abstract class Message
{
    public function __construct($signature, UserInterface $writer, $message)
    {
        $this->setSignature($signature);
        $this->setWriter($user);
    }

    abstract protected function setSignature($singature);

    abstract public function getSignature();

    abstract protected function setWriter(UserInterface $user);

    abstract public function getWriter();

    abstract public function getMessageEncrypted(UserInterface $user);
}