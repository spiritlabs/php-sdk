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
use \SpiritLabs\API\Client;
use \SpiritLabs\API\Authentication_HTTPBasicAccessAuth;
use \SpiritLabs\API\Payment_Customer;
use \SpiritLabs\API\Payment_Price;
use \SpiritLabs\API\Payment_Basket;

Debug::enableDebug();
//Debug::disableDebug();

$API = new Client(new Authentication_HTTPBasicAccessAuth(
	$APIConfiguration->APIKey,
	$APIConfiguration->SecretKey
));
$PaymentPrice = new Payment_Price(2.99, 'EUR');
$PaymentCustomer = new Payment_Customer(array('UserId' => 12345));
$PaymentCustomer->firstname = 'Sebastian';
$PaymentCustomer->lastname = 'Lagemann';

$PaymentMethods = $API->getPaymentMethods(
	array(
		$PaymentPrice
	),
	$PaymentCustomer,
	true
);

$PaymentMethod = array_shift($PaymentMethods);

$Basket = new Payment_Basket();
$Basket->add(new \SpiritLabs\API\Payment_Basket_Item('ItemId', 'Item title', 'Item description', $PaymentPrice));

$Transaction = $API->createPaymentTransaction(
	$PaymentMethod->PaymentMethodId,
	$PaymentPrice,
	$PaymentCustomer,
	$Basket,
	array(
		'CallbackUrl' => (isset($_SERVER['HTTPS'])||isset($_SERVER['SSL'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/payment-callback.php',
		'CustomProperty' => 'whateveryouwant',
		'EventThePropertyYouCanNameAsYouLike' => 'as you like...'
	),
	array(
		'SuccessUrl' => (isset($_SERVER['HTTPS'])||isset($_SERVER['SSL'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/success.php',
		'AbortUrl' => (isset($_SERVER['HTTPS'])||isset($_SERVER['SSL'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/abort.php',
	)
);
echo "Transaction result:\n";
var_dump($Transaction);

?>