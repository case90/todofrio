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

if (!class_exists('PsPagebuilderprofile'))
{
	class PsPagebuilderprofile extends ObjectModel {

		protected $widgets = array();
		public $name;
		public $widget;
		public $layout;
		public $id;
		public $id_pagebuilderprofile;
		public $isdelete = 0;
		public $engines = array();
		public $lang_id = 0;
		public $is_footer = 0;
		public $isdefault = 0;
		public $key = 0;
		public $mod_name = 'pspagebuilder';
		public static $definition = array(
			'table' => 'pagebuilderprofile',
			'primary' => 'id_pagebuilderprofile',
			'fields' => array(
				'name' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'size' => 255),
				'layout' => array('type' => self::TYPE_HTML, 'validate' => 'isString'),
				'widget' => array('type' => self::TYPE_HTML, 'validate' => 'isString'),
				'isdelete' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'isdefault' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'key' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
				'is_footer' => array('type' => self::TYPE_INT, 'validate' => 'isInt')
			)
		);

		public function __construct($id_pagebuilderprofile = null, $id_lang = null, $id_shop = null)
		{
			$this->lang_id = $id_lang;
			$id_lang = null;

			parent::__construct($id_pagebuilderprofile, $id_lang, $id_shop);
		}

		public function add($autodate = true, $null_values = false)
		{
			$context = Context::getContext();
			$id_shop = $context->shop->id;
			$this->key = time();
			$res = parent::add($autodate, $null_values);
			$res &= Db::getInstance()->execute('
				INSERT INTO `'._DB_PREFIX_.'pagebuilderprofile_shop` (`id_shop`, `id_pagebuilderprofile`, `default`)
				VALUES('.(int)$id_shop.', '.(int)$this->id.', 0)'
			);
			return $res;
		}

		public function update($null_values = false)
		{
			$context = Context::getContext();
			$id_shop = $context->shop->id;
			$res = parent::update($null_values);
			$res &= Db::getInstance()->execute('
				REPLACE INTO `'._DB_PREFIX_.'pagebuilderprofile_shop` (`id_shop`, `id_pagebuilderprofile`,`default`)
				VALUES('.(int)$id_shop.', '.(int)$this->id.','.($this->isDefault() ? 1 : 0).')'
			);
			return $res;
		}

		public function delete()
		{
			$res = true;
			$all_shop = false;
			$list_shop = $this->getListShop();
			if ($all_shop || count($list_shop) <= 1)
			{
				$res &= Db::getInstance()->execute('
                    DELETE FROM `'._DB_PREFIX_.'pagebuilderprofile_shop`
                    WHERE `id_pagebuilderprofile` = '.(int)$this->id
				);

				$res &= parent::delete();
			}
			else
				$res &= $this->deleteShop();

			return $res;
		}

		public function deleteShop()
		{
			$context = Context::getContext();
			$id_shop = $context->shop->id;
			$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->execute('
				DELETE FROM '._DB_PREFIX_.'pagebuilderprofile_shop 
				WHERE id_pagebuilderprofile = '.(int)$this->id.' AND id_shop = '.(int)$id_shop
			);
			return $res;
		}

		public function getListShop()
		{
			$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
				SELECT  * 
				FROM '._DB_PREFIX_.'pagebuilderprofile_shop 
				WHERE id_pagebuilderprofile = '.(int)$this->id
			);
			return $res;
		}

		public function checkProfileInShop()
		{
			$context = Context::getContext();
			$id_shop = $context->shop->id;
			return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
				SELECT *
				FROM '._DB_PREFIX_.'pagebuilderprofile_shop 
				WHERE id_shop = '.(int)$id_shop.' AND id_pagebuilderprofile = '.(int)$this->id);
		}

		public function isDefault()
		{
			return $this->isdefault;
		}

		public function setDefault()
		{
			Db::getInstance()->execute('
                UPDATE   `'._DB_PREFIX_.'pagebuilderprofile`
                SET `isdefault`=0 WHERE `isdefault`=1 AND is_footer='.(bool)$this->is_footer);

			Db::getInstance()->execute('
                UPDATE   `'._DB_PREFIX_.'pagebuilderprofile`
                SET `isdefault`=1 WHERE id_pagebuilderprofile = '.(int)$this->id.' AND is_footer='.(bool)$this->is_footer);
		}

		public static function getIdByKey($key)
		{
			$query = new DbQuery();
			$query->select('b.id_pagebuilderprofile');
			$query->from('pagebuilderprofile', 'b');
			$query->where('`key`= \''.pSQL($key).'\'');

			$data = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query);

			return (int)$data;
		}

		public function getList()
		{
			$context = Context::getContext();
			$id_shop = $context->shop->id;

			return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
				SELECT  *, ps.default 
				FROM '._DB_PREFIX_.'pagebuilderprofile  p
				LEFT JOIN '._DB_PREFIX_.'pagebuilderprofile_shop ps ON (p.id_pagebuilderprofile = ps.id_pagebuilderprofile)
				WHERE id_shop = '.(int)$id_shop.' and is_footer !=1 
			');
		}

		public function getListByFooter()
		{
			$context = Context::getContext();
			$id_shop = $context->shop->id;

			return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
				SELECT  *, ps.default 
				FROM '._DB_PREFIX_.'pagebuilderprofile  p
				LEFT JOIN '._DB_PREFIX_.'pagebuilderprofile_shop ps ON (p.id_pagebuilderprofile = ps.id_pagebuilderprofile)
				WHERE id_shop = '.(int)$id_shop.' AND is_footer=1
			');
		}

		public static function getDefaultProfile($is_footer = false)
		{
			$context = Context::getContext();
			$id_shop = $context->shop->id;

			$query = new DbQuery();
			$query->select('b.id_pagebuilderprofile');
			$query->from('pagebuilderprofile', 'b');
			$query->leftJoin('pagebuilderprofile_shop', 'bs', 'b.`id_pagebuilderprofile` = bs.`id_pagebuilderprofile`');
			$query->where('bs.`default`=1 AND bs.`id_shop` = '.(int)$id_shop.' AND is_footer='.($is_footer ? 1 : 0));

			return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query);
		}

		public function getButtons()
		{
			$output = array();

			foreach ($this->widgets as $w)
			{
				$class = 'PsWidget'.Tools::ucfirst($w);

				if (class_exists($class))
				{
					$cb_args = array();
					$info = call_user_func_array(array($class, 'getWidgetInfo'), $cb_args);
					$group = isset($info['group']) ? $info['group'] : ('others');
					$button = '
						<div id="wpo_'.$w.'" data-widget="'.$w.'"  >
							<div class="wpo-wicon wpo-icon-'.$w.'"></div>
							<div class="widget-title"> '.$this->l($info['label']).' </div>
							 <i class="widget-desc">'.$this->l($info['explain']).'</i>
						</div>
					';

					$output['widgets'][$w] = array('type' => $w, 'button' => $button, 'group' => $group);
					$output['groups'][$group]['group'] = $this->l(Tools::ucfirst($group));
					$output['groups'][$group]['key'] = $group;
				}
			}

			return $output;
		}

		public function getDefault()
		{
			$context = Context::getContext();
			$id_shop = $context->shop->id;

			Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
				SELECT  * 
				FROM '._DB_PREFIX_.'pagebuilderprofile  p
				LEFT JOIN '._DB_PREFIX_.'pagebuilderprofile_shop ps ON (p.id_pagebuilderprofile = ps.id_pagebuilderprofile)
				WHERE id_shop = '.(int)$id_shop.' AND ps.default=1 '
			);
		}

		public function getDateById()
		{
			return '';
		}

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
		 * general function to render FORM 
		 *
		 * @param String $type is form type.
		 * @param Array default data values for inputs.
		 *
		 * @return Text.
		 */
		public function renderForm($type, $data = array())
		{
			$class = 'PsWidget'.Tools::ucfirst($type);

			if (class_exists($class))
			{
				$widget = new $class();

				return $widget->renderForm($data);
			}

			return $this->l('Sorry, Form Setting is not avairiable for this type');
		}

		public function getLayout()
		{
			$output = array();
			if ($this->id)
				$output = Tools::jsonDecode(trim($this->layout));
			return $output;
		}

		public function getWidgets()
		{
			$output = array();
			if ($this->id)
			{
				$ws = unserialize(PsPagebuilderHelper::clearUnexpected(trim($this->widget)));
				return $ws;
			}
			return $output;
		}

		/**
		 *
		 */
		public function getWidgetContent($type, $data)
		{
			$data['widget_heading'] = '';
			if (isset($data['widget_title_'.$this->lang_id]) && $data['show_title']) {
				$data['widget_heading'] = $data['widget_title_'.$this->lang_id];
			}
			$items_owl_carousel_tpl = _PS_MODULE_DIR_.'/pspagebuilder/views/templates/front/widgets/sub/items_owl_carousel.tpl';
			$titems_owl_carousel_tpl = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/modules/pspagebuilder/views/templates/front/widgets/sub/items_owl_carousel.tpl';
			if (file_exists($titems_owl_carousel_tpl)) {
				$items_owl_carousel_tpl = $titems_owl_carousel_tpl;
			}
			$data['items_owl_carousel_tpl'] = $items_owl_carousel_tpl;
			$items_normal_tpl = _PS_MODULE_DIR_.'/pspagebuilder/views/templates/front/widgets/sub/items_normal.tpl';
			$titems_normal_tpl = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/modules/pspagebuilder/views/templates/front/widgets/sub/items_normal.tpl';
			if (file_exists($titems_normal_tpl)) {
				$items_normal_tpl = $titems_normal_tpl;
			}
			$data['items_normal_tpl'] = $items_normal_tpl;

			$theme_name = Context::getContext()->shop->getTheme();
			if (_PS_MODE_DEMO_)
			{
				$cgtheme = Tools::getValue('themeskin');
				$kc = $theme_name.'_themeskin';
				if (!Tools::getIsset('applyCustomSkinChanger') && !Tools::getIsset('resetDemoTheme') && !$cgtheme && Context::getContext()->cookie->__isset($kc))
					$cgtheme = Context::getContext()->cookie->__get($kc);
				else
					if (Tools::getIsset('resetDemoTheme'))
						$cgtheme = Configuration::get('PTS_CP_THEME');
					else
						$cgtheme = Tools::getValue('themeskin') ? Tools::getValue('themeskin') : Configuration::get('PTS_CP_THEME');

				$productsstyle = Tools::getValue('productsstyle');
				if (!$productsstyle)
				{
					$kc = Context::getContext()->shop->getTheme().'_productsstyle';
					if (Context::getContext()->cookie->__isset($kc))
						$productsstyle = Context::getContext()->cookie->__get($kc);
				}
				if (!$productsstyle)
					$productsstyle = Configuration::get('PTS_CP_PRODUCT_STYLE');

				$product_style = $productsstyle;
			}
			else
			{
				$cgtheme = Tools::getValue('themeskin') ? Tools::getValue('themeskin') : Configuration::get('PTS_CP_THEME');
				$product_style = Configuration::get('PTS_CP_PRODUCT_STYLE');
			}

			$data['THEME_SKIN_DIR'] = _PS_ALL_THEMES_DIR_.$theme_name.'/sub/themes/'.$cgtheme.'/';
			$data['DEFAULT_THEMESKIN'] = $cgtheme;
			$data['product_style'] = $product_style;
			Context::getContext()->smarty->assign('product_style', $product_style);

			if (isset($this->engines[$type]))
				return $this->engines[$type]->renderContent($data);
			return '';
		}
		
		public function loadWidgetObject($type, $controller = null)
		{
			if (!isset($this->engines[$type]))
			{
				$class = 'PsWidget'.Tools::ucfirst($type);
				if (class_exists($class))
				{
					$this->engines[$type] = new $class();
					$this->engines[$type]->lang_id = $this->lang_id;

					if ($controller)
					{
						$this->engines[$type]->beforeAdminProcess($controller);
						return $this->engines[$type];
					}
				}
			}
		}

		public function widgetBeforeProcess($controller)
		{
			foreach ($this->widgets as $w)
			{
				$class = 'PsWidget'.Tools::ucfirst($w);
				if (class_exists($class))
				{
					$widget = new $class();
					$widget->beforeAdminProcess($controller);
				}
			}
		}

		/**
		 *
		 */
		public function loadWidgets()
		{
			if (empty($this->widgets))
			{
				$widgets = glob(_PAGEBUILDER_WIDGET_DIR_.'*.php');
				$theme_name = Context::getContext()->shop->getTheme();
				$overrides = glob(_PS_ALL_THEMES_DIR_.$theme_name.'/modules/pspagebuilder/classes/widget/*.php');
				$widgets1 = array();
				foreach ($widgets as $w)
				{
					$paths = explode('/', $w);
					$last = array_pop($paths);
					if ($last != 'index.php')
						$widgets1[$last] = $w;
				}
				$widgets2 = array();
				foreach ($overrides as $w)
				{
					$paths = explode('/', $w);
					$last = array_pop($paths);
					if ($last != 'index.php')
						$widgets1[$last] = $w;
				}
				$widgets = array_merge($widgets2, $widgets1);
				foreach ($widgets as $w)
				{
					$paths = explode('/', $w);
					$last = array_pop($paths);
					if ($last != 'index.php')
					{
						require_once($w);
						$t = str_replace('.php', '', basename($w));
						$this->widgets[$t] = $t;
					}
				}
			}
		}

	}

}