<?php
/*
 * This file is part of spirit labs API php-sdk
 *
 * (c) Sebastian Lagemann <lagemann@spiritlabs.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require '../ClassLoader.php';
require '../APIConfiguration.php';

$PaymentPrice = new \SpiritLabs\API\Payment_Price(2.99, 'EUR');
$PaymentCustomer = new \SpiritLabs\API\Payment_Customer(array('UserId' => 12345));
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

$Basket = new \SpiritLabs\API\Payment_Basket();
$Basket->add(new \SpiritLabs\API\Payment_Basket_Item('ItemId', 'Item title', 'Item description', $PaymentPrice));

$Transaction = $API->createPaymentTransaction(
	$_GET['PaymentMethodId'],
	$PaymentPrice,
	$PaymentCustomer,
	$Basket,
	array(
		'CallbackUrl' => (isset($_SERVER['HTTPS'])||isset($_SERVER['SSL'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/instantPaymentNotification.php',
		'CustomProperty' => 'whateveryouwant',
		'EventThePropertyYouCanNameAsYouLike' => 'as you like...'
	),
	array(
		'SuccessUrl' => (isset($_SERVER['HTTPS'])||isset($_SERVER['SSL'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/success.php',
		'AbortUrl' => (isset($_SERVER['HTTPS'])||isset($_SERVER['SSL'])?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/abort.php',
	)
);

$StartResult = $API->startPaymentMethod($Transaction->StartUrl);
switch($StartResult->Type) {
	case 'Redirect::window':
		header('Location: '.$StartResult->Url);
		echo 'redirecting to payment partner, if not redirected within 5 seconds please <a href="'.$StartResult->Url.'">click here...</a>';
		break;
	default:
		// this affects especially sms and phone transactions which are handled directly by spirit labs
		throw new Exception('currently no example implementation');
		break;
}

?>