<?php

namespace Claudusd\SecureChat\Encryption\Hash;

use Claudusd\SecureChat\Encryption\HashInterface;

/**
 * @author Claude Dioudonnat
 */
class SHA1 implements HashInterface
{
    /**
     * {@inheritdoc}
     */
    public function hash($value)
    {
        return sha1($value);
    }
}