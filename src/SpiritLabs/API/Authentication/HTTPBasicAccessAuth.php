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

/**
 * Class Authentication_HTTPBasicAccessAuth
 *
 * @package SpiritLabs\API
 */
class Authentication_HTTPBasicAccessAuth extends Authentication_Base implements Authentication_Interface {
	private $username = null;
	private $password = null;
	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * returns array of http headers for authentication
	 *
	 * @return array
	 */
	public function getHTTPHeaders() {
		return array(
			'Authorization: Basic '.base64_encode($this->username.':'.$this->password)
		);
	}
	public function getApiKey() {
		return $this->username;
	}
}

?>