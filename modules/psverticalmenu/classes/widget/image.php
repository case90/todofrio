<?php
/**
 * Pts Prestashop Theme Framework for Prestashop 1.6.x
 *
 * @package   psverticalmenu
 * @version   1.4
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

class PsVerticalMenuWidgetImage extends PsVerticalMenuWidgetBase {

	public $name = 'image';

	public function getWidgetInfo()
	{
		return array('label' => $this->l('Images Gallery'), 'explain' => 'Create Images Mini Gallery From Folder');
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
					'label' => $this->l('Image Folder Path'),
					'name' => 'image_folder_path',
					'default' => '',
					'desc' => 'Put image folder in the image folder ROOT_SHOP_DIR/img/'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Limit'),
					'name' => 'limit',
					'default' => '12',
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
					'default' => '4',
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
			'image_folder_path' => '',
			'limit' => 12,
			'columns' => 4,
		);

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
		$url = Tools::htmlentitiesutf8($protocol.$_SERVER['HTTP_HOST'].__PS_BASE_URI__);

		$setting = array_merge($t, $setting);
		$oimages = array();
		if ($setting['image_folder_path'])
		{
			$path = _PS_ROOT_DIR_.'/img/'.trim($setting['image_folder_path']).'/';
			$path = str_replace('//', '/', $path);
			if (is_dir($path))
			{
				$images = glob($path.'*.*');
				$exts = array('jpg', 'gif', 'png');

				foreach ($images as $cnt => $image)
				{
					$ext = Tools::substr($image, Tools::strlen($image) - 3, Tools::strlen($image));
					if (in_array(Tools::strtolower($ext), $exts))
					{
						if ($cnt < (int)$setting['limit'])
						{
							$i = str_replace('\\', '/', '/img/'.$setting['image_folder_path'].'/'.basename($image));
							$i = str_replace('//', '/', $i);
							$oimages[] = $url.$i;
						}
					}
				}
			}
		}

		$images = array();
		$setting['images'] = $oimages;
		$output = array('type' => 'image', 'data' => $setting);
		return $output;
	}

}
