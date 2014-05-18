<?php
/*
 * This file is part of spirit labs API php-sdk
 *
 * (c) Sebastian Lagemann <lagemann@spiritlabs.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require 'ClassLoader.php';
require 'APIConfiguration.php';

use \SpiritLabs\API\Debug;

Debug::enableDebug();
Debug::disableDebug();

$API = new \SpiritLabs\API\Client(new \SpiritLabs\API\Authentication_HTTPBasicAccessAuth(
	$APIConfiguration->APIKey,
	$APIConfiguration->SecretKey
));
$PaymentCustomer = new \SpiritLabs\API\Payment_Customer(array('UserId' => 1234));
$PaymentCustomer->firstname = 'Sebastian';
$PaymentCustomer->lastname = 'Lagemann';

$PaymentMethods = $API->getPaymentMethods(
	array(
		new \SpiritLabs\API\Payment_Price(2.99, 'EUR')
	),
	$PaymentCustomer,
	true
);

print_r($PaymentMethods);

?>