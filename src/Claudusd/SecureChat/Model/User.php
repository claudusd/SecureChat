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
    abstract private function setPublicKey($publicKey);

    /**
     * Get the public key of this user to encrypt an message for him.
     * @return string The public key use to encrypt a message for this user.
     */
    abstract public function getPublicKey();

    /**
     * It's to change the private key of the user.
     * @param string The new private key.
     */
    abstract private function setPrivateKey($privateKey);

    /**
     * Get the private key who is encrypted for this user and he can decrypt his message.
     * @return string The encrypted private key.
     */
    abstract public function getPrivateKey();

    /**
     * To get the decrypted private key ot the user.
     * @param The key to decrypt the private key.
     * @param EncryptionInterface The encryption system use it for decrypt the private key.
     * @return The private key decrypted.
     * @throws EncryptionException if the encryptionSystem is null.
     */
    final public function getDecryptedPrivateKey($key, EncryptionInterface $encryptionSystem)
    {
        if(!is_null($encryptionSystem))
            return $encryptionSystem->decrypt($this->getPrivateKey(), $key);
        throw new EncryptionException("The encryption system can't be null. We need it one to decrypt the private key.", 1);
    }
}