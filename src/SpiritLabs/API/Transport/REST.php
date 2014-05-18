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

class Transport_REST extends Transport_Base implements Transport_Interface {
	private $lastApiresponseError = null;

	public function Authentication_Token_Create($email, $password, $tokenType = 'browser') {
		$result = $this->executeRequest('/Authentication/Token/Create/', array(
			'TokenType' => $tokenType,
			'Credentials' => array(
				'email' => $email,
				'password' => $password
			)
		), 'POST');

		if($result->Status === 'ok') {
			return $result->AuthToken;
		}
		$this->setLastApiResponseError($result);
		return false;
	}

	public function Authentication_Token_Validate($token) {
		$result = $this->executeRequest(sprintf('/Authentication/Token/Validate/%1$s/', $token));
		if($result->Status === 'ok')
			return true;

		$this->setLastApiResponseError($result);
		return false;
	}

	public function Payment_Methods_List(array $prices, array $customerData, $showNextHigherPriceForStaticPricingPaymentMethod) {
		$result = $this->executeRequest(
			'/Payment/Methods/List/',
			array(
				'prices' => $prices,
				'PaymentCustomer' => $customerData,
				'ShowHigherFixedPriceMethods' => $showNextHigherPriceForStaticPricingPaymentMethod
			),
			'POST'
		);
		if($result->Status === 'ok')
			return $result->PaymentMethods;

		$this->setLastApiResponseError($result);
		return false;;
	}

	public function Payment_Transaction_Create($paymentMethodId, array $price, array $customerData, array $basketData, array $callbackData, array $frontendData) {
		$result = $this->executeRequest(
			'/Payment/Transaction/Create/'.$paymentMethodId.'/',
			array(
				'Price' => $price,
				'PaymentCustomer' => $customerData,
				'Basket' => $basketData,
				'CallbackData' => $callbackData,
				'FrontendData' => $frontendData
			),
			'POST'
		);
		if($result->Status === 'successful')
			return $result;

		$this->setLastApiResponseError($result);
		return false;
	}

	public function Payment_Transaction_Start($uri) {
		$result = $this->executeRequest($uri);
		if($result->Status === 'ok')
			return $result->Action;

		$this->setLastApiResponseError($result);
		return false;
	}
	protected function setLastApiResponseError($error) {
		$this->lastApiresponseError = $error;
	}
	protected function executeRequest($URN, array $data = array(), $method = 'GET')
	{
		$method = strtoupper($method);
		$opts = array(
			'header' => array(),
			'ignore_errors' => true,
			'method' => $method
		);
		switch ($method) {
			case 'GET':
				$URN .= '?' . http_build_query($data);
				break;
			case 'POST':
				$opts['header'][] = 'Content-Type: text/json';
				$opts['content'] = json_encode($data);
				break;
			default:
				throw new Transport_REST_Exception('Invalid request method', array('Method' => $method));
		}

		// add credentials headers and convert the array with \n as separator to string
		$opts['header'] = implode("\n", array_merge($this->getCredentials()->getHTTPHeaders(), $opts['header']));

		if (preg_match('/(http|https)/i', $URN)) {
			$uri = $URN;
		} else {
			$uri = $this->getApiUrl() . $URN;
		}

		Debug::Write('starting request...', array('Url' => $uri, 'Options' => $opts));
		$context = stream_context_create(array('http' => $opts));

		$previousError = serialize(error_get_last());
		$result = @file_get_contents($uri, false, $context);
		$error = error_get_last();
		$lastError = serialize($error);
		if($previousError != $lastError) {
			Debug::Write('caught error while calling remote api', array('Url' => $uri, 'Options' => $opts, 'Result' => $result, 'Error' => $error));
			throw new Transport_REST_Exception(
				'error while calling remote api',
				array(
					'Uri' => $uri,
					'Options' => $opts,
					'Result' => $result,
					'Error' => $error
				)
			);
		}
		$decodedResult = @json_decode($result);
		if($decodedResult) {
			Debug::Write('success.', $decodedResult);

			if(isset($decodedResult->Status) && $decodedResult->Status === 'error') {
				throw new Transport_REST_Exception('api responses with status error: '.$decodedResult->Message, $decodedResult);
			}
			unset($opts);
			unset($uri);
			unset($context);
			unset($previousError);
			unset($result);
			unset($error);
			unset($lastError);
			return $decodedResult;
		}
		Debug::Write('error while decoding remote api response', array('Url' => $uri, 'Options' => $opts, 'Raw result' => $result));
		throw new Transport_REST_Exception(
			'error while decoding remote api response',
			array(
				'Uri' => $uri,
				'Options' => $opts,
				'Raw result' => $result
			)
		);
	}
}

?>