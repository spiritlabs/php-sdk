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

class Payment_Price {
	private $amount;
	private $currency;

	public function __construct($amount, $currency) {
		$this->amount = $amount;
		$this->currency = $currency;
	}
	public function getApiData() {
		return array(
			'Amount' => $this->amount,
			'Currency' => $this->currency
		);
	}
}

?>