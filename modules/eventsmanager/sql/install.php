<?php
/**
* 2007-2018 PrestaShop
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
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'event_manager` (
    `id_event_manager` int(11) NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(50) NOT NULL,
    `description` TEXT,
    `event_place` VARCHAR(255),
    `address` VARCHAR(255),
    `lat` VARCHAR(30),
    `lang` VARCHAR(30),
    `event_date` DATETIME NOT NULL,
    `date_add` DATETIME NOT NULL,
    `date_upd` DATETIME NOT NULL,
    PRIMARY KEY  (`id_event_manager`),
    KEY `event_date_add` (`date_add`),
    KEY `event_date_upd` (`date_upd`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'bystander` (
    `id_bystander` int(11) NOT NULL AUTO_INCREMENT,
    `id_event_manager` int(11) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `paternal_name` VARCHAR(50) NOT NULL,
    `maternal_name` VARCHAR(50) NOT NULL,
    `fullname` VARCHAR(255) NOT NULL,
    `business_name` VARCHAR(255) NOT NULL,
    `phone1` VARCHAR(15) NOT NULL,
    `phone2` VARCHAR(15) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `curp` VARCHAR(20) NOT NULL,
    `place_origin` VARCHAR(50) DEFAULT 0,
    `attended_event` int(2) DEFAULT 0,
    `type_mail_sent` int(11) DEFAULT 0,
    `date_add` DATETIME NOT NULL,
    `date_upd` DATETIME NOT NULL,
    PRIMARY KEY  (`id_bystander`, `curp`, `id_event_manager`),
    KEY `event_manager_fullname` (`fullname`),
    KEY `event_manager_curp` (`curp`),
    KEY `event_manager_email_type` (`type_mail_sent`),
    KEY `event_manager_date_add` (`date_add`),
    KEY `event_manager_date_upd` (`date_upd`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';


$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'eventsmanager_email_type` (
    `id_eventsmanager_email_type` int(11) NOT NULL AUTO_INCREMENT,
    `description` int(11) NOT NULL,
    `date_add` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_upd` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY  (`id_eventsmanager_email_type`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

/*
$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'event_manager_bystander` (
    `id_event_manager_bystander` int(11) NOT NULL AUTO_INCREMENT,
    `id_event_manager` int(11) NOT NULL,
    `id_bystander` int(11) NOT NULL,
    `attended_event` int(11) DEFAULT 0,
    PRIMARY KEY  (`id_event_manager_bystander`, `id_event_manager`, `id_bystander`),
    KEY `event_customer_id_event_manager` (`id_event_manager`),
    KEY `event_customer_id_bystander` (`id_bystander`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';
*/

/*$sql[] = 'ALTER TABLE `'._DB_PREFIX_.'customer` 
    ADD COLUMN `business_name` VARCHAR(255) NOT NULL DEFAULT 0,
    ADD COLUMN `rfc` VARCHAR(13) NOT NULL DEFAULT 0,
    ADD COLUMN `phone1` VARCHAR(15) NOT NULL DEFAULT 0,
    ADD COLUMN `phone2` VARCHAR(15) NOT NULL DEFAULT 0;';*/


foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
