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

class PsWidgetSocialshare extends PsWidgetPageBuilder {

	public $name = 'socialshare';
	protected static $networks = array('Facebook', 'Twitter', 'Google', 'Pinterest');

	public static function getWidgetInfo()
	{
		return array('label' => 'Social Share', 'explain' => 'Get list of sharing socials', 'group' => 'social');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();

		$fields = array();
		foreach (self::$networks as $network)
		{
			$fields[] = array(
				'type' => 'switch',
				'label' => $network,
				'name' => 'PS_SC_'.Tools::strtoupper($network),
				'values' => array(
					array(
						'id' => Tools::strtolower($network).'_active_on',
						'value' => 1,
						'label' => $this->l('Enabled')
					),
					array(
						'id' => Tools::strtolower($network).'_active_off',
						'value' => 0,
						'label' => $this->l('Disabled')
					)
				)
			);
		}

		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Separator Form.')
			),
			'input' => $fields,
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
			'separ_title' => 'separator here',
			'title_align' => 'separator_align_center',
			'pagelink' => '',
			'pagename' => '',
		);

		$setting = array_merge($t, $setting);
		$s = '';
		$setting['pagelink'] = 'http'.$s.'://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI'];

		$output = array('type' => 'socialshare', 'data' => $setting);
		return $output;
	}

}
