<?php
namespace Claudusd\SecureChat\Encryption;

/**
 * Interface to implement the encryption system for a encryption way.
 * @author Claude Dioudonnat
 */
interface EncryptionInterface 
{
	/**
	 *
	 * @param
	 * @param
	 * @return
	 */
	public function encrypt($message, $key);

	/**
	 *
	 * @param
	 * @param
	 * @return
	 */
	public function decrypt($message, $key);
}