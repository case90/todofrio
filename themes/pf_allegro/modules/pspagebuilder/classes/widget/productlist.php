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

class PsWidgetProductlist extends PsWidgetPageBuilder {

	public $name = 'productlist';
	public $group = 'product';

	public static function getWidgetInfo()
	{
		return array('label' => ('Product List'), 'explain' => 'Product List With Option: Newest, Bestseller, Special, Featured', 'group' => 'prestashop');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();

		$types = array();
		$types[] = array(
			'value' => 'newest',
			'text' => $this->l('Products Newest')
		);
		$types[] = array(
			'value' => 'bestseller',
			'text' => $this->l('Products Bestseller')
		);

		$types[] = array(
			'value' => 'special',
			'text' => $this->l('Products Special')
		);

		$types[] = array(
			'value' => 'featured',
			'text' => $this->l('Products Featured')
		);

		$types[] = array(
			'value' => 'toprating',
			'text' => $this->l('Products Top Rating')
		);
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
					'type' => 'text',
					'label' => $this->l('Sub Title'),
					'name' => 'subtitle',
					'default' => '',
					'lang' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Banner'),
					'name' => 'banner_imagefile',
					'class' => 'imageupload',
					'default' => '',
					'id' => 'banner_imagefile'.$key,
					'desc' => 'Put image folder in the image folder ROOT_SHOP_DIR/img/'
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Description'),
					'name' => 'description',
					'cols' => 40,
					'rows' => 20,
					'value' => true,
					'lang' => true,
					'default' => '',
					'autoload_rte' => false,
					'desc' => 'Enter HTML CODE in here'
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
					'type' => 'text',
					'label' => $this->l('Limit'),
					'name' => 'limit',
					'default' => 6,
				),
				array(
					'type' => 'select',
					'label' => $this->l('Products List Type'),
					'name' => 'list_type',
					'options' => array('query' => $types,
						'id' => 'value',
						'name' => 'text'),
					'default' => 'newest',
					'desc' => $this->l('Select a Product List Type')
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
					'desc' => $this->l('The maximum rows items  in tab.'),
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

		$string = '
			 <script type="text/javascript">
				$(".imageupload").WPO_Gallery({gallery:false});
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
			'categoryBox' => '',
			'list_type' => '',
			'list_mode' => '',
			'limit' => 12,
			'image_width' => '200',
			'image_height' => '200',
			'description' => '',
			'image' => '',
			'banner_imagefile' => '',
			'imageurl' => '',

			'columns' => 4,
			'list_mode' => 'grid',
			'display_mode' => 'carousel',
			'nbr_desktops' => 4,
			'nbr_tablets' => 2,
			'nbr_mobile' => 1,
			'rows' => 1,
			'class_widget' => 'productlist',
			'subtitle' => ''
		);

		$products = array();
		$setting = array_merge($t, $setting);
		$language_id = Context::getContext()->language->id;
		$setting['subtitle'] = isset($setting['subtitle_'.$language_id]) ? ($setting['subtitle_'.$language_id]) : '';
		$setting['description'] = isset($setting['description_'.$language_id]) ? ($setting['description_'.$language_id]) : '';

		switch ($setting['list_type'])
		{
			case 'newest':
				$products = self::getNewProducts($setting['categoryBox'], $this->lang_id, 0, (int)$setting['limit']);
				$setting['link_to_all'] = Context::getContext()->link->getPageLink('new-products');
				break;

			case 'featured':
				$category = new Category(Context::getContext()->shop->getCategory(), $this->lang_id);
				$nb = (int)$setting['limit'];
				$products = $category->getProducts((int)$this->lang_id, 1, ($nb ? $nb : 8));
				break;
			case 'bestseller':
				$products = self::getBestSalesLight($setting['categoryBox'], (int)$this->lang_id, 0, (int)$setting['limit']);
				$setting['link_to_all'] = Context::getContext()->link->getPageLink('best-sales');
				break;
			case 'special':
				$products = self::getPricesDrop($setting['categoryBox'], $this->lang_id, 0, (int)$setting['limit']);
				$setting['link_to_all'] = Context::getContext()->link->getPageLink('prices-drop');
				break;
			case 'toprating':
				$products = self::getProducts($setting['categoryBox'], 0, (int)$setting['limit']);
				break;
		}

		$setting['list_mode_tpl'] = $this->getProductListStyleFile($setting['list_mode'], $setting['product_style']);

		if ($setting['banner_imagefile'])
			$setting['bannerurl'] = _PAGEBUILDER_IMAGE_URL_.$setting['banner_imagefile'];
		
		$setting['products'] = $products;
		$output = array('type' => 'products', 'data' => $setting);

