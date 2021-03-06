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

class PsVerticalMenuWidgetAlert extends PsVerticalMenuWidgetBase {

	public $name = 'alert';

	public function getWidgetInfo()
	{
		return array('label' => $this->l('Alert'), 'explain' => 'Create a Alert Message Box Based on Bootstrap 3 typo');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();
		$types = array();
		$types[] = array(
			'value' => 'alert-success',
			'text' => $this->l('Alert Success')
		);
		$types[] = array(
			'value' => 'alert-info',
			'text' => $this->l('Alert Info')
		);
		$types[] = array(
			'value' => 'alert-warning',
			'text' => $this->l('Alert Warning')
		);
		$types[] = array(
			'value' => 'alert-danger',
			'text' => $this->l('Alert Danger')
		);

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
				array(
					'type' => 'select',
					'label' => $this->l('Alert Type'),
					'name' => 'alert_type',
					'options' => array('query' => $types,
						'id' => 'value',
						'name' => 'text'),
					'default' => '1',
					'desc' => $this->l('Select a alert style')
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
			'alert_type' => ''
		);
		$setting = array_merge($t, $setting);
		$language_id = Context::getContext()->language->id;
		$setting['html'] = isset($setting['htmlcontent_'.$language_id]) ?
			html_entity_decode($setting['htmlcontent_'.$language_id], ENT_QUOTES, 'UTF-8') : '';

		$output = array('type' => 'alert', 'data' => $setting);

		return $output;
	}

}
