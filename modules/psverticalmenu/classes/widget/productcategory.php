<?php
/**
 * Pts Prestashop Theme Framework for Prestashop 1.6.x
 *
 * @package   psverticalmenu
 * @version   1.4
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

class PsVerticalMenuWidgetProductcategory extends PsVerticalMenuWidgetBase {

	public $name = 'productcategory';

	public function getWidgetInfo()
	{
		return array('label' => $this->l('Products By Category ID'), 'explain' => 'Created Product List From Category ID');
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
			'input' => array(
				array(
					'type' => 'categories',
					'label' => $this->l('Parent category'),
					'name' => 'id_parent'
				)
			)
		);
		$fields_value = $this->getConfigFieldsValues($data);
		$selected_categories = array((isset($fields_value['id_parent']) && $fields_value['id_parent']) ? $fields_value['id_parent'] : 0);

		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'categories',
					'label' => $this->l('Parent category'),
					'name' => 'id_parent',
					'tree' => array(
						'id' => 'categories-tree',
						'selected_categories' => $selected_categories,
						'disabled_categories' => null,
						'root_category' => Context::getContext()->shop->getCategory()
					),
					'default' => '',
				),
				array(
					'type' => 'select',
					'label' => $this->l('Products Order By'),
					'name' => 'list_type',
					'options' => array('query' => $types,
						'id' => 'value',
						'name' => 'text'),
					'default' => 'newest',
					'desc' => $this->l('Select a Product List Type')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Limit'),
					'name' => 'limit',
					'default' => 6,
				)
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
			'id_parent' => '',
			'limit' => '12',
			'image_width' => '200',
			'image_height' => '200',
		);
		$setting = array_merge($t, $setting);
		$nb = (int)$setting['limit'];

		$category = new Category($setting['id_parent'], $this->lang_id);
		$products = $category->getProducts((int)$this->lang_id, 1, ($nb ? $nb : 8));

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
		$output = array('type' => 'productcategory', 'data' => $setting);

		return $output;
	}

}
