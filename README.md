php-sdk
=======

spirit labs API PHP SDK

This is the implementation for the spirit labs payment aggregation gateway.

BE CAREFUL: THIS SDK IS CURRENTLY UNDER DEVELOPMENT AND NOT STABLE. IF YOU FIND BUGS PLEASE PATCH VIA PULL REQUEST!

This package is compliant with [PSR-0](http://www.php-fig.org/psr/0/), [PSR-1](http://www.php-fig.org/psr/1/), and [PSR-2](http://www.php-fig.org/psr/2/).
If you notice compliance oversights, please send a patch via pull request.


## Usage

This SDK is available via composer (https://packagist.org/packages/spiritlabs-api/php-sdk), just add "spiritlabs-api/php-sdk": "dev-master" to your composer.json require list.

For usage details see also examples/ folder.

### Get available payment methods
```php
$API = new \SpiritLabs\API\Client(new \SpiritLabs\API\Authentication_HTTPBasicAccessAuth(
	$ApiKey,
	$SecretKey
));
$PaymentCustomer = new \SpiritLabs\API\Payment_Customer(array('UserId' => $UserId));
$PaymentCustomer->firstname = $firstname;
$PaymentCustomer->lastname = $lastname;

$PaymentMethods = $API->getPaymentMethods(
	array(
		new \SpiritLabs\API\Payment_Price($price, $currency)
	),
	$PaymentCustomer,
	true
);

print_r($PaymentMethods);
```


## Todo
* Add all API methods from https://api.spiritlabs.de
* Add and improve documentation (source code and usage documentation)

## License
This library is released under [MIT](http://www.tldrlegal.com/license/mit-license) license.