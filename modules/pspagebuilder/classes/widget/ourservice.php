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

class PsWidgetOurservice extends PsWidgetPageBuilder {

	protected $max_image_size = 1048576;

	/**
	 *
	 */
	public $name = 'ourservice';
	public $group = 'image';

	/**
	 *
	 */
	public function beforeAdminProcess($controller)
	{
		if (!Tools::getValue('widgetaction'))
			$controller->addJS(__PS_BASE_URI__.'modules/pspagebuilder/views/js/admin/image_gallery.js');
	}

	/**
	 *
	 */
	public static function getWidgetInfo()
	{
		return array('label' => ('Our Service'), 'explain' => 'Create Service Information', 'group' => 'content');
	}

	/**
	 *
	 */
	public function renderForm($data)
	{
		$key = time();

		$helper = $this->getFormHelper();
		$types = array();
		$types[] = array(
			'value' => 'left',
			'text' => $this->l('Left')
		);
		$types[] = array(
			'value' => 'right',
			'text' => $this->l('Right')
		);
		$types[] = array(
			'value' => 'top',
			'text' => $this->l('Top')
		);
		$types[] = array(
			'value' => 'bottom',
			'text' => $this->l('Bottom')
		);

		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Image File'),
					'name' => 'imagefile',
					'class' => 'imageupload',
					'default' => '',
					'id' => 'imagefile'.$key,
					'desc' => 'Put image folder in the image folder ROOT_SHOP_DIR/img/'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Icon Class'),
					'name' => 'icon',
					'default' => 'icon-gear',
					'desc' => $this->l('If you use Icon Class, The image at bellow will be not used. you can use icon from font-awesome'),
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Content'),
					'name' => 'content',
					'default' => '',
					'lang' => true,
					'desc' => $this->l('If you use Icon Class, The image bellow will be not used.'),
					'autoload_rte' => true,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Image Size'),
					'name' => 'imagesize',
					'default' => '80x80',
					'desc' => $this->l('WIDTHxHEIGHT'),
				),
				array(
					'type' => 'select',
					'label' => $this->l('Icon Position'),
					'name' => 'icon_position',
					'options' => array('query' => $types,
						'id' => 'value',
						'name' => 'text'),
					'default' => 'left'
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
		$string = '
			 		<script type="text/javascript">
						$(".imageupload").WPO_Gallery({gallery:false});
					</script>
			';
		return '<div id="imageslist'.$key.'">'.$helper->generateForm($this->fields_form).$string.'</div>';
	}

	/**
	 *
	 */
	public function renderContent($setting)
	{
		$t = array(
			'name' => '',
			'image' => '',
			'imagesize' => '80x80',
			'alignment' => '',
			'animation' => '',
			'ispopup' => '1',
			'imageurl' => '',
			'icon' => '',
			'widget_heading' => '',
			'icon_position' => 'left'
		);

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
		$url = Tools::htmlentitiesutf8($protocol.$_SERVER['HTTP_HOST'].__PS_BASE_URI__);

		$setting = array_merge($t, $setting);
		$size = explode('x', $setting['imagesize']);
		//$setting['thumbnailurl'] = $url.'modules/pspagebuilder/images/'.$setting['imagefile'];
		//$setting['imageurl'] = $url.'modules/pspagebuilder/images/'.$setting['imagefile'];

		$setting['thumbnailurl'] = '';
		$setting['imageurl'] = '';

		if (count($size) == 2 && empty($setting['icon']))
		{
			$cache = _PS_CACHE_DIR_.'pspagebuilder/';
			if (!file_exists($cache.$setting['imagefile']))
			{
				if (!is_dir($cache))
					mkdir($cache, 0777);
				if (ImageManager::resize(_PAGEBUILDER_IMAGE_DIR_.$setting['imagefile'], $cache.$setting['imagefile'], $size[0], $size[1]))
					$setting['thumbnailurl'] = $url.'cache/pspagebuilder/'.$setting['imagefile'];
			}
			else
				$setting['thumbnailurl'] = $url.'cache/pspagebuilder/'.$setting['imagefile'];
		}

		$setting['content'] = $this->getValueByLang($setting, 'content');

		$output = array('type' => 'ourservice', 'data' => $setting);

		return $output;
	}

}
