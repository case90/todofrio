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

class PsVerticalMenuWidgetHtml extends PsVerticalMenuWidgetBase {

	public $name = 'html';

	public function getWidgetInfo()
	{
		return array('label' => $this->l('HTML'), 'explain' => 'Create HTML With multiple Language');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();

		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'textarea',
					'label' => $this->l('Content'),
					'name' => 'htmlcontent',
					'cols' => 40,
					'rows' => 10,
					'value' => true,
					'lang' => true,
					'default' => '',
					'autoload_rte' => true,
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
			'name' => '',
			'html' => '',
		);
		$setting = array_merge($t, $setting);
		$language_id = Context::getContext()->language->id;
		$setting['html'] = isset($setting['htmlcontent_'.$language_id]) ? ($setting['htmlcontent_'.$language_id]) : '';
		$output = array('type' => 'html', 'data' => $setting);

		return $output;
	}

}
