<?php
/**
 * Pts Prestashop Theme Framework for Prestashop 1.6.x
 *
 * @package   psmegamenu
 * @version   2.5.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

class PsMegamenuWidgetProductlist extends PsMegamenuWidgetBase {

	public $name = 'productlist';

	public function getWidgetInfo()
	{
		return array('label' => $this->l('Product List'), 'explain' => 'Product List With Option: Newest, Bestseller, Special, Featured');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();
		$types = array();
		$types[] = array(
			'value' => 'newest',
			'text' => $this->l('Products Newest')
		);
		$types[] = array(
			'value' => 'bestseller',
			'text' => $this->l('Products Bestseller')
		);

		$types[] = array(
			'value' => 'special',
			'text' => $this->l('Products Special')
		);

		$types[] = array(
			'value' => 'featured',
			'text' => $this->l('Products Featured')
		);

		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Limit'),
					'name' => 'limit',
					'default' => 6,
				),
				array(
					'type' => 'select',
					'label' => $this->l('Products List Type'),
					'name' => 'list_type',
					'options' => array('query' => $types,
						'id' => 'value',
						'name' => 'text'),
					'default' => 'newest',
					'desc' => $this->l('Select a Product List Type')
				),
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			)
		);

		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues($data),
			'languages' => Context::getContext()->controller->getLanguages(),
			'id_language' => $default_lang
		);

		return $helper->generateForm($this->fields_form);
	}

	public function renderContent($setting)
	{
		$t = array(
			'list_type' => '',
			'limit' => 12,
			'image_width' => '200',
			'image_height' => '200',
		);
		$products = array();
		$setting = array_merge($t, $setting);

		switch ($setting['list_type'])
		{
			case 'newest':
				$products = Product::getNewProducts($this->lang_id, 0, (int)$setting['limit']);
				break;
			case 'featured':
				$category = new Category(Context::getContext()->shop->getCategory(), $this->lang_id);
				$nb = (int)$setting['limit'];
				$products = $category->getProducts((int)$this->lang_id, 1, ($nb ? $nb : 8));
				break;
			case 'bestseller':
				$products = ProductSale::getBestSalesLight((int)$this->lang_id, 0, (int)$setting['limit']);
				break;
			case 'special':
				$products = Product::getPricesDrop($this->lang_id, 0, (int)$setting['limit']);
				break;
		}
		$setting['products'] = $products;
		$output = array('type' => 'productlist', 'data' => $setting);
		return $output;
	}

}