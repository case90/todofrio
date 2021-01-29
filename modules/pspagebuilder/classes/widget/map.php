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

class PsWidgetMap extends PsWidgetPageBuilder {

	public $name = 'map';

	public static function getWidgetInfo()
	{
		return array('label' => ('Google Map'), 'explain' => 'Create A Google Map', 'group' => 'others');
	}

	public function renderForm($data)
	{
		$types = array();
		$types[] = array(
			'value' => 'ROADMAP',
			'text' => $this->l('ROADMAP')
		);
		$types[] = array(
			'value' => 'SATELLITE',
			'text' => $this->l('SATELLITE')
		);
		$types[] = array(
			'value' => 'HYBRID',
			'text' => $this->l('HYBRID')
		);
		$types[] = array(
			'value' => 'TERRAIN',
			'text' => $this->l('TERRAIN')
		);

		$helper = $this->getFormHelper();
		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Google Map API Key'),
					'name' => 'apikey',
					'default' => '',
					'desc' => $this->l('An API Key for Google Maps is required if you want to show maps for events or locactions.').'<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Get an API Key</a>',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Latitude'),
					'name' => 'latitude',
					'default' => 21.010904,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Longitude'),
					'name' => 'longitude',
					'default' => 105.787736,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Zoom'),
					'name' => 'zoom',
					'default' => 11,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Width'),
					'name' => 'width',
					'default' => 250,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Height'),
					'name' => 'height',
					'default' => 200,
				),
				array(
					'type' => 'select',
					'label' => $this->l('Map Type'),
					'name' => 'map_type',
					'options' => array('query' => $types,
						'id' => 'value',
						'name' => 'text'),
					'default' => 'ROADMAP'
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
			'apikey' => 'AIzaSyDj2QuD0yW1Kk3t_lgToAQkbdjjpGHVYho',
			'latitude' => '21.010904',
			'longitude' => '105.787736',
			'zoom' => 11,
			'width' => '250',
			'height' => '200',
			'is_preview' => trim(Tools::getValue('controller')) == 'widget' ? 1 : 0,
			'mapid' => 'map-'.(rand() + time()),
			'map_type' => 'ROADMAP'
		);

		$setting = array_merge($t, $setting);

		$setting['height'] = $setting['height'].'px';
		$setting['width'] = $setting['width'] == '100%' ? '100%' : $setting['width'].'px';
		$setting['apikey'] = $setting['apikey'] == '' ? 'AIzaSyDj2QuD0yW1Kk3t_lgToAQkbdjjpGHVYho' : $setting['apikey'];

		$output = array('type' => 'map', 'data' => $setting);

		return $output;
	}

}
