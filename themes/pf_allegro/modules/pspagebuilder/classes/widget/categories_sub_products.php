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

class PsWidgetCategories_sub_products extends PsWidgetPageBuilder {

		public $name = 'categories_sub_products';

		public  static function getWidgetInfo(){
			return array( 'label' => 'Category, Subcategories, Products', 'explain' => 'Show Category, Subcategories, Products to Front Office', 'group' => 'prestashop'  );
		}

		public static function renderButton(){

		}

		public function renderForm($data ){
			$helper = $this->getFormHelper();

			$this->fields_form[1]['form'] = array(
	            'input' => array(
	            	array(
						'type'  => 'categories',
						'label' => $this->l('Parent category'),
						'name'  => 'id_parent'
					)
	            )
	        );
		 	$fields_value = $this->getConfigFieldsValues( $data  );
		 	$selected_categories = array((isset($fields_value['id_parent']) && $fields_value['id_parent']) ? $fields_value['id_parent'] : 0);
			
			$types = array();	
		 	$types[] = array(
		 		'value' => 'newest',
		 		'text'  => $this->l('Products Newest')
		 	);
		 	$types[] = array(
		 		'value' => 'bestseller',
		 		'text'  => $this->l('Products Bestseller')
		 	);
		 	$types[] = array(
		 		'value' => 'special',
		 		'text'  => $this->l('Products Special')
		 	);
		 	$types[] = array(
		 		'value' => 'toprating',
		 		'text'  => $this->l('Products Top Rating')
		 	);

			$key = time();	
			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
	            	array(
						'type'  => 'categories',
						'label' => $this->l('Parent category'),
						'name'  => 'id_parent',
						'tree'  => array(
							'id'                  => 'categories-tree',
							'selected_categories' => $selected_categories,
							'disabled_categories' => null,
							'root_category'       => $this->context->shop->getCategory()
						)
					),
	                array(
	                    'type' => 'text',
	                    'label' => $this->l('Limit Subcategories'),
	                    'name' => 'limit_sub',
	                    'default'=> '6',
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Image File'),
	                    'name'  => 'imagefile',
	                    'class' => 'imageupload',
	                    'default'=> '',
	                    'id'	 => 'imagefile'.$key,
	                    'desc'	=> 'Put image folder in the image folder ROOT_SHOP_DIR/img/'
	                ),
	                array(
	                    'type' 	  => 'select',
	                    'label'   => $this->l( 'Products Block 1' ),
	                    'name' 	  => 'product_block1',
	                    'options' => array(  'query' => $types ,
	                    'id' 	  => 'value',
	                    'name' 	  => 'text' ),
	                    'default' => "bestseller",
	                    'desc'    => $this->l( 'Select a Product List Type' )
	                ),
	                array(
	                    'type' 	  => 'select',
	                    'label'   => $this->l( 'Products Block 2' ),
	                    'name' 	  => 'product_block2',
	                    'options' => array(  'query' => $types ,
	                    'id' 	  => 'value',
	                    'name' 	  => 'text' ),
	                    'default' => "newest",
	                    'desc'    => $this->l( 'Select a Product List Type' )
	                ),
	                array(
	                    'type' => 'text',
	                    'label' => $this->l('Limit Products'),
	                    'name' => 'limit_products',
	                    'default'=> '6',
	                ),
	            ),

