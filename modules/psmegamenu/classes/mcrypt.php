<?php
/**
 * Pts Prestashop Theme Framework for Prestashop 1.6.x
 *
 * @package   psmegamenu
 * @version   2.5.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

class PtsMenuMcrypt {

	protected $mcrypt;

	public function __construct()
	{
		$this->mcrypt = new PsMenurijndael(_PSMEGAMENU_MCRYPT_KEY_, _PSMEGAMENU_MCRYPT_IV_);
	}

	public function encode($text)
	{
		return $this->mcrypt->encrypt($text);
	}

	public function decode($text)
	{
		return $this->mcrypt->decrypt($text);
	}

}
