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

class PsWidgetPromotions extends PsWidgetPageBuilder {

	public $name = 'promotions';
	public $group = 'product';

	public static function getWidgetInfo()
	{
		return array('label' => ('Promotions'), 'explain' => 'Display Promotions', 'group' => 'prestashop');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();

		$types = array();
		$types[] = array(
			'value' => 'tab',
			'text' => $this->l('Tab')
		);
		$types[] = array(
			'value' => 'carousel',
			'text' => $this->l('Carousel')
		);

		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'select',
					'label' => $this->l('Type Display'),
					'name' => 'type_display',
					'options' => array('query' => $types,
						'id' => 'value',
						'name' => 'text'),
					'default' => 'carousel'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Column'),
					'name' => 'column',
					'default' => 4,
					'desc' => $this->l('Show In Carousel with N Column in each page')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Items Per Page'),
					'name' => 'itemsperpage',
					'default' => 4,
					'desc' => $this->l('Show In Carousel, Max Item in each page')
				),
				array(
					'type' => 'promotions',
					'label' => $this->l('Promotions'),
					'name' => 'promotions',
					'default' => '',
				)
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			)
		);

		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		$fields_value = $this->getConfigFieldsValues($data);
		$fields_value['promotions'] = $fields_value['promotions'] ? Tools::jsonDecode($fields_value['promotions'], true) : '';

		$helper->tpl_vars = array(
			'fields_value' => $fields_value,
			'languages' => Context::getContext()->controller->getLanguages(),
			'id_language' => $default_lang
		);

		return $helper->generateForm($this->fields_form);
	}

	/**
	 *
	 */
	public function renderContent($setting)
	{
		$t = array(
			'promotions' => '',
			'type_display' => '',
			'itemsperpage' => 4,
			'column' => 4,
			'randId' => rand(100, 20000)
		);

		$setting = array_merge($t, $setting);

		if (!empty($setting['promotions']))
		{
			$promotions = Tools::jsonDecode($setting['promotions'], true);
			foreach ($promotions as &$value)
				if ($value['image'])
					$value['imageurl'] = _PAGEBUILDER_IMAGE_URL_.$value['image'];
			$setting['promotions'] = $promotions;
		}
		$output = array('type' => 'promotions', 'data' => $setting);

		return $output;
	}

}
