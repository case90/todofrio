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

class PsWidgetInstagram extends PsWidgetPageBuilder {

	/**
	 *
	 */

	/**
	 *
	 */
	public $name = 'instagram';
	public $group = 'Social';
	/**
	 *
	 */
	/**
	 *
	 */
	public static function getWidgetInfo()
	{
		return array('label' => ('Instagram'), 'explain' => 'Create Instagram Images Gallery From Instagram Account', 'group' => 'instagram');
	}

	/**
	 *
	 */
	public function renderForm($data)
	{
		$key = time();

		$helper = $this->getFormHelper();
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
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('User ID'),
					'name' => 'i_user',
					'default' => '1213565508',
					'desc' => 'Enter Instagram User ID'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Token code'),
					'name' => 'i_token',
					'default' => '1213565508.1677ed0.e31553e458274a178d41daa1968e9671',
					'desc' => "Enter Instagram Token Code"
				),

				array(
					'type' => 'select',
					'label' => $this->l( 'Image Click Type' ),
					'name' => 'img_click_type',
					'options' => array(  'query' => array(
						array('id' => 'i_link', 'name' => $this->l('Instagram Link')),
						array('id' => 'popup', 'name' => $this->l('Pop Up'))
						),
					'id' => 'id',
					'name' => 'name' ),
					'default' => "",
				),
				array(
					'type' => 'select',
					'label' => $this->l( 'Display Mode' ),
					'name' => 'display_mode',
					'options' => array(  'query' => array(
						array('id' => 'carousel', 'name' => $this->l('Carousel')),
						array('id' => 'normal', 'name' => $this->l('Normal'))
						),
					'id' => 'id',
					'name' => 'name' ),
					'default' => "carousel",
				),

				array(
					'type' => 'text',
					'label' => $this->l('Limit'),
					'name' => 'limit',
					'default' => '6',
					'desc' => "Enter limit amount of images to show",
					'class' => 'fixed-width-xs'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Number Columns On Large Desktops.'),
					'name' => 'columns',
					'desc' => $this->l('The maximum column items  in tab.'),
					'default' => '4'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Number Columns On Small Desktops'),
					'name' => 'nbr_desktops',
					'default' => '4'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Number Columns On Tablets'),
					'name' => 'nbr_tablets',
					'default' => '2'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Number Columns On Mobile'),
					'name' => 'nbr_mobile',
					'default' => '1'
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

	/**
	 *
	 */
	public function renderContent($setting)
	{

		$url = "https://api.instagram.com/v1/users/".$setting['i_user']."/media/recent?access_token=".$setting['i_token']."&count=".$setting['limit'];
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$json = curl_exec($ch);
		curl_close($ch);
		$result = Tools::jsonDecode($json,true);
		$setting['i_images'] = $result['data'];

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
		$url = Tools::htmlentitiesutf8($protocol.$_SERVER['HTTP_HOST'].__PS_BASE_URI__);
		$list_mode_tpl = _PS_MODULE_DIR_.'/pspagebuilder/views/templates/front/widgets/sub/item_instagram.tpl';
		$tlist_mode_tpl = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/modules/pspagebuilder/views/templates/front/widgets/sub/item_instagram.tpl';
		if (file_exists($tlist_mode_tpl)) {
			$list_mode_tpl = $tlist_mode_tpl;
		}
		$setting['list_mode_tpl'] = $list_mode_tpl;

		$output = array('type' => 'instagram', 'data' => $setting);

		return $output;
	}

}
?>