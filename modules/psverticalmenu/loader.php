<?php
/**
 * Pts Prestashop Theme Framework for Prestashop 1.6.x
 *
 * @package   psverticalmenu
 * @version   2.5.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

define('_PSVERTICALMENU_IMAGE_DIR_', _PS_MODULE_DIR_.'psverticalmenu/views/img/');
define('_PSVERTICALMENU_IMAGE_URL_', _MODULE_DIR_.'psverticalmenu/views/img/');

define('_PSVERTICALMENU_MCRYPT_KEY_', md5('key_psverticalmenu'));
define('_PSVERTICALMENU_MCRYPT_IV_', md5('iv_psverticalmenu'));

if (!is_dir(_PSVERTICALMENU_IMAGE_DIR_))
	mkdir(_PSVERTICALMENU_IMAGE_DIR_, 0777);
include_once(_PS_MODULE_DIR_.'psverticalmenu/classes/psverticalrijndael.php');
include_once(_PS_MODULE_DIR_.'psverticalmenu/classes/mcrypt.php');
include_once(_PS_MODULE_DIR_.'psverticalmenu/classes/PsVerticalMegamenu.php');
include_once(_PS_MODULE_DIR_.'psverticalmenu/libs/Helper.php');
require_once(_PS_MODULE_DIR_.'psverticalmenu/classes/widgetbase.php');
require_once(_PS_MODULE_DIR_.'psverticalmenu/classes/widget.php');
