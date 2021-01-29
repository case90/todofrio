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

class PsWidgetSocial extends PsWidgetPageBuilder {

	public $name = 'separator_text';

	public static function getWidgetInfo()
	{
		return array('label' => 'Social links', 'explain' => 'Get list of social icons', 'group' => 'social');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();

		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Separator Form.'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Facebook URL'),
					'name' => 'facebook_url',
					'desc' => $this->l('Your Facebook fan page.'),
					'default' => 'http://www.facebook.com/prestashop',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Twitter URL'),
					'name' => 'twitter_url',
					'desc' => $this->l('our official Twitter account.'),
					'default' => 'http://www.twitter.com/prestashop',
				),
				array(
					'type' => 'text',
					'label' => $this->l('RSS URL'),
					'name' => 'rss_url',
					'desc' => $this->l('The RSS feed of your choice (your blog, your store, etc.).'),
					'default' => 'http://www.prestashop.com/blog/en/feed/',
				),
				array(
					'type' => 'text',
					'label' => $this->l('YouTube URL '),
					'name' => 'youtube_url',
					'desc' => $this->l('Your official YouTube account.'),
					'default' => '',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Google+ URL'),
					'name' => 'google_plus_url',
					'desc' => $this->l('Your official Google+ page.'),
					'default' => '',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Pinterest URL'),
					'name' => 'pinterest_url',
					'desc' => $this->l('Your official Pinterest account.'),
					'default' => '',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Vimeo URL'),
					'name' => 'vimeo_url',
					'desc' => $this->l('Your official Vimeo account.'),
					'default' => '',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Instagram URL'),
					'name' => 'instagram_url',
					'desc' => $this->l('Your official Instagram account.'),
					'default' => '',
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
			'facebook_url' => 'http://www.facebook.com/prestashop',
			'twitter_url' => 'http://www.twitter.com/prestashop',
			'rss_url' => 'http://www.prestashop.com/blog/en/feed/',
			'youtube_url' => '',
			'google_plus_url' => '',
			'pinterest_url' => '',
			'vimeo_url' => '',
			'instagram_url' => ''
		);
		$setting = array_merge($t, $setting);
		$output = array('type' => 'social', 'data' => $setting);
		return $output;
	}

}
