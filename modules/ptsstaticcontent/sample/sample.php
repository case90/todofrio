<?php
/**
 * Pts Prestashop Theme Framework for Prestashop 1.6.x
 *
 * @package   ptsstaticcontent
 * @version   2.1.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

class PtsStaticContentSampe {

	/**
	 * Trigger on install module
	 */
	public static function onInstall()
	{
		$result = true;
		$result &= (Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'ptsstaticcontent`') &&
			Db::getInstance()->Execute('
	        CREATE TABLE `'._DB_PREFIX_.'ptsstaticcontent` (
	                `id_item` int(10) unsigned NOT NULL AUTO_INCREMENT,
	                `id_shop` int(10) unsigned NOT NULL,
	                `id_lang` int(10) unsigned NOT NULL,
	                `item_order` int(10) unsigned NOT NULL,
	                `title` VARCHAR(100),
	                `title_use` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
	                `hook` VARCHAR(100),
	                `url` VARCHAR(100),
	                `target` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
	                `image` VARCHAR(100),
	                `image_w` VARCHAR(10),
	                `image_h` VARCHAR(10),
	                `html` TEXT,
	                `active` tinyint(1) unsigned NOT NULL DEFAULT \'1\',
	                `col_lg` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
	                `col_sm` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
	                `class` VARCHAR(50),
	                PRIMARY KEY (`id_item`)
	        ) ENGINE = '._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;')
						);
		$result &= self::installFixtures();

		self::checkOwnerHooks();

		return $result;
	}

	private static function checkOwnerHooks()
	{
		$hookspos = array(
			'displayTop',
			'displayHeaderRight',
			'displaySlideshow',
			'topNavigation',
			'displayPromoteTop',
			'displayRightColumn',
			'displayLeftColumn',
			'displayHome',
			'displayFooter',
			'displayBottom',
			'displayContentBottom',
			'displayFootNav',
			'displayFooterTop',
			'displayFooterBottom'
		);
		foreach ($hookspos as $hook)
		{
			if (!Hook::getIdByName($hook))
			{
				$new_hook = new Hook();
				$new_hook->name = pSQL($hook);
				$new_hook->title = pSQL($hook);
				$new_hook->add();
			}
		}

		return true;
	}

	/**
	 * install default sample data
	 */
	public static function installFixtures()
	{
		$result = true;
		return $result;
	}
}
