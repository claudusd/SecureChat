<?php
namespace Claudusd\SecureChat\Encryption;

/**
 * Interface to implement the hash function.
 * @author Claude Dioudonnat
 */
interface HashInterface 
{
	/**
	 * The methoh hash a value.
	 * @param string The hash value.
	 * @return string The hashed value.
	 */
	public function hash($value);
}