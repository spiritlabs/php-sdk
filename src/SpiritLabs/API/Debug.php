<?php
/*
 * This file is part of spirit labs API php-sdk
 *
 * (c) Sebastian Lagemann <lagemann@spiritlabs.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace SpiritLabs\API;

class Debug {
	private static $DEBUG_STATE = false;

	public static function enableDebug() {
		static::$DEBUG_STATE = true;
	}
	public static function disableDebug() {
		static::$DEBUG_STATE = false;
	}

	public static function Write($message, $data = null) {
		if(static::$DEBUG_STATE === true) {
			echo gmdate('Y-m-d H:i:s') . ": ";
			echo $message."\n";
			print_r($data);
			echo "\n";
		}
	}
}

?>