<?php
/**
 * Pts Prestashop Theme Framework for Prestashop 1.6.x
 *
 * @package   ptsbttestimonials
 * @version   1.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

class PtsTestimonial extends ObjectModel {

	public $avatar;
	public $name;
	public $email;
	public $company;
	public $address;
	public $media_id;
	public $media_type;
	public $media_code;
	public $date_add;
	public $position;
	public $active;
	/* languages fields */
	public $content;
	public $note;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'ptsbttestimonials',
		'primary' => 'id_ptsbttestimonials',
		'multilang' => true,
		'multishop' => true,
		'fields' => array(
			'avatar' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'required' => false, 'size' => 255),
			'name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 100),
			'email' => array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 100),
			'company' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => false, 'size' => 255),
			'address' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 500),
			'media_id' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => false, 'size' => 20),
			'media_type' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => false, 'size' => 20),
			'media_code' => array('type' => self::TYPE_STRING, 'validate' => 'isUrl', 'required' => false, 'size' => 100),
			'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
			'position' => array('type' => self::TYPE_INT, 'validate' => 'isunsignedInt', 'required' => true),
			'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
			/* languages fields */
			'content' => array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'required' => true, 'lang' => true,),
			'note' => array('type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'required' => false, 'lang' => true,),
		)
	);

	public function add($autodate = true, $null_values = false)
	{
		$context = Context::getContext();
		$id_shop = $context->shop->id;
		$res = parent::add($autodate, $null_values);
		$res &= Db::getInstance()->execute('
			INSERT INTO `'._DB_PREFIX_.'ptsbttestimonials_shop` (`id_shop`, `id_ptsbttestimonials`)
			VALUES('.(int)$id_shop.', '.(int)$this->id.')'
		);

		return $res;
	}

	public function delete()
	{
		$res = true;
		$images = $this->avatar;
		foreach ($images as $image)
			if (preg_match('/sample/', $image) === 0)
				if ($image && file_exists(dirname(__FILE__).'/views/img/'.$image))
					$res &= unlink(dirname(__FILE__).'/views/img/'.$image);

		$res &= $this->reOrderPositions();

		$res &= Db::getInstance()->execute('
			DELETE FROM `'._DB_PREFIX_.'ptsbttestimonials_shop`
			WHERE `id_ptsbttestimonials` = '.(int)$this->id
		);

		$res &= parent::delete();
		return $res;
	}

	public function reOrderPositions()
	{
		$id_test = $this->id;
		$context = Context::getContext();
		$id_shop = $context->shop->id;

		$max = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT MAX(pt.`position`) as pos
			FROM `'._DB_PREFIX_.'ptsbttestimonials` pt, `'._DB_PREFIX_.'ptsbttestimonials_shop` pts
			WHERE pt.`id_ptsbttestimonials` = pts.`id_ptsbttestimonials` AND pts.`id_shop` = '.(int)$id_shop
		);

		if ((int)$max == (int)$id_test)
			return true;

		$rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT pt.`position` as pos, pt.`id_ptsbttestimonials` as id_test
			FROM `'._DB_PREFIX_.'ptsbttestimonials` pt
			LEFT JOIN `'._DB_PREFIX_.'ptsbttestimonials_shop` pts ON (pt.`id_ptsbttestimonials` = pts.`id_ptsbttestimonials`)
			WHERE pts.`id_shop` = '.(int)$id_shop.' AND pt.`position` > '.(int)$this->position
		);

		foreach ($rows as $row)
		{
			$current_test = new PtsTestimonial($row['id_test']);
			--$current_test->position;
			$current_test->update();
			unset($current_test);
		}

		return true;
	}

}
