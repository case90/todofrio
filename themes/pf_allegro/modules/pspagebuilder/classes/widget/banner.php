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

class PsWidgetBanner extends PsWidgetPageBuilder {

	public $name = 'banner';
	public $group = 'product';

	public static function getWidgetInfo()
	{
		return array('label' => ('Banner'), 'explain' => 'Display Banner', 'group' => 'prestabrain');
	}

	public function beforeAdminProcess($controller)
	{
		if (!Tools::getValue('widgetaction'))
			$controller->addJS(__PS_BASE_URI__.'modules/pspagebuilder/views/js/admin/image_gallery.js');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();
		$key = time();
		$types = array();
		$types[] = array(
			'value' => 'tab',
			'text' => $this->l('Tab')
		);
		$types[] = array(
			'value' => 'carousel',
			'text' => $this->l('Carousel')
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
					'type' => 'textarea',
					'label' => $this->l('Description'),
					'name' => 'description',
					'default' => '',
					'lang' => true,
					'autoload_rte' => true,
				),
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
					'label' => $this->l('Link'),
					'name' => 'link_url',
					'class' => 'link',
					'default' => '',
					'lang' => true
				),
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			)
		);

		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		$fields_value = $this->getConfigFieldsValues($data);

		$helper->tpl_vars = array(
			'fields_value' => $fields_value,
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
			'subtitle' => '',
			'description' => '',
			'imagefile' => '',
			'link_url' => '',
			'imageurl' => ''
		);

		$setting = array_merge($t, $setting);

		$language_id = Context::getContext()->language->id;
		$setting['subtitle'] = isset($setting['subtitle_'.$language_id]) ? ($setting['subtitle_'.$language_id]) : '';
		$setting['description'] = isset($setting['description_'.$language_id]) ? ($setting['description_'.$language_id]) : '';
		$setting['link_url'] = isset($setting['link_url_'.$language_id]) ? ($setting['link_url_'.$language_id]) : '';

		if ($setting['imagefile'])
			$setting['imageurl'] = _PAGEBUILDER_IMAGE_URL_.$setting['imagefile'];

		$output = array('type' => 'banner', 'data' => $setting);

		return $output;
	}

}
