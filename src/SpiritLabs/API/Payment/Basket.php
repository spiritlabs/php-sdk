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

class Payment_Basket {
	/**
	 * @var Payment_Basket_Item[]
	 */
	private $Items = array();

	/**
	 * adds an item to basket
	 *
	 * @param Payment_Basket_Item $Item
	 */
	public function add(Payment_Basket_Item $Item) {
		$this->Items[] = $Item;
	}

	/**
	 * returns api request data for basket items
	 *
	 * @return array
	 */
	public function getApiData() {
		$items = array();
		foreach($this->Items AS $Item) {
			$items[] = $Item->getApiData();
		}
		return array(
			'Items' => $items
		);
	}
}

?>