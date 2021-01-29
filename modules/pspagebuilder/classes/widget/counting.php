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

class PsWidgetCounting extends PsWidgetPageBuilder {

	public $name = 'counting';
	public $group = 'typo';

	public static function getWidgetInfo()
	{
		return array('label' => ('Counting Number'), 'explain' => 'Play Counting Number In Effect', 'group' => 'typo');
	}

	public function beforeAdminProcess($controller)
	{
		if (!Tools::getValue('widgetaction'))
			$controller->addJS(__PS_BASE_URI__.'modules/pspagebuilder/views/js/admin/image_gallery.js');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();
		$types = array();
		$types[] = array(
			'value' => '',
			'text' => $this->l('Default')
		);
		$types[] = array(
			'value' => 'text-warning',
			'text' => $this->l('Text Warning')
		);
		$types[] = array(
			'value' => 'text-danger',
			'text' => $this->l('Text Danger')
		);
		$types[] = array(
			'value' => 'text-info',
			'text' => $this->l('Text Info')
		);
		$types[] = array(
			'value' => 'text-success',
			'text' => $this->l('Text Success')
		);
		$types[] = array(
			'value' => 'text-purple',
			'text' => $this->l('Text Purple')
		);
		$types[] = array(
			'value' => 'text-red',
			'text' => $this->l('Text Red')
		);
		$types[] = array(
			'value' => 'text-orange',
			'text' => $this->l('Text Orange')
		);
		$types[] = array(
			'value' => 'text-yellow',
			'text' => $this->l('Text Yellow')
		);
		$types[] = array(
			'value' => 'text-light',
			'text' => $this->l('Text Light')
		);
		$types[] = array(
			'value' => 'text-darker',
			'text' => $this->l('Text Darker')
		);
		$key = time();
		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Icon File'),
					'name' => 'iconfile',
					'class' => 'imageupload',
					'default' => '',
					'id' => 'iconfile'.$key,
					'desc' => $this->l('Put image folder in the image folder')._PAGEBUILDER_IMAGE_URL_.'images/'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Icon Class'),
					'name' => 'iconclass',
					'class' => 'image',
					'default' => '',
					'desc' => $this->l('Example: fa-umbrella fa-2 radius-x')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Counting Number'),
					'name' => 'counting_number',
					'default' => ''
				),
				array(
					'type' => 'select',
					'label' => $this->l('Text Color'),
					'name' => 'text_color',
					'options' => array('query' => $types,
						'id' => 'value',
						'name' => 'text'),
					'default' => '',
					'desc' => $this->l('Select a text style')
				)
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			)
		);

		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		$a = $this->getConfigFieldsValues($data);

		$helper->tpl_vars = array(
			'fields_value' => $a,
			'languages' => Context::getContext()->controller->getLanguages(),
			'id_language' => $default_lang
		);

		$string = '
					<script type="text/javascript">
						$(".imageupload").WPO_Gallery({gallery:false});
					</script>
			';
		return '<div id="imageslist'.$key.'">'.$helper->generateForm($this->fields_form).$string.'</div>';
	}

	public function renderContent($setting)
	{
		$t = array(
			'name' => '',
			'iconfile' => '',
			'iconclass' => '',
			'counting_number' => '',
			'text_color' => ''
		);
		$setting = array_merge($t, $setting);
		if (!empty($setting['iconfile']))
			$setting['iconurl'] = _PAGEBUILDER_IMAGE_URL_.$setting['iconfile'];

		$output = array('type' => 'counting', 'data' => $setting);

		return $output;
	}

}