		return $output;
	}

	public static function getProducts($categories, $p = 1, $n, $active = true, Context $context = null, $type = 'toprating')
	{
		if (!$context)
			$context = Context::getContext();
		$id_lang = $context->language->id;

		$front = true;
		if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
			$front = false;

		if ($p < 1)
			$p = 1;

		$id_supplier = (int)Tools::getValue('id_supplier');
		$validate_approve = Configuration::get('PRODUCT_COMMENTS_MODERATE');
		
		$sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, 
				MAX(product_attribute_shop.id_product_attribute) id_product_attribute, 
					product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, 
					pl.`description`, pl.`description_short`, pl.`available_now`,
					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, 
					pl.`meta_title`, pl.`name`, MAX(image_shop.`id_image`) id_image,
						il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS category_default,
						DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
						INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT'))
						? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).'
								DAY)) > 0 AS new, product_shop.price AS orderprice'.($type == 'toprating' ? ', AVG(pc.grade) as avg_grade' : '').'
				FROM `'._DB_PREFIX_.'category_product` cp
				LEFT JOIN `'._DB_PREFIX_.'product` p
						ON p.`id_product` = cp.`id_product`
				'.Shop::addSqlAssociation('product', 'p').'
				LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
				ON (p.`id_product` = pa.`id_product`)
				'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
				'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop).'
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
						ON (product_shop.`id_category_default` = cl.`id_category`
						AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
						ON (p.`id_product` = pl.`id_product`
						AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'image` i
						ON (i.`id_product` = p.`id_product`)'.
			Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il
						ON (image_shop.`id_image` = il.`id_image`
						AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
						ON m.`id_manufacturer` = p.`id_manufacturer`

				'.($type == 'toprating' ? '
				JOIN `'._DB_PREFIX_.'product_comment` pc ON (cp.id_product = pc.id_product '.($validate_approve ? ' AND pc.validate = 1' : '').')
				' : '').'

				WHERE product_shop.`id_shop` = '.(int)$context->shop->id
				.($active ? ' AND product_shop.`active` = 1' : '')
				.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
				.($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '')
				.($categories ? ' AND cp.id_category IN (0, '.pSQL($categories).')' : '');

		if ($type == 'toprating')
		{
			$sql .= ' GROUP BY product_shop.id_product ';
			$sql .= ' ORDER BY avg_grade DESC ';
		}
		$sql .= ' LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n;
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		if (!$result)
			return array();
		/* Modify SQL result */
		return Product::getProductsProperties($id_lang, $result);
	}

	public static function getNewProducts($categories, $id_lang, $page_number = 0,
					$nb_products = 10, $order_by = null, $order_way = null, Context $context = null)
	{
		if (!$context)
			$context = Context::getContext();

		$front = true;
		if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
			$front = false;

		if ($page_number < 0)
			$page_number = 0;
		if ($nb_products < 1)
			$nb_products = 10;
		if (empty($order_by) || $order_by == 'position')
			$order_by = 'date_add';
		if (empty($order_way))
			$order_way = 'DESC';
		if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd')
			$order_by_prefix = 'p';
		else if ($order_by == 'name')
			$order_by_prefix = 'pl';
		if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way))
			die(Tools::displayError());

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
			$order_by_prefix = $order_by[0];
			$order_by = $order_by[1];
		}

		$sql = new DbQuery();
		$sql->select('p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity,
			pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`,
				pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`,
				MAX(image_shop.`id_image`) id_image, il.`legend`, m.`name` AS manufacturer_name,
				product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')
						? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'" as new');

		$sql->from('product', 'p');
		$sql->join(Shop::addSqlAssociation('product', 'p'));
		$sql->leftJoin('product_lang', 'pl', '
				p.`id_product` = pl.`id_product`
				AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl')
		);
		$sql->leftJoin('category_product', 'cpp', 'cpp.`id_product` = p.`id_product`');

		$sql->leftJoin('image', 'i', 'i.`id_product` = p.`id_product`');
		$sql->join(Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1'));
		$sql->leftJoin('image_lang', 'il', 'i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang);
		$sql->leftJoin('manufacturer', 'm', 'm.`id_manufacturer` = p.`id_manufacturer`');

		$sql->where('product_shop.`active` = 1');
		if ($front)
			$sql->where('product_shop.`visibility` IN ("both", "catalog")');
		$sql->where('product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')
						? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'"');

		if ($categories)
			$sql->where('cpp.`id_category` IN (0, '.pSQL($categories).')');

		if (Group::isFeatureActive())
			$sql->where('p.`id_product` IN (
					SELECT cp.`id_product`
					FROM `'._DB_PREFIX_.'category_group` cg
					LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_category` = cg.`id_category`)
					WHERE cg.`id_group` '.$sql_groups.'
				)');
		$sql->groupBy('product_shop.id_product');

		$sql->orderBy((isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '').'`'.pSQL($order_by).'` '.pSQL($order_way));
		$sql->limit($nb_products, $page_number * $nb_products);

		if (Combination::isFeatureActive())
		{
			$sql->select('MAX(product_attribute_shop.id_product_attribute) id_product_attribute');
			$sql->leftOuterJoin('product_attribute', 'pa', 'p.`id_product` = pa.`id_product`');
			$sql->join(Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.default_on = 1'));
		}
		$sql->join(Product::sqlStock('p', Combination::isFeatureActive() ? 'product_attribute_shop' : 0));

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

		if ($order_by == 'price')
			Tools::orderbyPrice($result, $order_way);
		
		if (!$result)
			return false;

		$products_ids = array();
		foreach ($result as $row)
			$products_ids[] = $row['id_product'];
		// Thus you can avoid one query per product, because there will be only one query for all the products of the cart
		Product::cacheFrontFeatures($products_ids, $id_lang);
		return Product::getProductsProperties((int)$id_lang, $result);
	}

	public static function getBestSalesLight($categories, $id_lang, $page_number = 0, $nb_products = 10, Context $context = null)
	{
		if (!$context)
			$context = Context::getContext();
		if ($page_number < 0)
			$page_number = 0;
		if ($nb_products < 1)
			$nb_products = 10;

		$sql_groups = '';
		if (Group::isFeatureActive())
		{
			$groups = FrontController::getCurrentCustomerGroups();
			$sql_groups = 'AND cg.`id_group` '.(count($groups) ? 'IN ('.pSQL(implode(',', $groups)).')' : '= 1');
		}

		//Subquery: get product ids in a separate query to (greatly!) improve performances and RAM usage
		$products = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT cp.`id_product`
			FROM `'._DB_PREFIX_.'category_product` cp
			LEFT JOIN `'._DB_PREFIX_.'category_group` cg ON (cg.`id_category` = cp.`id_category`)
			WHERE cg.`id_group` '.$sql_groups);

		$ids = array();
		foreach ($products as $product)
			$ids[$product['id_product']] = 1;

		$ids = array_keys($ids);
		sort($ids);
		$ids = count($ids) > 0 ? implode(',', $ids) : 'NULL';

		//Main query
		$sql = '
			SELECT
				p.id_product,  MAX(product_attribute_shop.id_product_attribute) id_product_attribute, 
				pl.`link_rewrite`, pl.`name`, pl.`description_short`, product_shop.`id_category_default`,
				MAX(image_shop.`id_image`) id_image, il.`legend`,
				ps.`quantity` AS sales, p.`ean13`, p.`upc`, cl.`link_rewrite` AS category, p.show_price, 
				p.available_for_order, IFNULL(stock.quantity, 0) as quantity, p.customizable,
				IFNULL(pa.minimal_quantity, p.minimal_quantity) as minimal_quantity, stock.out_of_stock,
				product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')
						? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'" as new, product_shop.`on_sale`
			FROM `'._DB_PREFIX_.'product_sale` ps
			LEFT JOIN `'._DB_PREFIX_.'product` p ON ps.`id_product` = p.`id_product`
			'.Shop::addSqlAssociation('product', 'p').'
			LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
				ON (p.`id_product` = pa.`id_product`)
			'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1').'
			'.Product::sqlStock('p', 'product_attribute_shop', false, $context->shop).'
			LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
				ON p.`id_product` = pl.`id_product`
				AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
			LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'.
						Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1').'
			LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
			LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
				ON cl.`id_category` = product_shop.`id_category_default`
				AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').'
			WHERE product_shop.`active` = 1
			AND p.`visibility` != \'none\'
			AND p.`id_product` IN ('.pSQL($ids).')
			'.($categories ? 'AND product_shop.`id_category_default` IN (0, '.pSQL($categories).')' : '').'
			GROUP BY product_shop.id_product
			ORDER BY sales DESC
			LIMIT '.((int)$page_number * (int)$nb_products).', '.(int)$nb_products;

		if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql))
			return false;

		return Product::getProductsProperties($id_lang, $result);
	}

	public static function getPricesDrop($categories, $id_lang, $page_number = 0, $nb_products = 10,
					$order_by = null, $order_way = null, $beginning = false, $ending = false, Context $context = null)
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
			'.($front ? ' AND p.`visibility` IN ("both", "catalog")' : '').'
			'.((!$beginning && !$ending) ? ' AND p.`id_product` IN ('.((is_array($tab_id_product) && count($tab_id_product))
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
