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

class Client {
	/**
	 * @var Transport_Base
	 */
	private $Transport = null;

	/**
	 * @var Authentication_Base
	 */
	private $Credentials = null;

	private $IPNHashAlgorithms = array(
		'sha512'
	);

	public function __construct(Authentication_Base $Credentials, Transport_Base $Transport = null) {
		$this->setCredentials($Credentials);
		if(is_null($Transport)) {
			$this->setTransport(new Transport_REST($Credentials));
		} else {
			$this->setTransport($Transport);
		}
	}

	public function getCredentials() {
		return $this->Credentials;
	}
	public function setCredentials(Authentication_Base $Credentials) {
		$this->Credentials = $Credentials;
	}

	public function getTransport() {
		return $this->Transport;
	}
	public function setTransport(Transport_Base $Transport) {
		$this->Transport = $Transport;
	}

	/**
	 * creates a new authentication token for given email and password
	 * returns null if no token was created
	 *
	 * @param $email
	 * @param $password
	 * @return null|string
	 */
	public function createAuthenticationToken($email, $password, $type = 'browser') {
		return $this->Transport->Authentication_Token_Create($email, $password, $type);
	}

	/**
	 * validates the given token and returns true if token is valid
	 *
	 * @param $token
	 * @return bool
	 */
	public function validateAuthenticationToken($token) {
		return $this->Transport->Authentication_Token_Validate($token);
	}

	public function getPaymentMethods(array $pPrices, Payment_Customer $Customer, $showNextHigherPriceForStaticPricingPaymentMethod = true) {
		$prices = array();
		foreach($pPrices AS $price) {
			if($price instanceof Payment_Price)
				$prices[] = $price->getApiData();
		}
		return $this->Transport->Payment_Methods_List($prices, $Customer->getApiData(), $showNextHigherPriceForStaticPricingPaymentMethod);
	}

	public function createPaymentTransaction(
		$paymentMethodId,
		Payment_Price $Price,
		Payment_Customer $Customer,
		Payment_Basket $Basket,
		$CallbackData,
		$FrontendData
	) {
		return $this->Transport->Payment_Transaction_Create(
			$paymentMethodId,
			$Price->getApiData(),
			$Customer->getApiData(),
			$Basket->getApiData(),
			$CallbackData,
			$FrontendData
		);
	}

	public function startPaymentMethod($uri) {
		return $this->Transport->Payment_Transaction_Start($uri);
	}

	public function validateIPN($data) {
		foreach ($data AS $k => $v) {
			if (!is_scalar($v))
				$data[$k] = (object)$v;
		}
		$data = (object)$data;

		list($hashAlgo, $hash) = explode(';', $data->Hash);
		if (!in_array($hashAlgo, $this->IPNHashAlgorithms)) throw new Client_Exception('invalid hash algorithm: ' . $hashAlgo, $data);

		$expectedHash = hash($hashAlgo, implode(';', (array)$data->CallbackData) . ';' . implode(';', (array)$data->Transaction) . ';' . implode(';', (array)$data->RequestedPrice) . ';' . $this->Credentials->getApiKey());
		if ($expectedHash != $hash) {
			return false;
		}
		return true;
	}
}

?>