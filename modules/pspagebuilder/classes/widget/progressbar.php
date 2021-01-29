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

class PsWidgetProgressbar extends PsWidgetPageBuilder {

	public $name = 'progressbar';
	public $group = 'typo';

	public static function getWidgetInfo()
	{
		return array('label' => 'Progress bar', 'explain' => 'Progress bar', 'group' => 'typo');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();

		$type_progress = array(
			array('id' => 'progress', 'name' => $this->l('Contextual alternatives')),
			array('id' => 'progress progress-striped', 'name' => $this->l('Striped')),
			array('id' => 'progress progress-striped active', 'name' => $this->l('Animated')),
			array('id' => 'stacked', 'name' => $this->l('Stacked')),
		);
		$soption = array(
			array(
				'id' => 'active_on',
				'value' => 1,
				'label' => $this->l('Enabled')
			),
			array(
				'id' => 'active_off',
				'value' => 0,
				'label' => $this->l('Disabled')
			)
		);

		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Progress Bar Form.'),
			),
			'input' => array(
				array(
					'type' => 'select',
					'label' => $this->l('Type'),
					'desc' => $this->l('Select type progress bar'),
					'name' => 'prog_type',
					'options' => array(
						'query' => $type_progress,
						'id' => 'id',
						'name' => 'name',
					),
					'default' => 'progress',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Green color(success)'),
					'name' => 'success',
					'desc' => $this->l('value input: type|value|min|max'),
					'default' => 'success|40|0|100',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Blue color(infotmation)'),
					'name' => 'info',
					'desc' => $this->l('value input: type|value|min|max'),
					'default' => 'info|20|0|100',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Orange color(warning)'),
					'name' => 'warning',
					'desc' => $this->l('value input: type|value|min|max'),
					'default' => 'warning|60|0|100',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Red color(danger)'),
					'name' => 'danger',
					'desc' => $this->l('value input: type|value|min|max'),
					'default' => 'danger|80|0|100',
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Show label'),
					'desc' => $this->l('Progress bar will be showed label.'),
					'name' => 'prog_label',
					'default' => '1',
					'values' => $soption,
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
			'prog_type' => 'progress',
			'success' => 'success|40|0|100',
			'info' => 'info|40|0|100',
			'warning' => 'warning|40|0|100',
			'danger' => 'danger|40|0|100',
			'prog_label' => '0',
		);
		$setting = array_merge($t, $setting);

		$output = array('type' => 'progressbar', 'data' => $setting);
		return $output;
	}

}
