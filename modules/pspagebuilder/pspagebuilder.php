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

if (!defined('_PS_VERSION_'))
	exit;

require_once(_PS_MODULE_DIR_.'pspagebuilder/loader.php');

class PsPageBuilder extends Module {

	/**
	 * @var String $_prefix
	 */
	private $prefix;
	private $fields_form = array();
	private $profile = null;
	private $theme_name = null;

	public function __construct()
	{
		$this->name = 'pspagebuilder';
		$this->tab = 'pricing_promotion';
		$this->version = '5.0.0';
		$this->author = 'PrestaBrain';
		$this->need_instance = 0;

		$this->bootstrap = true;
		parent::__construct();
		$this->prefix = 'pspagebuilder';

		$this->displayName = $this->l('Ps Page Builder');
		$this->description = $this->l('Lightweigh and flexiable to builder great home page having the best look.');
	}

	public function install()
	{
		$a = (parent::install() && $this->registerHook('home') && $this->registerHook('header') && $this->registerHook('categoryAddition')
						&& $this->registerHook('categoryUpdate')
						&& $this->registerHook('categoryDeletion')
						&& $this->registerHook('addproduct')
						&& $this->registerHook('updateproduct')
						&& $this->registerHook('deleteproduct')
						&& $this->registerHook('actionObjectLanguageAddAfter')
						);

		$this->clearBLHLCache();
		//$this->createTables();

		$this->installModuleTab('Page Builder Profiles', 'profile', 'AdminParentModules');
		$this->installModuleTab('Footer Builder Profiles', 'footer', 'AdminParentModules');
		$this->installModuleTab('Page Images Management', 'image', 'AdminParentModules');

		return $a;
	}

	/**
	 * Creates tables
	 */
	protected function createTables()
	{
		$res = 1;
		include_once(dirname(__FILE__).'/install/install.php');
		return $res;
	}

	/**
	 * Uninstall
	 */
	private function uninstallModuleTab($class_sfx = '')
	{
		$tab_class = 'Admin'.Tools::ucfirst($this->name).Tools::ucfirst($class_sfx);

		$id_tab = Tab::getIdFromClassName($tab_class);
		if ($id_tab != 0)
		{
			$tab = new Tab($id_tab);
			$tab->delete();
			return true;
		}
		return false;
	}

	/**
	 * Install Module Tabs
	 */
	private function installModuleTab($title, $class_sfx = '', $parent = '')
	{
		$class = 'Admin'.Tools::ucfirst($this->name).Tools::ucfirst($class_sfx);
		if ($parent == '')
			$position = Tab::getCurrentTabId();
		else
			$position = Tab::getIdFromClassName($parent);

		$tab = new Tab();
		$tab->class_name = $class;
		
		$tab->module = $this->name;
		$tab->id_parent = (int)$position;
		$langs = Language::getLanguages(false);
		foreach ($langs as $l)
			$tab->name[$l['id_lang']] = $title;
		return $tab->add(true, false);
	}

	public function uninstall()
	{
		$this->clearBLHLCache();

		$this->uninstallModuleTab('footer');
		$this->uninstallModuleTab('profile');
		$this->uninstallModuleTab('image');

		return parent::uninstall();
	}

	public function getContent()
	{
		$profile_id = PsPagebuilderprofile::getDefaultProfile();
		Tools::redirectAdmin('index.php?tab=AdminPspagebuilderProfile&id_pagebuilderprofile='.
						$profile_id.'&token='.Tools::getAdminTokenLite('AdminPspagebuilderProfile'));

		return '';
	}

	public function hookdisplayHeader()
	{
		$this->theme_name = Context::getContext()->shop->getTheme();
		$this->context->controller->addCSS($this->_path.'/views/css/pagebuilder.css', 'all');
		$this->context->controller->addCSS($this->_path.'/views/css/owl.carousel.css', 'all');

		$this->context->controller->addJS(($this->_path).'/views/js/owl.carousel.min.js', 'all');
		$this->context->controller->addJS(($this->_path).'/views/js/pagebuilder.js', 'all');
		$this->context->controller->addJS(($this->_path).'/views/js/countdown.js', 'all');
		
		if (isset($this->context->controller->php_self) && $this->context->controller->php_self == 'index'
						&& ($this->context->controller instanceof IndexController))
		{
			$this->context->smarty->assign(array(
				'PTS_PAGEBUILDER_ACTIVED' => true,
				'PTS_PAGEBUILDER_FULL' => true,
				'PTS_PAGEBUILDER_CONTENT' => $this->processHook()
			));
		}

		if ($this->getThemeConfig('enable_fbuilder'))
		{
			$this->context->smarty->assign(array(
				'PTS_FOOTERBUILDER_ACTIVED' => true,
				'PTS_FOOTERBUILDER_CONTENT' => $this->processHook(true)
			));
		}
	}

