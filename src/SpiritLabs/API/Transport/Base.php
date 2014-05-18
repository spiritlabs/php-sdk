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

class Transport_Base {
	const API_URL = 'https://api.spiritlabs.de';

	/**
	 * contains current credentials
	 *
	 * @var Authentication_Base
	 */
	private $Credentials = null;

	/**
	 * contains the API url
	 *
	 * @var string
	 */
	private $ApiUrl = null;

	public function __construct(Authentication_Base $Credentials) {
		$this->setCredentials($Credentials);
		$this->setApiUrl(static::API_URL);
	}

	/**
	 * sets credentials object
	 *
	 * @param Authentication_Base $Credentials
	 */
	public function setCredentials(Authentication_Base $Credentials) {
		$this->Credentials = $Credentials;
	}
	/**
	 * @return Authentication_Base
	 */
	public function getCredentials() {
		return $this->Credentials;
	}


	/**
	 * sets api url, keep in mind, url is just like https://<hostname> without urn
	 *
	 * @param string $value
	 */
	public function setApiUrl($value) {
		$this->ApiUrl = $value;
	}

	/**
	 * returns the current api url
	 *
	 * @return string
	 */
	public function getApiUrl() {
		return $this->ApiUrl;
	}
}

?>