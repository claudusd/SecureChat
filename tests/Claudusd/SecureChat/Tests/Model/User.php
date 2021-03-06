<?php

namespace Claudusd\SecureChat\Tests\Model;

use Claudusd\SecureChat\Model\UserInterface as BaseUser;

class User implements BaseUser
{
    private $privateKey;

    private $publicKey;

    public function getPseudo()
    {
        return 'Mon Pseudo';
    }

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