	public function hookDisplayHome()
	{
		return $this->processHook();
	}

	public function hookDisplaySlideshow()
	{
		return $this->processHook();
	}

	public function hookDisplayPromoteTop()
	{
		return $this->processHook();
	}

	public function hookDisplayBottom()
	{
		return $this->processHook();
	}

	public function hookDisplayContentBottom()
	{
		return $this->processHook();
	}

	public function hookActionObjectLanguageAddAfter($params)
	{
		$id_lang_default = Configuration::get('PS_LANG_DEFAULT');
		$id_lang_current = $params['object']->id;

		$obj = new PsPagebuilderprofile();
		$profiles = $obj->getList();
		$fprofiles = $obj->getListByFooter();

		$profiles = array_merge($profiles, $fprofiles);

		if ($profiles)
		{
			foreach ($profiles as &$profile)
			{
				$ws = unserialize(PsPagebuilderHelper::clearUnexpected(trim($profile['widget'])));
				if ($ws)
				{
					foreach ($ws as &$config)
					{
						$configs = unserialize(PsPagebuilderHelper::clearUnexpected(trim($config['config'])));
						if (isset($configs['widget']) && $configs['widget'])
						{
							foreach ($configs['widget'] as $k => $p)
							{
								$arrs = explode('_', $k);
								$end = end($arrs);
								array_pop($arrs);
								if ($end == $id_lang_default)
									$configs['widget'][implode('_', $arrs).'_'.$id_lang_current] = $p;
							}
						}
						$config['config'] = serialize($configs);
					}
					$profile['widget'] = serialize($ws);
				}
				// save data here
				$new_obj = new PsPagebuilderprofile($profile['id_pagebuilderprofile']);
				$new_obj->widget = $profile['widget'];
				$new_obj->update();
			}
		}
	}

	public function dupplicatForAllLanguages()
	{
		$id_lang_default = Configuration::get('PS_LANG_DEFAULT');
		$languages = Language::getLanguages(false);

		$obj = new PsPagebuilderprofile();
		$profiles = $obj->getList();
		$fprofiles = $obj->getListByFooter();

		$profiles = array_merge($profiles, $fprofiles);

		if ($profiles)
		{
			foreach ($profiles as &$profile)
			{
				$ws = unserialize(PsPagebuilderHelper::clearUnexpected(trim($profile['widget'])));
				if ($ws)
				{
					foreach ($ws as &$config)
					{
						$configs = unserialize(PsPagebuilderHelper::clearUnexpected(trim($config['config'])));
						if (isset($configs['widget']) && $configs['widget'])
						{
							foreach ($configs['widget'] as $k => $p)
							{
								$arrs = explode('_', $k);
								$end = end($arrs);
								array_pop($arrs);
								if ($end == $id_lang_default)
									foreach ($languages as $language)
										if ($language['id_lang'] != $id_lang_default)
											$configs['widget'][implode('_', $arrs).'_'.$language['id_lang']] = $p;
							}
						}
						$config['config'] = serialize($configs);
					}
					$profile['widget'] = serialize($ws);
				}
				// save data here
				$new_obj = new PsPagebuilderprofile($profile['id_pagebuilderprofile']);
				$new_obj->widget = $profile['widget'];
				$new_obj->update();
			}
		}
	}

	public function getThemeConfig($key, $value = '')
	{
		return Configuration::get('PTS_CP_'.Tools::strtoupper(trim($key)), $value);
	}

	public function getCustomConfig($name, $value)
	{
		$kc = $this->theme_name.'_'.$name;
		if (!Tools::getIsset('applyCustomSkinChanger') && !Tools::getIsset('resetDemoTheme') && $this->context->cookie->__isset($kc))
			return $this->context->cookie->__get($kc);
		else
		{
			if (Tools::getIsset('resetDemoTheme'))
				$cgtheme = Configuration::get('PTS_CP_THEME');
			else
				$cgtheme = Tools::getValue('themeskin') ? Tools::getValue('themeskin') : Configuration::get('PTS_CP_THEME');
			return $cgtheme;
		}
		return $value;
	}

