<?php
namespace Claudusd\SecureChat\Model;

use Claudusd\SecureChat\Encryption\EncryptionInterface;

/**
 * 
 * @author Claude Dioudonnat
 */
abstract class User
{
    /**
     * It's to change the public key of the user.
     * @param string The new public key.
     */
    abstract public function setPublicKey($publicKey);

    /**
     * Get the public key of this user to encrypt an message for him.
     * @return string The public key use to encrypt a message for this user.
     */
    abstract public function getPublicKey();

    /**
     * It's to change the private key of the user.
     * @param string The new private key.
     */
    abstract public function setPrivateKey($privateKey);

    /**
     * Get the private key who is encrypted for this user and he can decrypt his message.
     * @return string The encrypted private key.
     */
    abstract public function getPrivateKey();

    /**
     * It's to definied
     * @param
     */
    abstract public function setHashKeyForPrivateKey($key);

    /**
     * It's to know if the user are identical.
     * @param User
     * @return True if is the same user else false.
     */
    abstract public function equals(User $user);

    /**
     * To know if the user is able to encrypt and decrypt message.
     * @return True if the key are initialized else false.
     */
    final public function isKeysAreInitialized()
    {
        return (!is_null($this->getPublicKey()) || !is_null($this->getPrivateKey()));
    }
}