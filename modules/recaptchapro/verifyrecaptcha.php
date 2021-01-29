<?php
/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

require_once(dirname(__FILE__).'/../../config/config.inc.php');

if (Tools::getIsset('re_admin')) {
    $token = Tools::getAdminToken('AdminModules');
} else {
    $token = Tools::getToken(false);
}

if ($token == Tools::getValue('token')) {
    $post_data = http_build_query(
        array(
            'secret' => Tools::getValue('secret'),
            'response' => Tools::getValue('response'),
            'remoteip' => Tools::getValue('remoteip')
        )
    );
    
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $post_data
        )
    );
    
    $context  = stream_context_create($opts);
    $response = Tools::file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
    $result = json_decode($response);
    
    if ($result) {
        if ($result->success == true) {
            echo 'OK';
        } else {
            echo 'NOT-OK';
        }
    } else {
        echo 'NOT-OK';
    }
} else {
    die('Wrong token');
}
