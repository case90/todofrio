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

class PsWidgetCategoriesblock extends PsWidgetPageBuilder {

	public $name = 'categoriesblock';

	public static function getWidgetInfo()
	{
		return array('label' => 'Categories BLock', 'explain' => 'Show Categories Block to Front Office', 'group' => 'prestashop');
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
					'label' => $this->l('Maximum depth'),
					'name' => 'categ_max_depth',
					'desc' => $this->l('Set the maximum depth of category sublevels displayed in this block (0 = infinite).'),
					'default' => 4
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Dynamic'),
					'name' => 'categ_dhtml',
					'desc' => $this->l('Activate dynamic (animated) mode for category sublevels.'),
					'values' => array(
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
					),
					'default' => 1
				),
				array(
					'type' => 'radio',
					'label' => $this->l('Sort'),
					'name' => 'categ_sort',
					'values' => array(
						array(
							'id' => 'name',
							'value' => 1,
							'label' => $this->l('By name')
						),
						array(
							'id' => 'position',
							'value' => 0,
							'label' => $this->l('By position')
						),
					),
					'default' => 0
				),
				array(
					'type' => 'radio',
					'label' => $this->l('Sort order'),
					'name' => 'categ_sort_way',
					'values' => array(
						array(
							'id' => 'name',
							'value' => 1,
							'label' => $this->l('Descending')
						),
						array(
							'id' => 'position',
							'value' => 0,
							'label' => $this->l('Ascending')
						),
					),
					'default' => 0
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
			'categ_root_category' => '1',
			'categ_max_depth' => 4,
			'categ_dhtml' => 1,
			'categ_sort' => 0,
			'categ_sort_way' => 0
		);

		$setting = array_merge($t, $setting);

		$context = Context::getContext();
		$this->setLastVisitedCategory();

		$max_depth = $setting['categ_max_depth'];

		$result_ids = array();
		$result_parents = array();
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT c.id_parent, c.id_category, cl.name, cl.description, cl.link_rewrite
			FROM `'._DB_PREFIX_.'category` c
			INNER JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` 
				AND cl.`id_lang` = '.(int)$context->language->id.Shop::addSqlRestrictionOnLang('cl').')
			INNER JOIN `'._DB_PREFIX_.'category_shop` cs ON (cs.`id_category` = c.`id_category` AND cs.`id_shop` = '.(int)$context->shop->id.')
			WHERE (c.`active` = 1 OR c.`id_category` = '.(int)Configuration::get('PS_HOME_CATEGORY').')
			AND c.`id_category` != '.(int)Configuration::get('PS_ROOT_CATEGORY').
							((int)$max_depth != 0 ? ' AND `level_depth` <= '.(int)$max_depth : '').'
			AND c.id_category IN (
				SELECT id_category
				FROM `'._DB_PREFIX_.'category_group`
				WHERE `id_group` IN ('.pSQL(implode(', ', Customer::getGroupsStatic((int)$context->customer->id))).')
			)
			ORDER BY `level_depth` ASC, '.($setting['categ_sort'] ? 'cl.`name`' : 'cs.`position`').' '.($setting['categ_sort_way'] ? 'DESC' : 'ASC'));
		foreach ($result as &$row)
		{
			$result_parents[$row['id_parent']][] = &$row;
			$result_ids[$row['id_category']] = &$row;
		}

		$block_categ_tree = $this->getTree($result_parents, $result_ids, $max_depth, null);
		$setting['blockCategTree'] = $block_categ_tree;

		if ((Tools::getValue('id_product') || Tools::getValue('id_category'))
			&& isset($context->cookie->last_visited_category) && $context->cookie->last_visited_category)
		{
			$category = new Category($context->cookie->last_visited_category, $context->language->id);
			if (Validate::isLoadedObject($category))
			{
				$setting['currentCategory'] = $category;
				$setting['currentCategoryId'] = $category->id;
			}
		}

		$setting['isDhtml'] = $setting['categ_dhtml'];
		if (file_exists(_PS_THEME_DIR_.'modules/pspagebuilder/views/templates/front/widgets/sub/category-tree-branch.tpl'))
			$setting['branche_tpl_path'] = _PS_THEME_DIR_.'modules/pspagebuilder/views/templates/front/widgets/sub/category-tree-branch.tpl';
		else
			$setting['branche_tpl_path'] = _PS_MODULE_DIR_.'pspagebuilder/views/templates/front/widgets/sub/category-tree-branch.tpl';

		$output = array('type' => 'categoriesblock', 'data' => $setting);

		return $output;
	}

	public function setLastVisitedCategory()
	{
		$cache_id = 'pspagebuilder::setLastVisitedCategory';
		$context = Context::getContext();
		if (!Cache::isStored($cache_id))
		{
			if (method_exists($context->controller, 'getCategory') && ($category = $context->controller->getCategory()))
				$context->cookie->last_visited_category = $category->id;
			elseif (method_exists($context->controller, 'getProduct') && ($product = $context->controller->getProduct()))
				if (!isset($context->cookie->last_visited_category)
					|| !Product::idIsOnCategoryId($product->id, array(array('id_category' => $context->cookie->last_visited_category)))
					|| !Category::inShopStatic($context->cookie->last_visited_category, $context->shop))
					$context->cookie->last_visited_category = (int)$product->id_category_default;
			Cache::store($cache_id, $context->cookie->last_visited_category);
		}
		return Cache::retrieve($cache_id);
	}

	public function getTree($result_parents, $result_ids, $max_depth, $id_category = null, $current_depth = 0)
	{
		$context = Context::getContext();
		if (is_null($id_category))
			$id_category = $context->shop->getCategory();

		$children = array();
		if (isset($result_parents[$id_category]) && count($result_parents[$id_category]) && ($max_depth == 0 || $current_depth < $max_depth))
			foreach ($result_parents[$id_category] as $subcat)
				$children[] = $this->getTree($result_parents, $result_ids, $max_depth, $subcat['id_category'], $current_depth + 1);

		if (!isset($result_ids[$id_category]))
			return false;

		$obj = new Category($id_category);
		$total_products = $obj->getProducts($context->language->id, 0, 1, null, null, true);
		$return = array(
			'id' => $id_category,
			'link' => $context->link->getCategoryLink($id_category, $result_ids[$id_category]['link_rewrite']),
			'name' => $result_ids[$id_category]['name'],
			'desc' => $result_ids[$id_category]['description'],
			'children' => $children,
			'total_products' => $total_products,
		);

		return $return;
	}

}
