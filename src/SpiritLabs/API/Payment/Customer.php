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

class Payment_Customer {
	private $company;
	private $firstname;
	private $lastname;
	private $street;
	private $zip;
	private $city;
	private $country;

	private $email;
	private $gender;
	private $vatId;

	private $IP;

	private $UniqueIdentifier;

	public function __construct(array $UniqueIdentifierData) {
		$this->UniqueIdentifier = $UniqueIdentifierData;
	}

	public function __set($var, $value) {
		if(property_exists($this, $var))
			$this->{$var} = $value;
	}
	public function __get($var) {
		return $this->{$var};
	}

	public function detectIP() {
		foreach(array('REMOTE_ADDR', 'HTTP_X_FORWARDED_FOR', 'HTTP_FORWARDED', 'HTTP_VIA', 'HTTP_X_COMING_FROM') AS $key) {
			if(array_key_exists($key, $_SERVER) && $_SERVER[$key]) {
				$this->IP = $_SERVER[$key];
			}
		}
	}

	public function getApiData() {
		$data = array();

		if(!$this->IP)
			$this->detectIP();

		foreach($this AS $var => $value) {
			if($value)
				$data[$var] = $value;
		}

		return $data;
	}

}

?>