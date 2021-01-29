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

class PsWidgetGallery extends PsWidgetPageBuilder {

	protected $max_image_size = 1048576;
	public $name = 'gallery';
	public $group = 'image';

	public function beforeAdminProcess($controller)
	{
		if (!Tools::getValue('widgetaction'))
			$controller->addJS(__PS_BASE_URI__.'modules/pspagebuilder/views/js/admin/image_gallery.js');
	}

	public static function getWidgetInfo()
	{
		return array('label' => ('Images Gallery'), 'explain' => 'Create Images Mini Gallery From Folder', 'group' => 'image');
	}

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
					'label' => $this->l('Sub Title'),
					'name' => 'subtitle',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Image Folder Path'),
					'name' => 'imageslist',
					'class' => 'imageupload',
					'default' => '',
					'id' => 'imageslist'.$key,
					'desc' => 'Put image folder in the image folder ROOT_SHOP_DIR/img/'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Image size'),
					'name' => 'size',
					'class' => 'image',
					'default' => '',
					'id' => 'imagesize'.$key,
					'desc' => 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. 
						Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.'
				),
				array(
					'type' => 'select',
					'label' => $this->l('Columns'),
					'name' => 'columns',
					'options' => array('query' => array(
							array('id' => '1', 'name' => $this->l('1 Column')),
							array('id' => '2', 'name' => $this->l('2 Columns')),
							array('id' => '3', 'name' => $this->l('3 Columns')),
							array('id' => '4', 'name' => $this->l('4 Columns')),
							array('id' => '5', 'name' => $this->l('5 Columns')),
						),
						'id' => 'id',
						'name' => 'name'),
					'default' => 4,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Number Rows On Large Desktops.'),
					'name' => 'rows',
					'desc' => $this->l('The maximum row items  in tab.'),
					'default' => '1'
				),
				array(
					'type' => 'select',
					'label' => $this->l('Type'),
					'name' => 'type',
					'options' => array('query' => array(
							array('id' => 'grid', 'name' => $this->l('Grid')),
							array('id' => 'slider-nivo', 'name' => $this->l('Nivo Slider')),
							array('id' => 'slider-bt', 'name' => $this->l('Bootstrap Slider')),
						),
						'id' => 'id',
						'name' => 'name'),
					'default' => 'grid',
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Custom links'),
					'name' => 'links',
					'desc' => 'Enter links for each slide here. Divide links with linebreaks (Enter).',
					'rows' => '20'
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Enable Popup Image'),
					'desc' => $this->l('Show the original image on a modal box'),
					'name' => 'ispopup',
					'default' => 1,
					'values' => $soption,
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

		$string = '<fieldset class="panel">
				<h3>'.$this->l('Images Management').'</h3>
				<div class="alert aleart-info">
					
					<div id="imagelist'.$key.'">
						<button class="btn btn-info">'.$this->l('Add Images').'</button>
						<div class="images-content"></div>
					</div>
				</div>
				</fieldset>


				<script type="text/javascript">
					$(".imageupload").WPO_Gallery({gallery:true});
					$(document).ready(function() {
			           	$("#display_mode").on("change",function() {
			                if($(this).val() == "carousel") {
			                  $("#rows").parents(".form-group").css("display","block");
			                } else {
			                  $("#rows").parents(".form-group").css("display","none");
			                }
			            });
		            });
				</script>
			';
		return '<div id="imageslist'.$key.'">'.$helper->generateForm($this->fields_form).$string.'</div>';
	}

	public function renderContent($setting)
	{
		$t = array(
			'subtitle' => '',
			'name' => '',
			'imageslist' => '',
			'size' => '',
			'columns' => 4,
			'rows' => 1,
			'links' => '',
			'type' => 'grid',
			'images' => array(),
			'id' => time(),
			'class_widget' => 'gallery',
		);

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
		$url = Tools::htmlentitiesutf8($protocol.$_SERVER['HTTP_HOST'].__PS_BASE_URI__);
		$language_id = Context::getContext()->language->id;
		$setting['subtitle'] = isset($setting['subtitle_'.$language_id]) ? ($setting['subtitle_'.$language_id]) : ''; 

		$setting = array_merge($t, $setting);
		$size = explode('x', $setting['size']);

		$tmp = explode(',', $setting['imageslist']);

		$links = preg_split('#\s+#', trim($setting['links']));
		$output = array();

		foreach ($tmp as $key => $file)
		{
			$info = $this->renderImage($url, trim($file), $size);
			$info['link'] = isset($links[$key]) ? $links[$key] : '';
			$output[] = $info;
		}

		$setting['images'] = $output;

		$output = array('type' => 'gallery', 'data' => $setting);
		return $output;
	}

	protected function renderImage($url, $image, $size)
	{
		$setting = array();

		$setting['thumbnailurl'] = _PAGEBUILDER_IMAGE_URL_.$image;
		$setting['imageurl'] = _PAGEBUILDER_IMAGE_URL_.$image;
		if (count($size) == 2)
		{
			$cache = _PS_CACHE_DIR_.'pspagebuilder/';
			if (!file_exists($cache.$image))
			{
				if (!is_dir($cache))
					mkdir($cache, 0755);
				if (ImageManager::resize(_PAGEBUILDER_IMAGE_DIR_.$image, $cache.$image, $size[0], $size[1]))
					$setting['thumbnailurl'] = $url.'cache/pspagebuilder/'.$image;
			}
			else
				$setting['thumbnailurl'] = $url.'cache/pspagebuilder/'.$image;

		}
		return $setting;
	}

}
