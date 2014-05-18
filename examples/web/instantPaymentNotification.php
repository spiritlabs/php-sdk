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


$API = new \SpiritLabs\API\Client(new \SpiritLabs\API\Authentication_HTTPBasicAccessAuth(
	$APIConfiguration->APIKey,
	$APIConfiguration->SecretKey
));

$data = (object)$_POST;

if($API->validateIPN($data)) {
	/**
	 * VALID INSTANT PAYMENT NOTIFICATION, handle transaction result here
	 *
	 * data is structured as the following example:
	 *
	 * {
	 * 	"CallbackData": {
	 * 		"CallbackUrl": "<YOUR IPN CALLBACK URL>",
	 * 		"InvoiceId": "<YOUR CUSTOM CALLBACK INFORMATION, you may start the transaction with as many custom properties as you need and which are completely passed backed>"
	 * 	},
	 * 	"Transaction": {
	 * 		"TransactionId": "<TRANSACTION ID, usually the same value as the transaction was started, otherwise ReferenceTransactionId is not null>",
	 * 		"TransactionShortId": null,
	 * 		"TransactionModificationId": "<TRANSACTION MODIFICATION ID, each transaction status change has an own id>",
	 * 		"ReferenceTransactionId": null,
	 * 		"CreateDate": "<DATE TIME>",
	 * 		"LastUpdateDate": "<DATE TIME>",
	 * 		"CurrentStatus": "<TRANSACTION STATUS>"
	 * 	},
	 * 	"RequestedPrice": {
	 * 		"Amount": <REQUEST PRICE SHOULD BE EQUAL WITH Accountin->Sum->Revenue>,
	 * 		"Currency": "EUR"
	 * 	},
	 * 	"Accounting": {
	 * 		"Sum": {
	 * 			"Revenue": {
	 * 				"EUR": <REVENUE AMOUNT>
	 * 			},
	 * 			"Payout": {
	 * 				"EUR": <PAYOUT AMOUNT>
	 * 			}
	 * 		},
	 * 		"ByTransaction": {
	 * 			"<TRANSACTION MODIFICATION ID>": {
	 * 				"Revenue": {
	 * 					"EUR": <REVENUE AMOUNT>
	 * 				},
	 * 				"Payout": {
	 * 					"EUR": <PAYOUT AMOUNT>
	 * 				}
	 * 			}
	 * 		}
	 * 	},
	 * 	"Hash": "sha512;<SHA512 HASH VALUE>"
	 * }
	 */

}

?>