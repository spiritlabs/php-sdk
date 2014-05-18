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

interface Transport_Interface {
	/**
	 * creates an authentication token by users email and password
	 *
	 * @url https://api.spiritlabs.de/Authentication/Token/Create/
	 *
	 * @param string $email
	 * @param string $password
	 * @param string $tokenType
	 * @return null|string
	 * @throws Transport_Exception
	 */
	public function Authentication_Token_Create($email, $password, $tokenType = 'browser');

	/**
	 * validates an authentication token which was previously created by Authentication_Token_Create
	 *
	 * @url https://api.spiritlabs.de/Authentication/Token/Validate/<TOKEN>/
	 *
	 * @param string $token
	 * @return bool
	 * @throws Transport_Exception
	 */
	public function Authentication_Token_Validate($token);

	/**
	 * returns a list of available payment methods for the given customer and the requested prices
	 * if showNextHigherPriceForStaticPricingPayment is set to (bool)true the next available price will be returned for
	 * the given payment method. This is required for SMS and Phone payments for some countries where it is not possible
	 * to have dynamic price points
	 *
	 * @param array $prices
	 * @param array $customerData
	 * @param bool $showNextHigherPriceForStaticPricingPaymentMethod
	 * @return array
	 * @throws Transport_Exception
	 */
	public function Payment_Methods_List(array $prices, array $customerData, $showNextHigherPriceForStaticPricingPaymentMethod);

	/**
	 * returns the transaction id and start url for given payment method
	 *
	 * @param string $paymentMethodId
	 * @param array $price
	 * @param array $customerData
	 * @param array $basketData
	 * @param array $callbackData
	 * @param array $frontendData
	 * @return mixed
	 */
	public function Payment_Transaction_Create($paymentMethodId, array $price, array $customerData, array $basketData, array $callbackData, array $frontendData);
}

?>