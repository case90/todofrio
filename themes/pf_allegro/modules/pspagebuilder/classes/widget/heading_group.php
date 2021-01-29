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

class PsWidgetHeading_group extends PsWidgetPageBuilder {

	public $name = 'heading_group';

	public static function getWidgetInfo()
	{
		return array('label' => ('Heading group'), 'explain' => 'Display Heading group', 'group' => 'prestabrain');
	}


	public function renderForm($data)
	{
		$helper = $this->getFormHelper();
		$style = array(
			array('value' => 'default', 'text' => $this->l('default')),
			array('value' => 'style1', 'text' => $this->l('style1')),
		);
		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Sub Title'),
					'name' => 'subtitle',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'select',
					'label' => $this->l('Style for heading'),
					'name' => 'heading_style',
					'options' => array('query' => $style,
						'id' => 'value',
						'name' => 'text'),
					'default' => 'default',
				)
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			)
		);

		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		$fields_value = $this->getConfigFieldsValues($data);

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
			'subtitle' => '',
			'heading_style' => 'default'
		);

		$setting = array_merge($t, $setting);

		$language_id = Context::getContext()->language->id;
		$setting['subtitle'] = isset($setting['subtitle_'.$language_id]) ? ($setting['subtitle_'.$language_id]) : '';
		$output = array('type' => 'heading_group', 'data' => $setting);

		return $output;
	}

}
