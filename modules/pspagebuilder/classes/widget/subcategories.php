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

class PsWidgetSubcategories extends PsWidgetPageBuilder {

	public $name = 'subcategories';

	public static function getWidgetInfo()
	{
		return array('label' => ('Sub Categories In Parent'), 'explain' => 'Show List Of Categories Links Of Parent', 'group' => 'prestashop');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();

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
						'root_category' => $this->context->shop->getCategory()
					)
				),
				array(
					'type' => 'text',
					'label' => $this->l('Limit'),
					'name' => 'limit',
					'default' => '6',
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
			'limit' => '12'
		);
		$setting = array_merge($t, $setting);

		$category = new Category($setting['id_parent'], $this->lang_id);
		$sub_categories = $category->getSubCategories($this->lang_id);
		$setting['title'] = $category->name;
		$setting['subcategories'] = $sub_categories;
		$output = array('type' => 'subcategories', 'data' => $setting);
		return $output;
	}

}
