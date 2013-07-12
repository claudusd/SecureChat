<?php

namespace Claudusd\SecureChat\Tests\Model;

use Claudusd\SecureChat\Model\User as BaseUser;

class User extends BaseUser
{
    private $privateKey;

    private $publicKey;

    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function setHashKeyForPrivateKey($key)
    {

    }

    public function equals(BaseUser $user)
    {
        return $this === $user;
    }
}