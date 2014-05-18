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

interface Authentication_Interface {
	/**
	 * returns array of http headers
	 *
	 * @return array
	 */
	public function getHTTPHeaders();
}

?>