	/**
	 *
	 */
	public function processHook($isfootter = false)
	{
		$cgtheme = _PS_MODE_DEMO_ ? $this->getCustomConfig('themeskin', $this->getThemeConfig('theme')) : $this->getThemeConfig('theme');
		if (Tools::isSubmit('applyCustomSkinChanger') || Tools::getIsset('themeskinactived'))
			$cgtheme = Tools::getValue('themeskin');

		$pbkey = $isfootter ? $this->getThemeConfig($cgtheme.'fbuilder') : $this->getThemeConfig($cgtheme.'pbuilder');

		if (!$this->isCached('pspagebuilder.tpl', $this->getCacheId(null, null, $pbkey)))
		{
			$id = $pbkey ? PsPagebuilderprofile::getIdByKey($pbkey) : PsPagebuilderprofile::getDefaultProfile();
			$profile = new PsPagebuilderprofile($id, $this->context->language->id);

			$layout = $profile->getLayout();

			if (!empty($layout))
			{
				$profile->loadWidgets();
				$ws = $profile->getWidgets();
				$layout = $this->buildLayoutData($layout, $ws, $profile, 1);
			}

			$dir = _PS_MODULE_DIR_.'pspagebuilder/views/templates/hook/builderlayout.tpl';
			$tdir = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/modules/pspagebuilder/views/templates/hook/builderlayout.tpl';
			if (file_exists($tdir))
				$dir = $tdir;

			$this->smarty->assign(array(
				'layout' => $layout,
				'layout_tpl' => $dir,
				'prefix' => $isfootter ? 'footerbuilder' : 'pagebuilder'
			));
		}
		return $this->display(__FILE__, 'pspagebuilder.tpl', $this->getCacheId(null, null, $pbkey));
	}

	public function buildLayoutData($rows, $ws, $profile, $rl = 1)
	{
		$layout = array();
		$mcrypt = new PtsMcrypt();
		foreach ($rows as $rkey => $row)
		{
			$row->level = $rl;
			$row = PsPagebuilderHelper::mergeRowData($row);

			foreach ($row->cols as $ckey => $col)
			{
				$col = PsPagebuilderHelper::mergeColData($col);
				foreach ($col->widgets as $wkey => $w)
				{
					$w->wkey = (string)$w->wkey;
					if ($w && isset($w->wkey) && isset($ws[$w->wkey]))
					{
						$content = trim($ws[$w->wkey]['config']);
						if ($content)
						{
							$widget = unserialize(PsPagebuilderHelper::clearUnexpected($content));
							if (isset($widget['widget']))
							{
								foreach ($widget['widget'] as $k => $v)
									$widget['widget'][$k] = $mcrypt->decode($v);

								if (isset($widget['widget']['wtype']))
								{
									$type = $widget['widget']['wtype'];
									$profile->loadWidgetObject($type, $this->context->controller);
									$tmp = $profile->getWidgetContent($type, $widget['widget']);
									if(isset($tmp['type']) && $tmp['data']) {
										$col->widgets[$wkey]->content = $this->getWidgetContent($w->wkey, $tmp['type'], $tmp['data']);
									}
								}
							}
						}
					}
				}
				if (isset($col->rows))
					$col->rows = $this->buildLayoutData($col->rows, $ws, $profile, $rl + 1);
				$row->cols[$ckey] = $col;
			}

			$layout[$rkey] = $row;
		}

		return $layout;
	}

	public function getWidgetContent($id, $type, $data)
	{
		$data['id_lang'] = $this->context->language->id;
		if ($data)
			foreach ($data as $key => $value)
				if (is_string($value) && $key != 'product_tpl' && $key != 'branche_tpl_path' && $key != 'THEME_SKIN_DIR')
					$data[$key] = Tools::stripslashes($value);

		$this->smarty->assign($data);
		$output = '<div class="pts-widget" id="wid-'.$id.'">';
		$output .= $this->display(__FILE__, 'views/templates/front/widgets/widget_'.$type.'.tpl');
		$output .= '</div>';

		return $output;
	}

	protected function getCacheId($name = null, $hook = '', $key = '')
	{
		$cache_array = array(
			$name !== null ? $name : $this->name,
			$hook,
			$key,
			date('Ymd'),
			(int)Tools::usingSecureMode(),
			(int)$this->context->shop->id,
			(int)Group::getCurrent()->id,
			(int)$this->context->language->id,
			(int)$this->context->currency->id,
			(int)$this->context->country->id
		);

		return implode('|', $cache_array);
	}

	public function clearBLHLCache()
	{
		$this->_clearCache('builderlayout.tpl');
		$this->_clearCache('pspagebuilder.tpl');
	}

	public function hookCategoryAddition()
	{
		$this->clearBLHLCache();
	}

	public function hookCategoryUpdate()
	{
		$this->clearBLHLCache();
	}

	public function hookCategoryDeletion()
	{
		$this->clearBLHLCache();
	}

	public function hookAddProduct()
	{
		$this->clearBLHLCache();
	}

	public function hookUpdateProduct()
	{
		$this->clearBLHLCache();
	}

	public function hookDeleteProduct()
	{
		$this->clearBLHLCache();
	}

}
