<?php
/**
 *  Ps Prestashop SliderShow for Prestashop 1.6.x
 *
 * @package   pssliderlayer
 * @version   3.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 PrestaBrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_'))
	exit;

class PsStatus extends Module
{
	private static $instance = null;

	public static function getInstance()
	{
		if (self::$instance == null)
			self::$instance = new PsStatus();

		return self::$instance;
	}

	const SLIDER_TARGET_SAME = 'same';
	const SLIDER_TARGET_NEW = 'new';

	public function getSliderTargetOption()
	{
		return array(
			array('id' => self::SLIDER_TARGET_SAME, 'name' => $this->l('Same Window')),
			array('id' => self::SLIDER_TARGET_NEW, 'name' => $this->l('New Window')),
		);
	}

	const SLIDER_STATUS_DISABLE = '0';
	const SLIDER_STATUS_ENABLE = '1';
	const SLIDER_STATUS_COMING = '2';
}