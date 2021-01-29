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

class PsWidgetFlashsale extends PsWidgetPageBuilder {

	public $name = 'flashsale';
	public $group = 'prestashop';

	public static function getWidgetInfo()
	{
		return array('label' => ('Flash Sale'), 'explain' => 'Play Countdown For Flashsale', 'group' => 'prestashop');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();
		$lists = array(
			array('value' => 'grid', 'text' => $this->l('Grid')),
			array('value' => 'list1', 'text' => $this->l('List 1')),
			array('value' => 'list2', 'text' => $this->l('List 2')),
		);
		$modes = array(
			array('value' => 'normal', 'text' => $this->l('Normal')),
			array('value' => 'carousel', 'text' => $this->l('Carousel'))
		);

		$this->fields_form[1]['form'] = array(
			'input' => array(
				array(
					'type' => 'categories_select',
					'label' => $this->l('Categories:'),
					'name' => 'categoryBox',
					'default' => '',
				)
			)
		);
		$values = $this->getConfigFieldsValues($data);

		$selected_cat = $values['categoryBox'];
		$categories = explode(',', $selected_cat);
		$root = Category::getRootCategory();

		$tree = new HelperTreeCategories('associated-categories-tree', 'Associated categories');
		$tree->setRootCategory($root->id)->setUseCheckBox(true)->setUseSearch(true)->setSelectedCategories($categories);
		$category_tpl = $tree->render();
		$key = time();

		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'datetime',
					'label' => $this->l('End date'),
					'name' => 'end_date',
					'default' => '',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Limit'),
					'name' => 'limit',
					'default' => 6,
				),
				array(
					'type' => 'categories_select',
					'label' => $this->l('Categories:'),
					'name' => 'categoryBox',
					'category_tree' => $category_tpl,
					'default' => '1,2,3',
					'desc' => $this->l('Categories only apply for Products List Type: Products Newest, Products Bestseller,
								 Products Special, Products Top Rating, Products Most View')
				),
				array(
					'type' => 'select',
					'label' => $this->l('Display Mode'),
					'name' => 'display_mode',
					'options' => array('query' => $modes,
						'id' => 'value',
						'name' => 'text'),
					'default' => 'carousel',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Number Columns On Large Desktops.'),
					'name' => 'columns',
					'desc' => $this->l('The maximum column items  in tab.'),
					'default' => '4'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Number Columns On Small Desktops'),
					'name' => 'nbr_desktops',
					'default' => '4'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Number Columns On Tablets'),
					'name' => 'nbr_tablets',
					'default' => '2'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Number Columns On Mobile'),
					'name' => 'nbr_mobile',
					'default' => '1'
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
					'label' => $this->l('List Mode'),
					'name' => 'list_mode',
					'options' => array('query' => $lists,
						'id' => 'value',
						'name' => 'text'),
					'default' => 'grid',
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
		Context::getContext()->controller->addJqueryUI('ui.datepicker');
		Context::getContext()->controller->addCSS(array(
			_PS_JS_DIR_.'jquery/plugins/timepicker/jquery-ui-timepicker-addon.css'
		));
		$string = '
			 <script type="text/javascript">
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

		return $helper->generateForm($this->fields_form).$string;
	}

	public function renderContent($setting)
	{
		$t = array(
			'categoryBox' => '',
			'end_date' => '',
			'limit' => '12',
			'image_width' => '200',
			'image_height' => '200',

			'columns' => 4,
			'rows' => 1,
			'list_mode' => 'grid',
			'display_mode' => 'carousel',
			'nbr_desktops' => 4,
			'nbr_tablets' => 2,
			'nbr_mobile' => 1,
			'class_widget' => 'flashsale',
		);
		$setting = array_merge($t, $setting);

		$time = strtotime($setting['end_date']);
		$setting['dates'] = array(
			'month' => date('m', $time),
			'day' => date('d', $time),
			'year' => date('Y', $time),
			'hour' => date('H', $time),
			'minute' => date('i', $time),
			'seconds' => date('s', $time)
		);

		$nb = (int)$setting['limit'];
	
		$special = self::getPricesDrop($setting['categoryBox'],(int)$this->lang_id, 0, $nb, false, null, null, false, $setting['end_date']);

		$setting['list_mode_tpl'] = $this->getProductListStyleFile($setting['list_mode'], $setting['product_style']);

		$setting['products'] = $special;
		$output = array('type' => 'flashsale', 'data' => $setting);

		return $output;
	}

	public static function getPricesDrop($categories, $id_lang, $page_number = 0, $nb_products = 10, $count = false,$order_by = null, $order_way = null, $beginning = false, $ending = false, Context $context = null)
	{

		if (!$context)
			$context = Context::getContext();
		if ($page_number < 0)
			$page_number = 0;
		if ($nb_products < 1)
			$nb_products = 10;
		if (empty($order_by) || $order_by == 'position')
			$order_by = 'price';
		if (empty($order_way))
			$order_way = 'DESC';
		if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd')
			$order_by_prefix = 'p';
		else if ($order_by == 'name')
			$order_by_prefix = 'pl';

		if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way))
			die(Tools::displayError());
		$current_date = date('Y-m-d H:i:s');

