<?php
/*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class EventManager extends ObjectModel
{
	public $id_event_manager;
    public $title;
    public $description;
    public $event_place;
    public $address;
    public $lat;
    public $lang;
    public $event_date;
    public $active;
    public $date_add;
    public $date_upd;

    public static $definition = array(
    	'table' => 'event_manager',
        'primary' => 'id_event_manager',
        'fields' => array(
            'title' =>          array('type' => self::TYPE_STRING, 'required' => true),
            'description' => 	array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'size' => 3999999999999),
            'event_place' =>    array('type' => self::TYPE_STRING),
            'address' =>    	array('type' => self::TYPE_STRING),
            'lat' =>            array('type' => self::TYPE_STRING),
            'lang' =>           array('type' => self::TYPE_STRING),
            'event_date' =>     array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'active' =>         array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'date_add' =>       array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' =>       array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );

    public function __construct($id = null, $id_lang = null)
    {
    	parent::__construct($id);
    	
    	if (!is_null($id_lang)) {
            $this->id_lang = (int)(Language::getLanguage($id_lang) !== false) ? $id_lang : Configuration::get('PS_LANG_DEFAULT');
        }
    }

    public static function issetEvent($id_event_manager)
    {
        if(!(int)$id_event_manager)
            return false;

        $result = Db::getInstance()->executeS('
            SELECT EXISTS(
                SELECT 
                    e.`id_event_manager` 
                FROM `'._DB_PREFIX_.'event_manager` e
                WHERE e.`id_event_manager` = '.(int)$id_event_manager.'
            ) AS issetEvent'
        ); 

        return (bool)$result[0]['issetEvent'];
    }

    public static function isActive($id_event_manager)
    {
        if (!$id_event_manager)
            return false;

        $query = 'SELECT `active` FROM '._DB_PREFIX_.'event_manager WHERE `id_event_manager` = \''.(int)$id_event_manager.'\'';
        return (bool)Db::getInstance()->getValue($query);
    }
}