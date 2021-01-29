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

class PsWidgetImage extends PsWidgetPageBuilder {

	/**
	 *
	 */
	protected $max_image_size = 1048576;

	/**
	 *
	 */
	public $name = 'image';
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
		return array('label' => ('Single Image'), 'explain' => 'Create Images Mini Gallery From Folder', 'group' => 'image');
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
					'label' => $this->l('Image File'),
					'name' => 'imagefile',
					'class' => 'imageupload',
					'default' => '',
					'id' => 'imagefile'.$key,
					'desc' => 'Put image folder in the image folder ROOT_SHOP_DIR/img/'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Image size'),
					'name' => 'size',
					'class' => 'image',
					'default' => '',
					'id' => 'imagesize'.$key,
					'desc' => "Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. 
						Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size."
				),
				array(
					'type' => 'select',
					'label' => $this->l('CSS3 Animation'),
					'name' => 'animation',
					'options' => array('query' => array(
							array('id' => '1', 'name' => $this->l('1 Column')),
							array('id' => '2', 'name' => $this->l('2 Columns')),
							array('id' => '3', 'name' => $this->l('3 Columns')),
							array('id' => '4', 'name' => $this->l('4 Columns')),
							array('id' => '5', 'name' => $this->l('5 Columns')),
						),
						'id' => 'id',
						'name' => 'name'),
					'default' => '4',
				),
				array(
					'type' => 'select',
					'label' => $this->l('Image Alignment'),
					'name' => 'alignment',
					'desc' => 'Select image alignment',
					'options' => array('query' => array(
							array('id' => 'left', 'name' => $this->l('Align Left')),
							array('id' => 'right', 'name' => $this->l('Align Right')),
							array('id' => 'center', 'name' => $this->l('Align Center'))
						),
						'id' => 'id',
						'name' => 'name'),
					'default' => 'left',
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Enable Popup Image'),
					'desc' => $this->l('Show the original image on a modal box'),
					'name' => 'ispopup',
					'default' => 1,
					'values' => $soption,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Link'),
					'name' => 'link_url',
					'class' => 'link',
					'default' => '',
					'id' => 'link'.$key,
					'desc' => 'Enter url if you want this image to have link'
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
			'imagesize' => '',
			'alignment' => '',
			'animation' => '',
			'ispopup' => '1',
			'imageurl' => '',
		);

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
		$url = Tools::htmlentitiesutf8($protocol.$_SERVER['HTTP_HOST'].__PS_BASE_URI__);

		$setting = array_merge($t, $setting);

		$size = explode('x', $setting['size']);

		$setting['thumbnailurl'] = _PAGEBUILDER_IMAGE_URL_.$setting['imagefile'];
		$setting['imageurl'] = _PAGEBUILDER_IMAGE_URL_.$setting['imagefile'];
		if (count($size) == 2)
		{
			$cache = _PS_CACHE_DIR_.'pspagebuilder/';
			if (!file_exists($cache.$setting['imagefile']))
			{
				if (!is_dir($cache))
					mkdir($cache, 0755);
				if (ImageManager::resize(_PAGEBUILDER_IMAGE_DIR_.$setting['imagefile'], $cache.$setting['imagefile'], $size[0], $size[1]))
					$setting['thumbnailurl'] = $url.'cache/pspagebuilder/'.$setting['imagefile'];
			}
			else
				$setting['thumbnailurl'] = $url.'cache/pspagebuilder/'.$setting['imagefile'];
		}

		$output = array('type' => 'image', 'data' => $setting);

		return $output;
	}

}
