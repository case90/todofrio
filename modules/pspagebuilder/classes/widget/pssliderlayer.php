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

class PsWidgetPssliderlayer extends PsWidgetPageBuilder {

	public $name = 'pssliderlayer';

	public static function getWidgetInfo()
	{
		return array('label' => 'Ps Slider Layer', 'explain' => 'Integrate with Ps Slider layer Module to get slider', 'group' => 'others');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();

		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues($data),
			'languages' => Context::getContext()->controller->getLanguages(),
			'id_language' => $default_lang
		);

		$module = Module::getInstanceByName('pssliderlayer');
		if (!$module || (isset($module->id) && (!$module->id || !$module->active)))
		{
			$this->fields_form[1]['form'] = array(
				'legend' => array(
					'title' => $this->l('Widget Form.'),
					'desc' => $this->l('You need install or active the module leosliderlayer before')
				)
			);
			return $helper->generateForm($this->fields_form);
		}
		$id_shop = $this->context->shop->id;
		$groups = $this->getGroups(null, true, $id_shop);

		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'select',
					'label' => $this->l('Groups'),
					'name' => 'id_group',
					'options' => array('query' => $groups,
						'id' => 'id_pssliderlayer_groups',
						'name' => 'title'),
					'default' => '1',
					'desc' => $this->l('Select a Group to display')
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
			'id_group' => '1',
			'pssliderlayer_html' => '',
		);

		$setting = array_merge($t, $setting);

		$module = Module::getInstanceByName('pssliderlayer');
		if (!$module || (isset($module->id) && (!$module->id || !$module->active)))
		{
			$output = array('type' => 'pssliderlayer', 'data' => $setting);
			return $output;
		}
		$group = $this->getGroups($setting['id_group'], true);

		$html = $module->_processHook('pssliderlayer', $group);
		
		$setting['pssliderlayer_html'] = $html;
		$output = array('type' => 'pssliderlayer', 'data' => $setting);
		return $output;
	}

	public function getGroups($id = null, $active = null, $id_shop = null)
	{
		if (!isset($id_shop))
			$id_shop = Context::getContext()->shop->id;

		$sql = 'SELECT *
				FROM `'._DB_PREFIX_.'pssliderlayer_groups` gr
				WHERE (`id_shop` = '.(int)$id_shop.')'.
						($id ? ' AND id_pssliderlayer_groups = '.$id : '').
						($active ? ' AND gr.`active` = 1' : ' ');
		if ($id)
			$return = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($sql);
		else
			$return = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		return $return;
	}

}
