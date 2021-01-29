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

class PsWidgetTab extends PsWidgetPageBuilder {

	public $name = 'tab';

	public static function getWidgetInfo()
	{
		return array('label' => ('Tab'), 'explain' => 'Tabs List', 'group' => 'typo');
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
					'type' => 'text',
					'label' => $this->l('Header 1'),
					'name' => 'header_1',
					'default' => 'Sample Header Tab 1',
					'lang' => true,
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Content 1'),
					'name' => 'content_1',
					'default' => 'Sample Content Tab 1',
					'cols' => 40,
					'rows' => 10,
					'value' => true,
					'lang' => true,
					'autoload_rte' => true,
					'desc' => $this->l('Enter Content 1')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Header 2'),
					'name' => 'header_2',
					'default' => 'Sample Header Tab 2', 'lang' => true,
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Content 2'),
					'name' => 'content_2',
					'default' => 'Sample Content Tab 2',
					'cols' => 40,
					'rows' => 9,
					'value' => true,
					'lang' => true,
					'autoload_rte' => true,
					'desc' => $this->l('Enter Content 2')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Header 3'),
					'name' => 'header_3',
					'default' => '', 'lang' => true,
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Content 3'),
					'name' => 'content_3',
					'default' => '',
					'cols' => 40,
					'rows' => 9,
					'value' => true,
					'lang' => true,
					'autoload_rte' => true,
					'desc' => $this->l('Enter Content 3')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Header 4'),
					'name' => 'header_4',
					'default' => '', 'lang' => true,
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Content 4'),
					'name' => 'content_4',
					'default' => '',
					'cols' => 40,
					'rows' => 9,
					'value' => true,
					'lang' => true,
					'autoload_rte' => true,
					'desc' => $this->l('Enter Content 4')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Header 5'),
					'name' => 'header_5',
					'default' => '', 'lang' => true,
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Content 5'),
					'name' => 'content_5',
					'default' => '',
					'cols' => 40,
					'rows' => 9,
					'value' => true,
					'lang' => true,
					'autoload_rte' => true,
					'desc' => $this->l('Enter Content 5')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Header 6'),
					'name' => 'header_6',
					'default' => '', 'lang' => true,
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Content 6'),
					'name' => 'content_6',
					'default' => '',
					'cols' => 40,
					'rows' => 9,
					'value' => true,
					'lang' => true,
					'autoload_rte' => true,
					'desc' => $this->l('Enter Content 6')
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

		$html = '';
		$language_id = Context::getContext()->language->id;

		if (is_array($setting['html']) && isset($setting['html'][$language_id]))
		{
			$html = $setting['html'][$language_id];
			$html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
		}

		$header = '';
		$content = $html;

		$ac = array();
		$language_id = Context::getContext()->language->id;

		for ($i = 1; $i <= 6; $i++)
		{
			$header = isset($setting['header_'.$i.'_'.$language_id]) ? $setting['header_'.$i.'_'.$language_id] : '';

			if (!empty($header))
			{
				$content = isset($setting['content_'.$i.'_'.$language_id]) ? $setting['content_'.$i.'_'.$language_id] : '';
				$ac[] = array('header' => $header, 'content' => trim($content));
			}
		}
		$setting['tabs'] = $ac;
		$setting['id'] = rand(1, 99);
		$output = array('type' => 'tab', 'data' => $setting);

		return $output;
	}

}

?>