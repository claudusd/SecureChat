<?php
namespace Claudusd\SecureChat\Encryption;

/**
 * Interface to implement the hash function.
 * @author Claude Dioudonnat
 */
interface HashInterface 
{
	/**
	 *
	 * @param
	 * @param
	 * @return
	 */
	public function hash($value);
}