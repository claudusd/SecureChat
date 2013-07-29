<?php
namespace Claudusd\SecureChat\Model;

use Claudusd\SecureChat\Encryption\EncryptionInterface;

/**
 * 
 * @author Claude Dioudonnat
 */
interface UserInterface
{
    public function getPseudo();
    /**
     * It's to change the public key of the user.
     * @param string The new public key.
     */
    public function setPublicKey($publicKey);

    /**
     * Get the public key of this user to encrypt an message for him.
     * @return string The public key use to encrypt a message for this user.
     */
    public function getPublicKey();

    /**
     * It's to change the private key of the user.
     * @param string The new private key.
     */
    public function setPrivateKey($privateKey);

    /**
     * Get the private key who is encrypted for this user and he can decrypt his message.
     * @return string The encrypted private key.
     */
    public function getPrivateKey();

    /**
     * It's to definied
     * @param
     */
    public function setHashKeyForPrivateKey($key);

    /**
     * It's to know if the user are identical.
     * @param User
     * @return True if is the same user else false.
     */
    public function equals(UserInterface $user);
}