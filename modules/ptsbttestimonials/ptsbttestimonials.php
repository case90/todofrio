<?php
/**
 * Pts Prestashop Theme Framework for Prestashop 1.6.x
 *
 * @package   ptsbttestimonials
 * @version   1.0.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_'))
	exit;

include_once(_PS_MODULE_DIR_.'ptsbttestimonials/classes/PtsTestimonial.php');

class PtsBtTestimonials extends Module {

	private $_html;
	private $prefix;
	private $fields_form = array();

	public function __construct()
	{
		$this->name = 'ptsbttestimonials';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'PrestaBrain';
		$this->need_instance = 0;
		$this->secure_key = Tools::encrypt($this->name);

		$this->bootstrap = true;
		parent::__construct();
		$this->prefix = 'pts_test';

		$this->displayName = $this->l('Pts Bootstrap Testimonials');
		$this->description = $this->l('Testimonials module is created by PrestaBrain.');
	}

	public function install()
	{
		$this->clearCache();

		if (!parent::install() || !$this->registerHook('displayHome') || !$this->registerHook('header'))
			return false;
		// $res = $this->createTables();
		// if ($res)
		// 	$this->installSamples();
		$hookspos = array(
			'displayTop',
			'displayHeaderRight',
			'displaySlideshow',
			'topNavigation',
			'displayPromoteTop',
			'displayRightColumn',
			'displayLeftColumn',
			'displayHome',
			'displayFooter',
			'displayBottom',
			'displayContentBottom',
			'displayFootNav',
			'displayFooterTop',
			'displayFooterBottom'
		);

		foreach ($hookspos as $hook)
			if (!Hook::getIdByName($hook))
			{
				$new_hook = new Hook();
				$new_hook->name = pSQL($hook);
				$new_hook->title = pSQL($hook);
				$new_hook->add();
			}

		return true;
	}

	public function uninstall()
	{
		$uninstall = (parent::uninstall()
						&& $this->unregisterHook('displayHome')
						&& $this->deleteTables());

		$this->makeFormConfigs();
		$this->deleteConfigs();
		$this->clearCache();

		return $uninstall;
	}

	protected function createTables()
	{
		$res = Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ptsbttestimonials` (
			  	`id_ptsbttestimonials` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  	`avatar` varchar(255) DEFAULT NULL,
			  	`name` varchar(100) NOT NULL,
			    `email` varchar(100) NOT NULL,
			    `company` varchar(255) DEFAULT NULL,
			    `address` varchar(500) NOT NULL,
			    `media_id` varchar(20) DEFAULT NULL,
		        `media_type` varchar(20) DEFAULT NULL,
			    `media_code` varchar(100) DEFAULT NULL,
			    `date_add` datetime DEFAULT NULL,
			    `position` int(11) DEFAULT NULL,
			  	`active` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
			  	PRIMARY KEY (`id_ptsbttestimonials`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ptsbttestimonials_lang` (
			  	`id_ptsbttestimonials` int(10) unsigned NOT NULL,
				`id_lang` int(10) NOT NULL,
			    `content` text NOT NULL,
			    `note` text NOT NULL,
			  	PRIMARY KEY (`id_ptsbttestimonials`,`id_lang`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		$res &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'ptsbttestimonials_shop` (
			  	`id_ptsbttestimonials` int(10) unsigned NOT NULL,
				`id_shop` int(10) NOT NULL,
			  	PRIMARY KEY (`id_ptsbttestimonials`,`id_shop`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
		');

		return true;
	}

	private function installSamples()
	{
		for ($i = 1; $i <= 3; ++$i)
		{
			$tests = new PtsTestimonial();
			$tests->avatar = 'sample-'.$i.'.png';
			$tests->name = 'John doe '.$i;
			$tests->email = 'demo@gmail.com';
			$tests->company = 'Prestashop';
			$tests->address = 'Street name, California, USA';
			$tests->media_id = '9bdrk8FNWnc';
			$tests->media_type = 'Youtube';
			$tests->media_code = 'http://www.youtube.com/watch?v=9bdrk8FNWnc';
			$tests->position = $i;
			$tests->active = 1;
			foreach ($this->languages() as $lang)
			{
				$tests->content[$lang['id_lang']] = 'Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum,
					nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus  sit amet mauris. Morbi accumsan ipsum velit. '.$i;
				$tests->note[$lang['id_lang']] = 'Duis sed odio '.$i;
			}
			$tests->add();
		}
	}

	protected function deleteTables()
	{
		$pts_test = $this->getTestimonials();
		foreach ($pts_test as $test)
		{
			$to_del = new PtsTestimonial($test['id_test']);
			$to_del->delete();
		}
		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `'._DB_PREFIX_.$this->name.'`, `'._DB_PREFIX_.$this->name.'_lang`, `'._DB_PREFIX_.$this->name.'_shop`;
		');
	}

	public function getTestimonials($active = null, $n = false)
	{
		$this->context = Context::getContext();
		$id_shop = $this->context->shop->id;
		$id_lang = $this->context->language->id;

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT pts.`id_ptsbttestimonials` AS id_test,
				   pt.`name`, pt.`email`, pt.`company`,
				   pt.`address`, pt.`media_id`,
				   pt.`media_type`, pt.`media_code`,
				   pt.`date_add`, pt.`position`,
				   pt.`active`, ptl.`content`,
				   ptl.`note`, pt.`avatar`
			FROM '._DB_PREFIX_.'ptsbttestimonials_shop pts
			LEFT JOIN '._DB_PREFIX_.'ptsbttestimonials pt ON (pts.id_ptsbttestimonials = pt.id_ptsbttestimonials)
			LEFT JOIN '._DB_PREFIX_.'ptsbttestimonials_lang ptl ON (pt.id_ptsbttestimonials = ptl.id_ptsbttestimonials)
			WHERE (pts.`id_shop` = '.(int)$id_shop.')
			AND ptl.`id_lang` = '.(int)$id_lang.
										($active ? ' AND pt.`active` = 1' : ' ').'
			ORDER BY pt.position'.($n ? ' LIMIT 0,'.(int)$n : '')
		);
	}

	public function testimonialExists($id_test)
	{
		$req = 'SELECT pts.`id_ptsbttestimonials` as id_test
				FROM `'._DB_PREFIX_.'ptsbttestimonials_shop` pts
				WHERE pts.`id_ptsbttestimonials` = '.(int)$id_test;
		$row = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($req);

		return ($row);
	}

	public function displayStatus($id_test, $active)
	{
		$title = ((int)$active == 0 ? $this->l('Disabled') : $this->l('Enabled'));
		$img = ((int)$active == 0 ? 'disabled.gif' : 'enabled.gif');
		$html = '<a href="'.AdminController::$currentIndex.'&configure='.$this->name.'
				&token='.Tools::getAdminTokenLite('AdminModules').'
				&changeStatus&id_test='.(int)$id_test.'" title="'.$title.'"><img src="'._PS_ADMIN_IMG_.''.$img.'" alt="" /></a>';

		return $html;
	}

	public function headerHTML()
	{
		if (Tools::getValue('controller') != 'AdminModules' && Tools::getValue('configure') != $this->name)
			return;

		$this->context->controller->addJqueryUI('ui.sortable');
		/* Style & js for fieldset 'tests configuration' */
		$html = '
		<style>
		#tests li {
			list-style: none;
			margin: 0 0 4px 0;
			padding: 10px;
			background-color: #F4E6C9;
			border: #CCCCCC solid 1px;
			color:#000;
		}
		</style>
		
		<script type="text/javascript">
			$(function() {
				var $myTests = $("#tests");
				$myTests.sortable({
					opacity: 0.6,
					cursor: "move",
					update: function() {
						var order = $(this).sortable("serialize") + "&action=updateTestimonialPosition";
						$.post("'.$this->context->shop->physical_uri.$this->context->shop->virtual_uri.'
							modules/'.$this->name.'/ajax_'.$this->name.'.php?secure_key='.$this->secure_key.'", order);
						}
					});
				$myTests.hover(function() {
					$(this).css("cursor","move");
					},
					function() {
					$(this).css("cursor","auto");
				});
			});
		</script>';

		return $html;
	}

	public function getContent()
	{
		$this->_html .= $this->headerHTML();
		$this->_html .= '<h2>'.$this->displayName.'</h2>';

		if (Tools::isSubmit('submitPtsBtTestimonials') || Tools::isSubmit('submitTestimonial')
				|| Tools::isSubmit('delete_id_test') || Tools::isSubmit('changeStatus'))
		{
			if ($this->postValidation())
			{
				$this->postProcess();
				$this->_html .= $this->renderForm();
				$this->_html .= $this->renderList();
			}
			else
				$this->_html .= $this->renderAddForm();
		}
		elseif (Tools::isSubmit('addTest') || (Tools::isSubmit('id_test') && $this->testimonialExists((int)Tools::getValue('id_test'))))
			$this->_html .= $this->renderAddForm();
		else
		{
			$this->_html .= $this->renderForm();
			$this->_html .= $this->renderList();
		}

		return $this->_html;
	}

	public function postValidation()
	{
		$errors = array();

		if (Tools::isSubmit('submitPtsBtTestimonials'))
		{
			if (!Validate::isInt(Tools::getValue($this->renderName('limit')))
				|| !Validate::isInt(Tools::getValue($this->renderName('width')))
				|| !Validate::isInt(Tools::getValue($this->renderName('height')))
				|| !Validate::isInt(Tools::getValue($this->renderName('speed'))))
				$errors[] = $this->l('Invalid values! check values to input again.');
		}
		elseif (Tools::isSubmit('changeStatus'))
		{
			if (!Validate::isInt(Tools::getValue('id_test')))
				$errors[] = $this->l('Invalid Testimonial');
		}
		elseif (Tools::isSubmit('submitTestimonial'))
		{
			if (Tools::getValue('image') != null && !Validate::isFileName(Tools::getValue('image')))
				$errors[] = $this->l('Invalid filename.');
			if (Tools::getValue('image_old') != null && !Validate::isFileName(Tools::getValue('image_old')))
				$errors[] = $this->l('Invalid filename.');
			if (!Validate::isGenericName(Tools::getValue('name')))
				$errors[] = $this->l('The name is empty or incorrect data input.');
			elseif (Tools::strlen(Tools::getValue('name') > 100))
				$errors[] = $this->l('The name is too long.');
			if (!Validate::isEmail(Tools::getValue('email')))
				$errors[] = $this->l('The email is empty or incorrect data input.');
			elseif (Tools::strlen(Tools::getValue('email') > 100))
				$errors[] = $this->l('The email is too long.');
			if (!Validate::isGenericName(Tools::getValue('address')))
				$errors[] = $this->l('The address is empty or incorrect data input.');
			elseif (Tools::strlen(Tools::getValue('address') > 500))
				$errors[] = $this->l('The address is too long.');
			if (!Validate::isInt(Tools::getValue('active_test')) || (Tools::getValue('active_test') != 0 && Tools::getValue('active_test') != 1))
				$errors[] = $this->l('Invalid testimonial state.');
			if (Tools::isSubmit('id_test'))
				if (!Validate::isInt(Tools::getValue('id_test')) && !$this->testimonialExists(Tools::getValue('id_test')))
					$errors[] = $this->l('Invalid Id_testimonial');
			foreach ($this->languages() as $language)
			{
				if (Tools::strlen(Tools::getValue('content_'.$language['id_lang'])) > 6000)
					$errors[] = $this->l('The content is too long.');
				if (Tools::strlen(Tools::getValue('note_'.$language['id_lang'])) > 500)
					$errors[] = $this->l('The note is too long.');
			}
		}
		elseif (Tools::isSubmit('delete_id_test') && (!Validate::isInt(Tools::getValue('delete_id_test'))
					|| !$this->testimonialExists((int)Tools::getValue('delete_id_test'))))
			$errors[] = $this->l('Invalid Id_testimonial');

		/* Display errors if needs */
		if (count($errors))
		{
			$this->_html .= $this->displayError(implode('<br />', $errors));
			return false;
		}

		return true;
	}

	public function postProcess()
	{
		$errors = array();
		if (Tools::isSubmit('submitPtsBtTestimonials'))
		{
			$this->makeFormConfigs();
			$res = $this->batchUpdateConfigs();
			$this->clearCache();
			if ($res)
				$this->_html .= $this->displayConfirmation($this->l('Configuration updated successfully.'));
			else
				$errors[] = $this->displayError($this->l('The configuration could not be updated.'));
		}
		elseif (Tools::isSubmit('changeStatus') && Tools::isSubmit('id_test'))
		{
			$test = new PtsTestimonial((int)Tools::getValue('id_test'));
			if ($test->active == 0)
				$test->active = 1;
			else
				$test->active = 0;
			$res = $test->update();
			$this->clearCache();
			$this->_html .= ($res ? $this->displayConfirmation($this->l('Configuration updated successfully'))
							: $this->displayError($this->l('The configuration could not be updated.')));
		}
		elseif (Tools::isSubmit('submitTestimonial'))
		{
			if (Tools::getValue('id_test'))
			{
				$test = new PtsTestimonial((int)Tools::getValue('id_test'));
				if (!Validate::isLoadedObject($test))
				{
					$this->_html .= $this->displayError($this->l('Invalid Id_testimonial'));
					return false;
				}
			}
			else
				$test = new PtsTestimonial();

			$type = Tools::strtolower(Tools::substr(strrchr($_FILES['image']['name'], '.'), 1));
			$imagesize = getimagesize($_FILES['image']['tmp_name']);
			if (isset($_FILES['image']) && isset($_FILES['image']['tmp_name'])
					&& !empty($_FILES['image']['tmp_name']) && !empty($imagesize)
					&& in_array(Tools::strtolower(Tools::substr(strrchr($imagesize['mime'], '/'), 1)), array('jpg', 'gif', 'jpeg', 'png'))
					&& in_array($type, array('jpg', 'gif', 'jpeg', 'png')))
			{
				$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');
				$salt = sha1(microtime());

				if ($error = ImageManager::validateUpload($_FILES['image']))
					$errors[] = $error;
				elseif (!$temp_name || !move_uploaded_file($_FILES['image']['tmp_name'], $temp_name))
					return false;
				elseif (!ImageManager::resize($temp_name, dirname(__FILE__).'/views/img/'.Tools::encrypt($_FILES['image']['name'].$salt).'.'.$type, null, null, $type))
					$errors[] = $this->displayError($this->l('An error occurred during the image upload process.'));

				if (isset($temp_name))
					unlink($temp_name);
				$test->avatar = Tools::encrypt($_FILES['image']['name'].$salt).'.'.$type;
			}
			elseif (Tools::getValue('image_old') != '')
				$test->avatar = Tools::getValue('image_old');

			$test->name = Tools::getValue('name');
			$test->email = Tools::getValue('email');
			$test->company = Tools::getValue('company');
			$test->address = Tools::getValue('address');

			$url = Tools::getValue('url');
			if (isset($url))
			{
				$values = $this->getMediaLinkIdAndType($url);
				$test->media_id = $values['id_link'];
				$test->media_type = $values['type'];
				$test->media_code = $url;
			}

			$id_test = Tools::getValue('id_test');
			if (!empty($id_test))
				$test->position = $this->getOldPosition($id_test);
			else
				$test->position = $this->handlePosition();

			$test->active = (int)Tools::getValue('active_test');

			foreach ($this->languages() as $lang)
			{
				$test->content[$lang['id_lang']] = Tools::getValue('content_'.$lang['id_lang']);
				$test->note[$lang['id_lang']] = Tools::getValue('note_'.$lang['id_lang']);
			}

			/* Processes if no errors  */
			if (!$errors)
			{
				/* Adds */
				if (!Tools::getValue('id_test'))
				{
					if (!$test->add())
						$errors[] = $this->displayError($this->l('The Testimonial could not be added.'));
				}
				elseif (!$test->update())
					$errors[] = $this->displayError($this->l('The Testimonial could not be updated.'));
				$this->clearCache();
			}
		}
		elseif (Tools::isSubmit('delete_id_test'))
		{
			$test = new PtsTestimonial((int)Tools::getValue('delete_id_test'));
			$res = $test->delete();
			$this->clearCache();
			if (!$res)
				$this->_html .= $this->displayError('Could not delete.');
			else
			{
				$admin_url = $this->context->link->getAdminLink('AdminModules', true);
				$admin_url .= '&conf=1&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
				Tools::redirectAdmin($admin_url);
			}
		}
		if (count($errors))
			$this->_html .= $this->displayError(implode('<br />', $errors));
		elseif (Tools::isSubmit('submitTestimonial') && Tools::getValue('id_test'))
		{
			$admin_url = $this->context->link->getAdminLink('AdminModules', true);
			$admin_url .= '&conf=4&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
			Tools::redirectAdmin($admin_url);
		}
		elseif (Tools::isSubmit('submitTestimonial'))
		{
			$admin_url = $this->context->link->getAdminLink('AdminModules', true);
			$admin_url .= '&conf=3&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
			Tools::redirectAdmin($admin_url);
		}
	}

	protected function getMediaLinkIdAndType($link)
	{
		$default_link_check = array(
			'youtube' => 'www.youtube.com',
			'vimeo' => 'vimeo.com'
		);

		$ex_link = explode('/', $link);
		$cmp_youtube_link = strcmp($ex_link[2], $default_link_check['youtube']);
		$cmp_vimeo_link = strcmp($ex_link[2], $default_link_check['vimeo']);

		if ($cmp_youtube_link == 0 && ! empty($ex_link[3]))
		{
			$youtube_id = explode('=', $ex_link[3]);
			return array('id_link' => end($youtube_id), 'type' => 'Youtube');
		}
		elseif ($cmp_vimeo_link == 0 && ! empty($ex_link[3]))
			return array('id_link' => end($ex_link), 'type' => 'Vimeo');
		else
			return;
	}

	protected function handlePosition()
	{
		$sql = ' SELECT MAX(pt.`position`) AS max_position ';
		$sql .= ' FROM '._DB_PREFIX_.'ptsbttestimonials pt ';
		$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		foreach ($res as $max_position)
			$max_pos = $max_position['max_position'];

		if ((int)$max_pos)
			return ++$max_pos;
		else
			return 1;
	}

	protected function getOldPosition($id_test)
	{
		$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
		 	SELECT pt.position FROM '._DB_PREFIX_.'ptsbttestimonials pt
		 	WHERE pt.id_ptsbttestimonials ='.(int)$id_test);
		foreach ($res as $old_position)
			$old_pos = $old_position['position'];
		return $old_pos;
	}

	public function renderAddForm()
	{
		if (Tools::isSubmit('id_test') && $this->testimonialExists((int)Tools::getValue('id_test')))
			$test = new PtsTestimonial((int)Tools::getValue('id_test'));
		else
			$test = new PtsTestimonial();

		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Testimonials informations'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'file',
						'label' => $this->l('Avatar'),
						'name' => 'image',
						'thumb' => ($test->avatar) ? __PS_BASE_URI__.'modules/'.$this->name.'/views/img/'.$test->avatar : '',
						'desc' => $this->l('should to upload the image below or equal to 135x135 px.'),
					),
					array(
						'type' => 'text',
						'label' => $this->l('Name'),
						'name' => 'name',
						'desc' => 'Not empty!',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Email'),
						'name' => 'email',
						'desc' => 'Email should to input correctly format.',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Company'),
						'name' => 'company',
						'desc' => "your company's name",
					),
					array(
						'type' => 'text',
						'label' => $this->l('Address'),
						'name' => 'address',
						'desc' => 'Not empty!',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Url'),
						'name' => 'url',
						'desc' => $this->l('Url only allow to input Youtube and Vimeo link and must to input full Url (ex: http://www.youtube.com/watch?v=...)'),
					),
					array(
						'type' => 'switch',
						'label' => $this->l('Active'),
						'name' => 'active_test',
						'is_bool' => true,
						'desc' => '',
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => 1,
								'label' => $this->l('Yes')
							),
							array(
								'id' => 'active_off',
								'value' => 0,
								'label' => $this->l('No')
							)
						),
					),
					array(
						'type' => 'textarea',
						'label' => $this->l('Content'),
						'name' => 'content',
						'autoload_rte' => true,
						'desc' => '',
						'lang' => true,
					),
					array(
						'type' => 'textarea',
						'label' => $this->l('Note'),
						'name' => 'note',
						'autoload_rte' => true,
						'desc' => '',
						'lang' => true,
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
					'class' => 'btn btn-default'
				)
			)
		);

		if (Tools::isSubmit('id_test') && $this->testimonialExists((int)Tools::getValue('id_test')))
		{
			$test = new PtsTestimonial((int)Tools::getValue('id_test'));
			$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'id_test');

			$has_picture = true;

			if (!isset($test->avatar))
				$has_picture &= false;

			if ($has_picture)
				$fields_form['form']['input'][] = array('type' => 'hidden', 'name' => 'has_picture');
		}

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();
		$helper->module = $this;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitTestimonial';
		$current_index = $this->context->link->getAdminLink('AdminModules', false);
		$current_index .= '&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->currentIndex = $current_index;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->tpl_vars = array(
			'base_url' => $this->context->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $this->getAddFieldsValues($test),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		$helper->override_folder = '/';

		return $helper->generateForm(array($fields_form));
	}

	public function getAddFieldsValues($test)
	{
		$fields = array();

		$fields['id_test'] = (int)Tools::getValue('id_test', $test->id);
		$fields['name'] = Tools::getValue('name', $test->name);
		$fields['email'] = Tools::getValue('email', $test->email);
		$fields['company'] = Tools::getValue('company', $test->company);
		$fields['address'] = Tools::getValue('address', $test->address);
		$fields['url'] = Tools::getValue('url', $test->media_code);
		$fields['media_code'] = Tools::getValue('media_code', $test->media_code);
		$fields['active_test'] = Tools::getValue('active_test', $test->active);
		$fields['has_picture'] = true;
		$fields['image'] = Tools::getValue('image', $test->avatar);

		foreach ($this->languages() as $lang)
		{
			$fields['content'][$lang['id_lang']] = Tools::getValue('content_'.(int)$lang['id_lang'], $test->content[$lang['id_lang']]);
			$fields['note'][$lang['id_lang']] = Tools::getValue('note_'.(int)$lang['id_lang'], $test->note[$lang['id_lang']]);
		}

		return $fields;
	}

	public function makeFormConfigs()
	{
		if ($this->fields_form)
			return;

		$fields = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Testimonials limit:'),
						'name' => $this->renderName('limit'),
						'suffix' => 'integer',
						'desc' => $this->l('The maximum number of Testimonials displayed (default: 5)'),
						'default' => '5',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Testimonials width:'),
						'name' => $this->renderName('width'),
						'suffix' => 'px',
						'desc' => $this->l('Testimonials width display to Front-End (default: 450)'),
						'default' => '450',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Testimonials height:'),
						'name' => $this->renderName('height'),
						'suffix' => 'px',
						'desc' => $this->l('Testimonials height display to Front-End (default: 250)'),
						'default' => '250',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Image and Media width:'),
						'name' => $this->renderName('media_width'),
						'suffix' => 'px',
						'desc' => $this->l('showed to Front-End (default: 180)'),
						'default' => '180',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Image and Media height:'),
						'name' => $this->renderName('media_height'),
						'suffix' => 'px',
						'desc' => $this->l('showed to Front-End(default: 100)'),
						'default' => '100',
					),
					array(
						'type' => 'text',
						'label' => $this->l('Delay:'),
						'name' => $this->renderName('speed'),
						'suffix' => 'ms',
						'desc' => $this->l('Put it is 0, if you want to disable autoplay.'),
						'default' => '3000'
					)
				),
				'submit' => array(
					'title' => $this->l('Save'),
					'class' => 'btn btn-default'
				)
			),
		);
		$this->fields_form[] = $fields;
	}

	public function renderForm()
	{
		$this->makeFormConfigs();

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitPtsBtTestimonials';
		$current_index = $this->context->link->getAdminLink('AdminModules', false);
		$current_index .= '&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->currentIndex = $current_index;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(($this->fields_form));
	}

	public function getConfigFieldsValues()
	{
		$fields_values = array();

		foreach ($this->fields_form as $f)
			foreach ($f['form']['input'] as $input)
				if (isset($input['lang']))
				{
					foreach ($this->languages() as $lang)
					{
						$values = Tools::getValue($input['name'].'_'.$lang['id_lang'], Configuration::get($input['name'], $lang['id_lang']));
						$fields_values[$input['name']][$lang['id_lang']] = $values ? $values : $input['default'];
					}
				}
				else
				{
					$values = Tools::getValue($input['name'], Configuration::get($input['name']));
					$fields_values[$input['name']] = $values ? $values : $input['default'];
				}

		return $fields_values;
	}

	public function batchUpdateConfigs()
	{
		foreach ($this->fields_form as $f)
			foreach ($f['form']['input'] as $input)
				if (isset($input['lang']))
				{
					$data = array();
					foreach ($this->languages() as $lang)
					{
						$val = Tools::getValue($input['name'].'_'.$lang['id_lang'], Configuration::get($input['name']).'_'.$lang['id_lang']);
						$data[$lang['id_lang']] = $val ? $val : $input['default'];
					}
					Configuration::updateValue(trim($input['name']), $data);
				}
				else
				{
					$val = Tools::getValue($input['name'], Configuration::get($input['name']));
					Configuration::updateValue($input['name'], $val ? $val : $input['default'] );
				}
		return true;
	}

	public function deleteConfigs()
	{
		foreach ($this->fields_form as $f)
			foreach ($f['form']['input'] as $input)
				if (isset($input['lang']))
					foreach ($this->languages() as $lang)
						Configuration::deleteByName($input['name'].'_'.$lang['id_lang']);
				else
					Configuration::deleteByName($input['name']);
	}

	public function getConfigValue($key, $value = null)
	{
		return (Configuration::hasKey($this->renderName($key)) ? Configuration::get($this->renderName($key)) : $value);
	}

	public function renderName($name)
	{
		return Tools::strtoupper($this->prefix.'_'.$name);
	}

	public function languages()
	{
		return Language::getLanguages(false);
	}

	public function renderList()
	{
		$tests = $this->getTestimonials();
		foreach ($tests as $key => $test)
			$tests[$key]['status'] = $this->displayStatus($test['id_test'], $test['active']);

		$this->context->smarty->assign(array(
			'link' => $this->context->link,
			'tests' => $tests,
		));

		return $this->display(__FILE__, 'list.tpl');
	}

	private function prepareHook()
	{
		if (!$this->isCached('ptsbttestimonials.tpl', $this->getCacheId()))
		{
			$config = array(
				'test_limit' => $this->getConfigValue('limit', 5),
				'test_width' => $this->getConfigValue('width', 450),
				'test_height' => $this->getConfigValue('height', 250),
				'media_width' => $this->getConfigValue('media_width', 180),
				'media_height' => $this->getConfigValue('media_height', 100),
				'speed' => $this->getConfigValue('speed', 3000),
				'img_link' => _MODULE_DIR_.$this->name.'/views/img/',
			);
			$testimonials = $this->getTestimonials(true);
			if (!$testimonials)
				return false;

			$this->smarty->assign('config_testimonials', $config);
			$this->smarty->assign('get_testimonials', $testimonials);
			$this->smarty->assign('ptsbttestimonials_modid', $this->id);
		}

		return true;
	}

	public function hookdisplayHome()
	{
		if (!$this->prepareHook())
			return;

		$this->context->controller->addJqueryPlugin('fancybox');
		$this->context->controller->addJS(($this->_path).'views/js/jquery.fancybox-media.js', 'all');

		return $this->display(__FILE__, 'ptsbttestimonials.tpl', $this->getCacheId());
	}

	public function hookHeader()
	{
		$this->context->controller->addCSS(($this->_path).'views/css/ptsbttestimonials.css', 'all');
	}

	public function hookdisplayBottom()
	{
		return $this->hookdisplayHome();
	}

	public function hookDisplayFooterTop()
	{
		return $this->hookdisplayHome();
	}

	public function getCacheId($name = null)
	{
		if ($name === null && isset($this->context->smarty->tpl_vars['page_name']))
			return parent::getCacheId($this->context->smarty->tpl_vars['page_name']->value);
		return parent::getCacheId($name);
	}

	public function clearCache()
	{
		$this->_clearCache('ptsbttestimonials.tpl');
	}

}
