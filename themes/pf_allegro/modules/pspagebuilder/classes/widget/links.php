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

class PsWidgetLinks extends PsWidgetPageBuilder {

	public $name = 'link';

	public static function getWidgetInfo()
	{
		return array('label' => ('Block Links'), 'explain' => 'Create List Block Links', 'group' => 'others');
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
					'label' => $this->l('Icon Class'),
					'name' => 'iconclass',
					'class' => 'image',
					'default' => '',
					'desc' => $this->l('You can use icon from font-awesome')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 1'),
					'name' => 'text_link_1',
					'default' => 'link 1',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 1'),
					'name' => 'link_1',
					'default' => '#link1',
					'desc' => $this->l('Enter Content Link 1')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 2'),
					'name' => 'text_link_2',
					'default' => 'link 2',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 2'),
					'name' => 'link_2',
					'default' => '#link2',
					'desc' => $this->l('Enter Content Link 2')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 3'),
					'name' => 'text_link_3',
					'default' => 'link3',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 3'),
					'name' => 'link_3',
					'default' => '#link3',
					'desc' => $this->l('Enter Content Link 3')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 4'),
					'name' => 'text_link_4',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 4'),
					'name' => 'link_4',
					'default' => '',
					'desc' => $this->l('Enter Content Link 4')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 5'),
					'name' => 'text_link_5',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 5'),
					'name' => 'link_5',
					'default' => '',
					'desc' => $this->l('Enter Content Link 5')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 6'),
					'name' => 'text_link_6',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 6'),
					'name' => 'link_6',
					'default' => '',
					'desc' => $this->l('Enter Content Link 6')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 7'),
					'name' => 'text_link_7',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 7'),
					'name' => 'link_7',
					'default' => '',
					'desc' => $this->l('Enter Content Link 7')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 8'),
					'name' => 'text_link_8',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 8'),
					'name' => 'link_8',
					'default' => '',
					'desc' => $this->l('Enter Content Link 8')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 9'),
					'name' => 'text_link_9',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 9'),
					'name' => 'link_9',
					'default' => '',
					'desc' => $this->l('Enter Content Link 9')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 10'),
					'name' => 'text_link_10',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 10'),
					'name' => 'link_10',
					'default' => '',
					'desc' => $this->l('Enter Content Link 10')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 11'),
					'name' => 'text_link_11',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 11'),
					'name' => 'link_11',
					'default' => '',
					'desc' => $this->l('Enter Content Link 11')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 12'),
					'name' => 'text_link_12',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 12'),
					'name' => 'link_12',
					'default' => '',
					'desc' => $this->l('Enter Content Link 12')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 13'),
					'name' => 'text_link_13',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 13'),
					'name' => 'link_13',
					'default' => '',
					'desc' => $this->l('Enter Content Link 13')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Text Link 14'),
					'name' => 'text_link_14',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link 14'),
					'name' => 'link_14',
					'default' => '',
					'desc' => $this->l('Enter Content Link 14')
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
			'name' => '',
			'html' => '',
			'iconclass' => '',
		);

		$setting = array_merge($t, $setting);

		$ac = array();
		$language_id = Context::getContext()->language->id;

		for ($i = 1; $i <= 14; $i++)
		{
			if (isset($setting['link_'.$i]) && trim($setting['link_'.$i]))
			{
				$link = isset($setting['text_link_'.$i.'_'.$language_id]) ?
								html_entity_decode($setting['text_link_'.$i.'_'.$language_id], ENT_QUOTES, 'UTF-8') : 'No Link Title';
				$ac[] = array('text' => $link, 'link' => trim($setting['link_'.$i]));
			}
		}

		$setting['id'] = rand();
		$setting['links'] = $ac;

		$output = array('type' => 'links', 'data' => $setting);

		return $output;
	}

}
