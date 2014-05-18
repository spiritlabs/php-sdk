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

class Payment_Basket_Item {
	private $itemId;
	private $title;
	private $description;
	private $price;

	public function __construct($itemId, $title, $description, Payment_Price $price) {
		$this->itemId = $itemId;
		$this->title = $title;
		$this->description = $description;
		$this->price = $price;
	}
	public function getApiData() {
		return array(
			'ItemId' => $this->itemId,
			'Title' => $this->title,
			'Description' => $this->description,
			'Price' => $this->price->getApiData()
		);
	}
}

?>