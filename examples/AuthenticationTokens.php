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

Debug::enableDebug();
Debug::disableDebug();

$API = new Client(new Authentication_HTTPBasicAccessAuth(
	$APIConfiguration->APIKey,
	$APIConfiguration->SecretKey
));
$token = $API->createAuthenticationToken($APIConfiguration->email, $APIConfiguration->password);
echo "Token Result: ";
var_dump($token);

$tokenValidate = $API->validateAuthenticationToken($token);
echo "Token valid: ";
var_dump($tokenValidate);

?>