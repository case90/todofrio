<?php
/**
 * Pts Prestashop Theme Framework for Prestashop 1.6.x
 *
 * @package   pspagebuilder
 * @version   5.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_'))
	exit;
$path = dirname(_PS_ADMIN_DIR_);

include_once($path.'/config/config.inc.php');
include_once($path.'/init.php');

$res = (bool)Db::getInstance()->execute('
	CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'pagebuilderprofile` (
      `id_pagebuilderprofile` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `isdefault` tinyint(1) NOT NULL,
      `pkey` varchar(50) NOT NULL,
      `layout` mediumtext NOT NULL,
      `widget` text NOT NULL,
      `isdelete` tinyint(1) NOT NULL,
      `is_footer` tinyint(1) NOT NULL,
      `key` int(11) NOT NULL,
      PRIMARY KEY (`id_pagebuilderprofile`)
	) ENGINE='._MYSQL_ENGINE_.'  DEFAULT CHARSET=utf8;
');

$res = (bool)Db::getInstance()->execute('
    CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'pagebuilderprofile_shop` (
        `id_pagebuilderprofile` int(11) NOT NULL,
        `id_shop` int(11) NOT NULL,
        `default` tinyint(1) DEFAULT NULL,
        PRIMARY KEY (`id_pagebuilderprofile`,`id_shop`)
     ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;
');

/* END REQUIRED */

