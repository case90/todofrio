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

define('_PAGEBUILDER_WIDGET_DIR_', _PS_MODULE_DIR_.'pspagebuilder/classes/widget/');

define('_PAGEBUILDER_IMAGE_DIR_', _PS_MODULE_DIR_.'pspagebuilder/views/img/');
define('_PAGEBUILDER_IMAGE_URL_', _MODULE_DIR_.'pspagebuilder/views/img/');

define('_PAGEBUILDER_EXPORT_DIR_', _PS_MODULE_DIR_.'pspagebuilder/exports/');

define('_PAGEBUILDER_MCRYPT_KEY_', md5('key_pspagebuilder'));
define('_PAGEBUILDER_MCRYPT_IV_', md5('iv_pspagebuilder'));


if (!is_dir(_PAGEBUILDER_IMAGE_DIR_))
	mkdir(_PAGEBUILDER_IMAGE_DIR_, 0777);

require_once(_PS_MODULE_DIR_.'pspagebuilder/classes/psrijndael.php');
require_once(_PS_MODULE_DIR_.'pspagebuilder/classes/mcrypt.php');
require_once(_PS_MODULE_DIR_.'pspagebuilder/classes/helper.php');
require_once(_PS_MODULE_DIR_.'pspagebuilder/classes/widgetbase.php');
require_once(_PS_MODULE_DIR_.'pspagebuilder/classes/profile.php');