	      		'submit' => array(
	                'title' => $this->l('Save'),
	                'class' => 'button'
	       		)
	        );

 
		 	$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
			
			$helper->tpl_vars = array(
	                'fields_value' => $this->getConfigFieldsValues( $data  ),
	                'languages' => Context::getContext()->controller->getLanguages(),
	                'id_language' => $default_lang
        	);  
			$string = '
					 <script type="text/javascript">
						$(".imageupload").WPO_Gallery({gallery:false} );
					</script>
		 
			';
			return  '<div id="imageslist'.$key.'">'.$helper->generateForm( $this->fields_form ) .$string."</div>" ;

		}

		public function renderContent($setting)
		{
			$t  = array(
				'id_parent' => '',
				'limit_sub' => 6,
				'imagefile' => '',
				'product_block1' => 'bestseller',
				'product_block2' => 'newest',
				'limit_products' => 6
			);

			$setting = array_merge( $t, $setting );
			$context = Context::getContext();
			if($setting['id_parent']){
				$obj = new Category($setting['id_parent'], $context->language->id);
				if(Validate::isLoadedObject($obj)){
					$subcategories = self::getSubCategories($setting['id_parent'], $setting['limit_sub'], $context->language->id);
					$setting['objCategory'] = $obj;
					$setting['subcategories'] = $subcategories;
					$setting['imageurl'] = '';
					if($setting['imagefile'] && file_exists(_PAGEBUILDER_IMAGE_DIR_.$setting['imagefile'])){
						$setting['imageurl'] = _PAGEBUILDER_IMAGE_URL_.$setting['imagefile'];
					}
					$products_block1 = array();
					switch ( $setting['product_block1'] ) {
						case 'newest':
							$products_block1 = array(
								'type' => 'newest',
								'products' => self::getNewProducts($setting['id_parent'], $context->language->id, 0, $setting['limit_products'] )
							);
							break;
					 	case 'bestseller':
					 		$products_block1 = array(
								'type' => 'bestseller',
								'products' => self::getBestSalesLight($setting['id_parent'], $context->language->id, 0, $setting['limit_products'])
							);
					 		break;	
					 	case 'special':
					 		$products_block1 = array(
								'type' => 'special',
								'products' => self::getPricesDrop($setting['id_parent'], $context->language->id, 0, $setting['limit_products'] )
							);
					 		break;
				 		case 'toprating': 
				 			$products_block1 = array(
								'type' => 'toprating',
								'products' => self::getProducts($setting['id_parent'], 0, $setting['limit_products'] )
							);
					 		break;
					}
					$products_block2 = array();
					switch ( $setting['product_block2'] ) {
						case 'newest':
							$products_block2 = array(
								'type' => 'newest',
								'products' => self::getNewProducts($setting['id_parent'], $context->language->id, 0, $setting['limit_products'] )
							);
							break;
					 	case 'bestseller':
					 		$products_block2 = array(
								'type' => 'bestseller',
								'products' => self::getBestSalesLight($setting['id_parent'], $context->language->id, 0, $setting['limit_products'])
							);
					 		break;	
					 	case 'special':
					 		$products_block2 = array(
								'type' => 'special',
								'products' => self::getPricesDrop($setting['id_parent'], $context->language->id, 0, $setting['limit_products'] )
							);
					 		break;
				 		case 'toprating': 

				 			$products_block2 = array(
								'type' => 'toprating',
								'products' => self::getProducts($setting['id_parent'], 0, $setting['limit_products'] )
							);
					 		break;
					}
					$setting['products_block1'] = $products_block1;
					$setting['products_block2'] = $products_block2;
				}
			}
			$list_mode_tpl = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/modules/pspagebuilder/views/templates/front/widgets/sub/item_product_grid.tpl';
			$tlist_mode_tpl = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/modules/pspagebuilder/views/templates/front/widgets/sub/item_product_list1.tpl';
			$setting['list_mode_tpl'] = $list_mode_tpl;
			$setting['tlist_mode_tpl'] = $tlist_mode_tpl;
            $setting['wkey'] = rand(0,time());
			//d($setting);
			$output = array('type'=>'categories_sub_products','data' => $setting );

	  		return $output;
		}

		public function getSubCategories($id_category, $nb = 5, $id_lang, $active = true)
		{
			$sql_groups_where = '';
			$sql_groups_join = '';
			if (Group::isFeatureActive())
			{
				$sql_groups_join = 'LEFT JOIN `'._DB_PREFIX_.'category_group` cg ON (cg.`id_category` = c.`id_category`)';
				$groups = FrontController::getCurrentCustomerGroups();
				$sql_groups_where = 'AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '='.(int)Group::getCurrent()->id);
			}

			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
			SELECT c.*, cl.id_lang, cl.name, cl.description, cl.link_rewrite, cl.meta_title, cl.meta_keywords, cl.meta_description
			FROM `'._DB_PREFIX_.'category` c
			'.Shop::addSqlAssociation('category', 'c').'
			LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND `id_lang` = '.(int)$id_lang.' '.Shop::addSqlRestrictionOnLang('cl').')
			'.$sql_groups_join.'
			WHERE `id_parent` = '.(int)$id_category.'
			'.($active ? 'AND `active` = 1' : '').'
			'.$sql_groups_where.'
			GROUP BY c.`id_category`
			ORDER BY `level_depth` ASC, category_shop.`position` ASC
			LIMIT 0,'.(int)$nb );

			foreach ($result as &$row)
			{
				$row['id_image'] = Tools::file_exists_cache(_PS_CAT_IMG_DIR_.$row['id_category'].'.jpg') ? (int)$row['id_category'] : Language::getIsoById($id_lang).'-default';
				$row['legend'] = 'no picture';
			}
			return $result;
		}

		public static function getProducts($categories, $p = 1, $n, $active = true, Context $context = null, $type = 'toprating')
	    {
	        if (!$context)
	            $context = Context::getContext();
	        $id_lang = $context->language->id;

	        $front = true;
	        if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
	            $front = false;

	        if ($p < 1) $p = 1;

	        $id_supplier = (int)Tools::getValue('id_supplier');

	        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, MAX(product_attribute_shop.id_product_attribute) id_product_attribute, product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, pl.`description`, pl.`description_short`, pl.`available_now`,
	                pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, MAX(image_shop.`id_image`) id_image,
	                il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS category_default,
	                DATEDIFF(product_shop.`date_add`, DATE_SUB(NOW(),
	                INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).'
	                    DAY)) > 0 AS new, product_shop.price AS orderprice'. ($type == 'mostview' ? ', count(cnn.id_connections) as pages' : ''). ($type == 'toprating' ? ', AVG(pc.grade) as avg_grade' : '').'
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

	            '. ($type == 'mostview' ? '
				LEFT JOIN `'._DB_PREFIX_.'page` pag ON (cp.id_product = pag.id_object)
				LEFT JOIN `'._DB_PREFIX_.'connections` cnn ON (cnn.id_page = pag.id_page)
				LEFT JOIN `'._DB_PREFIX_.'page_type` pat ON (pat.id_page_type = pag.id_page_type)
				' : '').
				($type == 'toprating' ? '
				JOIN `'._DB_PREFIX_.'product_comment` pc ON (cp.id_product = pc.id_product AND pc.validate = 1)
				' : '').'

	            WHERE product_shop.`id_shop` = '.(int)$context->shop->id.($type == 'mostview' ? ' AND pat.`name` = \'product\'' : '')
	            .($active ? ' AND product_shop.`active` = 1' : '')
	            .($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
	            .($id_supplier ? ' AND p.id_supplier = '.(int)$id_supplier : '')
	            .($categories ? ' AND cp.id_category IN (0, '.$categories.')' : '');
				
			if($type == 'mostview'){
				$sql .=' GROUP BY cnn.id_page';
				$sql .= ' ORDER BY pages DESC ';
			}elseif($type == 'toprating'){
				$sql .= ' GROUP BY product_shop.id_product ';
	        	$sql .= ' ORDER BY avg_grade DESC ';
	        }
	        $sql .=' LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n;
	        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
	        if (!$result)
	            return array();
	        /* Modify SQL result */
	        return Product::getProductsProperties($id_lang, $result);
	    }

	    public static function getNewProducts($categories, $id_lang, $page_number = 0, $nb_products = 10, $order_by = null, $order_way = null, Context $context = null)
		{
			if (!$context)
				$context = Context::getContext();

			$front = true;
			if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
				$front = false;

			if ($page_number < 0) $page_number = 0;
			if ($nb_products < 1) $nb_products = 10;
			if (empty($order_by) || $order_by == 'position') $order_by = 'date_add';
			if (empty($order_way)) $order_way = 'DESC';
			if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add'  || $order_by == 'date_upd')
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
					WHERE cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1').'
				)';
			}

			if (strpos($order_by, '.') > 0)
			{
				$order_by = explode('.', $order_by);
				$order_by_prefix = $order_by[0];
				$order_by = $order_by[1];
			}

			$sql = new DbQuery();
			$sql->select(
				'p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`link_rewrite`, pl.`meta_description`,
				pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`, MAX(image_shop.`id_image`) id_image, il.`legend`, m.`name` AS manufacturer_name,
				product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'" as new'
			);

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
			$sql->where('product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'"');
			
			if($categories)
				$sql->where('cpp.`id_category` IN (0, '.$categories.')');
			

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

			if (!$context) {
	            $context = Context::getContext();
	        }
	        if ($page_number < 0) {
	            $page_number = 0;
	        }
	        if ($nb_products < 1) {
	            $nb_products = 10;
	        }

	        // no group by needed : there's only one attribute with default_on=1 for a given id_product + shop
	        // same for image with cover=1
	        $sql = '
			SELECT
				p.id_product, IFNULL(product_attribute_shop.id_product_attribute,0) id_product_attribute, pl.`link_rewrite`, pl.`name`, pl.`description_short`, product_shop.`id_category_default`,
				image_shop.`id_image` id_image, il.`legend`,
				ps.`quantity` AS sales, p.`ean13`, p.`upc`, cl.`link_rewrite` AS category, p.show_price, p.available_for_order, IFNULL(stock.quantity, 0) as quantity, p.customizable,
				IFNULL(pa.minimal_quantity, p.minimal_quantity) as minimal_quantity, stock.out_of_stock,
				product_shop.`date_add` > "'.date('Y-m-d', strtotime('-'.(Configuration::get('PS_NB_DAYS_NEW_PRODUCT') ? (int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY')).'" as new,
				product_shop.`on_sale`, product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity
			FROM `'._DB_PREFIX_.'product_sale` ps
			LEFT JOIN `'._DB_PREFIX_.'product` p ON ps.`id_product` = p.`id_product`
			'.Shop::addSqlAssociation('product', 'p').'
			LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` product_attribute_shop
				ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop='.(int)$context->shop->id.')
			LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (product_attribute_shop.id_product_attribute=pa.id_product_attribute)
			LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
				ON p.`id_product` = pl.`id_product`
				AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
			LEFT JOIN `'._DB_PREFIX_.'image_shop` image_shop
				ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop='.(int)$context->shop->id.')
			LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
			LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
				ON cl.`id_category` = product_shop.`id_category_default`
				AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').Product::sqlStock('p', 0);

	        $sql .= '
			WHERE product_shop.`active` = 1
			'.($categories ? 'AND product_shop.`id_category_default` IN (0, '.$categories.')' : '').'
			AND p.`visibility` != \'none\'';

	        if (Group::isFeatureActive()) {
	            $groups = FrontController::getCurrentCustomerGroups();
	            $sql .= ' AND EXISTS(SELECT 1 FROM `'._DB_PREFIX_.'category_product` cp
					JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1').')
					WHERE cp.`id_product` = p.`id_product`)';
	        }

	        $sql .= '
			ORDER BY ps.quantity DESC
			LIMIT '.(int)($page_number * $nb_products).', '.(int)$nb_products;

	        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
	            return false;
	        }

	        return Product::getProductsProperties($id_lang, $result);
		}

		public static function getPricesDrop($categories, $id_lang, $page_number = 0, $nb_products = 10, $order_by = null, $order_way = null, $beginning = false, $ending = false, Context $context = null)
		{
			if (!$context) $context = Context::getContext();
			if ($page_number < 0) $page_number = 0;
			if ($nb_products < 1) $nb_products = 10;
			if (empty($order_by) || $order_by == 'position') $order_by = 'price';
			if (empty($order_way)) $order_way = 'DESC';
			if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add'  || $order_by == 'date_upd')
				$order_by_prefix = 'p';
			else if ($order_by == 'name')
				$order_by_prefix = 'pl';
			if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way))
				die (Tools::displayError());
			$current_date = date('Y-m-d H:i:s');
			$ids_product = self::_getProductIdByDate($categories, (!$beginning ? $current_date : $beginning), (!$ending ? $current_date : $ending), $context);

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
					WHERE cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1').'
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
						INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY
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
			'.((!$beginning && !$ending) ? ' AND p.`id_product` IN ('.((is_array($tab_id_product) && count($tab_id_product)) ? implode(', ', $tab_id_product) : 0).')' : '').'
			'.$sql_groups.'
			GROUP BY product_shop.id_product
			ORDER BY '.(isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '').pSQL($order_by).' '.pSQL($order_way).'
			LIMIT '.(int)($page_number * $nb_products).', '.(int)$nb_products;

			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

			if (!$result)
				return false;

			if ($order_by == 'price')
				Tools::orderbyPrice($result, $order_way);

			return Product::getProductsProperties($id_lang, $result);
		}

		public static function _getProductIdByDate($categories, $beginning, $ending, Context $context = null, $with_combination = false)
		{
			if (!$context)
				$context = Context::getContext();

			$id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
			$ids = Address::getCountryAndState($id_address);
			$id_country = (int)($ids['id_country'] ? $ids['id_country'] : Configuration::get('PS_COUNTRY_DEFAULT'));

			return self::getProductIdByDate(
				$categories,
				$context->shop->id,
				$context->currency->id,
				$id_country,
				$context->customer->id_default_group,
				$beginning,
				$ending,
				0,
				$with_combination
			);
		}

		public static function getProductIdByDate($categories, $id_shop, $id_currency, $id_country, $id_group, $beginning, $ending, $id_customer = 0, $with_combination_id = false)
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
						'.($categories ? ' AND cp.`id_category` IN (0, '.$categories.')' : '').'
			', false);
			$ids_product = array();
			while ($row = Db::getInstance()->nextRow($result))
				$ids_product[] = $with_combination_id ? array('id_product' => (int)$row['id_product'], 'id_product_attribute' => (int)$row['id_product_attribute']) : (int)$row['id_product'];
			return $ids_product;
		}
	}
?>