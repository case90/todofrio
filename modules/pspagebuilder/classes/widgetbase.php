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

abstract class PsWidgetPageBuilder {

	public $mod_name = 'pspagebuilder';
	public $name = 'base';
	public $group = 'others';
	public $id_shop = 0;
	public $fields_form = array();
	public $types = array();
	public $lang_id;
	public $context;

	public function __construct()
	{
		$this->context = Context::getContext();
	}

	/**
	 * abstract method to return html widget form
	 */
	public static function getWidgetInfo()
	{
		return array('key' => 'base', 'label' => 'Widget Base');
	}

	public static function renderButton()
	{
		return 'nono';
	}

	public function processAdminPost()
	{
		return '';
	}

	public function processFontEndPost()
	{
		return '';
	}

	public function beforeAdminProcess($controller)
	{
		return $controller;
	}

	public function beforeRender()
	{
		return '';
	}

	public function renderAdminContent()
	{
		return '';
	}

	/**
	 * abstract method to return html widget form
	 */
	abstract public function renderForm($data);

	/**
	 * abstract method to return widget data 
	 */
	abstract public function renderContent($data);

	/**
	 * Get translation for a given module text
	 *
	 * Note: $specific parameter is mandatory for library files.
	 * Otherwise, translation key will not match for Module library
	 * when module is loaded with eval() Module::getModulesOnDisk()
	 *
	 * @param string $string String to translate
	 * @param boolean|string $specific filename to use in translation key
	 * @return string Translation
	 */
	public function l($string, $specific = false)
	{
		return Translate::getModuleTranslation($this->mod_name, $string, ($specific) ? $specific : $this->mod_name);
	}

	/**
	 * Asign value for each input of Data form
	 */
	public function getConfigFieldsValues($data = null)
	{
		$languages = Language::getLanguages(false);
		$fields_values = array();
		$obj = isset($data['params']) ? $data['params'] : array();

		foreach ($this->fields_form as $k => $f)
		{
			foreach ($f['form']['input'] as $j => $input)
			{
				if (isset($input['lang']))
					foreach ($languages as $lang)
						$fields_values[$input['name']][$lang['id_lang']] = isset($obj[$input['name'].'_'.$lang['id_lang']]) ?
							$obj[$input['name'].'_'.$lang['id_lang']] : $input['default'];
				else
				{
					if (isset($obj[trim($input['name'])]))
					{
						$value = $obj[trim($input['name'])];
						if ($input['name'] == 'image' && $value)
						{
							$thumb = __PS_BASE_URI__.'modules/'.$this->name.'/img/'.$value;
							$this->fields_form[$k]['form']['input'][$j]['thumb'] = $thumb;
						}
						$fields_values[$input['name']] = $value;
					}
					else
					{
						$v = Tools::getValue($input['name'], Configuration::get($input['name']));
						$fields_values[$input['name']] = $v ? $v : (isset($input['default']) ? $input['default'] : '');
					}
				}
			}
		}
		if (isset($data['id_widget']))
			$fields_values['id_widget'] = $data['id_widget'];
		return $fields_values;
	}

	public function getFormHelper()
	{
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
		$styles = PsPagebuilderHelper::detectWidgetClasses();

		$this->fields_form[0]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Info.'),
			),
			'input' => array(
				array(
					'type' => 'hidden',
					'label' => $this->l('Widget Key'),
					'name' => 'wkey',
					'default' => Tools::getValue('wkey'),
					'desc' => $this->l('Using for show in Listing Widget Management')
				),
				array(
					'type' => 'hidden',
					'label' => $this->l('Widget Type'),
					'name' => 'wtype',
					'default' => $this->name,
					'desc' => $this->l('Using for show in Listing Widget Management')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Widget Name'),
					'name' => 'widget_name',
					'default' => '',
					'desc' => $this->l('Using for show in Listing Widget Management')
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Display Title'),
					'desc' => $this->l('Show the title on the widget block'),
					'name' => 'show_title',
					'default' => 1,
					'values' => array(
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
					),
				),
				array(
					'type' => 'text',
					'label' => $this->l('Widget Title'),
					'name' => 'widget_title',
					'default' => '',
					'lang' => true,
					'desc' => $this->l('This tile will be showed as header of widget block. Empty to disable')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Addition Class'),
					'name' => 'addition_cls',
					'default' => '',
					'desc' => $this->l('This class is used to make owner style for the widget.')
				),
				array(
					'type' => 'select',
					'label' => $this->l('Widget Box Style'),
					'name' => 'stylecls',
					'options' => array('query' => $styles['widget'],
						'id' => 'class',
						'name' => 'name'),
					'default' => '',
					'desc' => $this->l('These classes are automatic loaded in file pagebuider.css in module or actived theme')
				)
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			)
		);
		//d($styles);
		$helper = new HelperForm();
		$helper->module = new $this->mod_name;
		$helper->name_controller = $this->mod_name;
		$helper->identifier = $this->mod_name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		foreach (Language::getLanguages(false) as $lang)
			$helper->languages[] = array(
				'id_lang' => $lang['id_lang'],
				'iso_code' => $lang['iso_code'],
				'name' => $lang['name'],
				'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0)
			);

		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->mod_name.'&widgets=1&rand='.rand().'&wtype='.Tools::getValue('wtype');
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		$helper->toolbar_scroll = true;
		$helper->title = $this->mod_name;
		$helper->submit_action = 'save'.$this->mod_name;

		$helper->toolbar_btn = array(
			'back' => array(
				'desc' => $this->l('Back'),
				'href' => AdminController::$currentIndex.'&configure='.$this->mod_name.'&save'.
						$this->mod_name.'&token='.Tools::getAdminTokenLite('AdminModules').'&widgets=1&rand='.rand(),
			)
		);

		return $helper;
	}

	public function getValueByLang($setting, $key)
	{
		return isset($setting[$key.'_'.$this->lang_id]) ? $setting[$key.'_'.$this->lang_id] : 0;
	}

	public function getProductListStyleFile($list_mode, $default_style)
	{
		if ($list_mode == 'grid' && $default_style && file_exists(_PS_ALL_THEMES_DIR_._THEME_NAME_.'/sub/product/'.$default_style.'.tpl')) {
			$list_mode_tpl = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/sub/product/'.$default_style.'.tpl';
		} else {
			$list_mode = !$list_mode ? 'grid' : $list_mode;
			$list_mode_tpl = _PS_MODULE_DIR_.'pspagebuilder/views/templates/front/widgets/sub/item_product_'.$list_mode.'.tpl';
			$tlist_mode_tpl = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/modules/pspagebuilder/views/templates/front/widgets/sub/item_product_'.$list_mode.'.tpl';
			if (file_exists($tlist_mode_tpl)) {
				$list_mode_tpl = $tlist_mode_tpl;
			}
		}
		return $list_mode_tpl;
	}
}
