<?php
/*
* 2007-2016 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');


if(Tools::getValue('test_conn'))
{
	error_reporting(0);

	$servername = Tools::getValue('server');
	$username 	= Tools::getValue('user');
	$password 	= Tools::getValue('pass');
	
	$conn = new mysqli($servername, $username, $password);
	
	if ($conn->connect_errno) {

    	echo json_encode(
    		array(
    			'messgeType'	=> 'error',
    			'class'			=> 'alert alert-danger',
    			'message' 		=> 'No ha sido posible establecer la conexión con la base de datos :(',
    		)
    	);

	}else{

		$conn->close();
		echo json_encode(
    		array(
    			'messgeType'	=> 'success',
    			'class'			=> 'alert alert-success',
    			'message' 		=> 'La conexión ha sido exitosa :)',
    		)
    	);

	}

	
}