		$ids_product = self::getProductIdByDates($categories, (!$beginning ? $current_date : $beginning),
						(!$ending ? $current_date : $ending), $context);
		
		$tab_id_product = array();
		foreach ($ids_product as $product)
			if (is_array($product))
				$tab_id_product[] = (int)$product['id_product'];
			else
				$tab_id_product[] = (int)$product;

		$front = true;
		if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
			$front = false;

		$sql_groups = '';
		if (Group::isFeatureActive())
		{
			$groups = FrontController::getCurrentCustomerGroups();
			$sql_groups = 'AND p.`id_product` IN (
					SELECT cp.`id_product`
					FROM `'._DB_PREFIX_.'category_group` cg
					LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = cg.`id_category`)
					WHERE cg.`id_group` '.(count($groups) ? 'IN ('.pSQL(implode(',', $groups)).')' : '= 1').'
				)';
		}

		if (strpos($order_by, '.') > 0)
		{
			$order_by = explode('.', $order_by);
			$order_by = pSQL($order_by[0]).'.`'.pSQL($order_by[1]).'`';
		}

		$sql = '
			SELECT
				p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`,
				MAX(product_attribute_shop.id_product_attribute) id_product_attribute,
				pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`,
				pl.`name`, MAX(image_shop.`id_image`) id_image, il.`legend`, m.`name` AS manufacturer_name,
				DATEDIFF(
					p.`date_add`,
					DATE_SUB(
						NOW(),
						INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT'))
									? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY
					)
				) > 0 AS new
			FROM `'._DB_PREFIX_.'product` p
			'.Shop::addSqlAssociation('product', 'p').'
			LEFT JOIN '._DB_PREFIX_.'product_attribute pa ON (pa.id_product = p.id_product)
			'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.default_on=1').'
			'.Product::sqlStock('p', 0, false, $context->shop).'
			LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (
				p.`id_product` = pl.`id_product`
				AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
			)
			LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'.
						Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
			LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
			LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
			WHERE product_shop.`active` = 1
			AND product_shop.`show_price` = 1
			'.($front ? '  AND p.`id_product` IN ('.((is_array($tab_id_product) && count($tab_id_product))
							? pSQL(implode(', ', $tab_id_product)) : 0).')' : '').'
			'.$sql_groups.'
			GROUP BY product_shop.id_product
			ORDER BY '.(isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '').pSQL($order_by).' '.pSQL($order_way).'
			LIMIT '.((int)$page_number * (int)$nb_products).', '.(int)$nb_products;

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

		if (!$result)
			return false;

		if ($order_by == 'price')
			Tools::orderbyPrice($result, $order_way);

		return Product::getProductsProperties($id_lang, $result);
	}

	public static function getProductIdByDates($categories, $beginning, $ending, Context $context = null, $with_combination = false)
	{
		if (!$context)
			$context = Context::getContext();

		$id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
		$ids = Address::getCountryAndState($id_address);
		$id_country = ($ids['id_country'] ? (int)$ids['id_country'] : (int)Configuration::get('PS_COUNTRY_DEFAULT'));

		return self::getProductIdByDate($categories, $context->shop->id, $context->currency->id, $id_country,
						$context->customer->id_default_group, $beginning, $ending, 0, $with_combination);
	}
	public static function getProductIdByDate($categories, $id_shop, $id_currency, $id_country,
					$id_group, $beginning, $ending, $id_customer = 0, $with_combination_id = false)
	{

		if (!SpecificPrice::isFeatureActive())
			return array();

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
				SELECT sp.`id_product`, sp.`id_product_attribute`
				FROM `'._DB_PREFIX_.'specific_price` sp 
				JOIN `'._DB_PREFIX_.'category_product` cp ON (sp.`id_product` = cp.`id_product`)
				WHERE	sp.`id_shop` IN(0, '.(int)$id_shop.') AND
						sp.`id_currency` IN(0, '.(int)$id_currency.') AND
						sp.`id_country` IN(0, '.(int)$id_country.') AND
						sp.`id_group` IN(0, '.(int)$id_group.') AND
						sp.`id_customer` IN(0, '.(int)$id_customer.') AND
						sp.`from_quantity` = 1 AND
						(
							(`from` = \'0000-00-00 00:00:00\' OR \''.pSQL($beginning).'\' >= `from`)
							AND
							(`to` = \'0000-00-00 00:00:00\' OR \''.pSQL($ending).'\' <= `to`)
						)
						AND
						sp.`reduction` > 0
						'.($categories ? ' AND cp.`id_category` IN (0, '.pSQL($categories).')' : '').'
			', false);
		$ids_product = array();
		while ($row = Db::getInstance()->nextRow($result))
			$ids_product[] = $with_combination_id ? array('id_product' => (int)$row['id_product'],
				'id_product_attribute' => (int)$row['id_product_attribute']) : (int)$row['id_product'];
		return $ids_product;
	}
}
