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

class PsWidgetProductrecommended extends PsWidgetPageBuilder {

	public $name = 'productrecommended';
	public $group = 'product';

	public static function getWidgetInfo()
	{
		return array('label' => ('Product recommended'), 'explain' => 'Product recommended', 'group' => 'prestashop');
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
					'label' => $this->l('Product IDs'),
					'name' => 'product_ids',
					'default' => '1,2,3',
					'desc' => $this->l('Enter Products Id Eg: 1,2,3')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Limit'),
					'name' => 'limit',
					'default' => 6,
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
					'label' => $this->l('Display Mode'),
					'name' => 'display_mode',
					'options' => array('query' => $modes,
						'id' => 'value',
						'name' => 'text'),
					'default' => 'carousel',
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
			'product_ids' => '1,2,3',
			'limit' => 6,
			'columns' => 4,
			'rows' => 1,
			'list_mode' => 'grid',
			'display_mode' => 'carousel',
			'nbr_desktops' => 4,
			'nbr_tablets' => 2,
			'nbr_mobile' => 1,
			'class_widget' => 'productrecommended',
		);
		$setting = array_merge($t, $setting);
		$language_id = Context::getContext()->language->id;
		$setting['subtitle'] = isset($setting['subtitle_'.$language_id]) ? ($setting['subtitle_'.$language_id]) : '';
		$product_ids = $setting['product_ids'];
		$fproducts = array();
		if ($product_ids) {
			$product_ids = explode(',', $product_ids);
			$products = $this->getProducts($product_ids, 1, $setting['limit'], true, $this->context);
			if ($products) {
				$mproducts = array();
				foreach ($products as $product) {
					$mproducts[$product['id_product']] = $product;
				}
				foreach ($product_ids as $id_product) {
					if (isset($mproducts[$id_product])) {
						$fproducts[] = $mproducts[$id_product];
					}
				}
			}
		}
		$setting['products'] = $fproducts;
		
		$setting['list_mode_tpl'] = $this->getProductListStyleFile($setting['list_mode'], $setting['product_style']);
		$output = array('type' => 'productrecommended', 'data' => $setting);
		return $output;
	}

	public static function getProducts($product_ids, $p = 1, $n, $active = true, Context $context = null)
	{
		if (!$context)
			$context = Context::getContext();
		$id_lang = $context->language->id;

		$front = true;
		if (!in_array($context->controller->controller_type, array('front', 'modulefront')))
			$front = false;

		if ($p < 1)
			$p = 1;

		$sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) AS quantity'.
					(Combination::isFeatureActive() ? ', IFNULL(product_attribute_shop.id_product_attribute, 0) AS id_product_attribute,
					product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity' : '').', 
						pl.`description`, pl.`description_short`, pl.`available_now`,
					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, 
					pl.`meta_title`, pl.`name`, image_shop.`id_image` id_image,
					il.`legend` as legend, m.`name` AS manufacturer_name, cl.`name` AS category_default,
					DATEDIFF(product_shop.`date_add`, DATE_SUB("'.date('Y-m-d').' 00:00:00",
					INTERVAL '.(int)Configuration::get('PS_NB_DAYS_NEW_PRODUCT').' DAY)) > 0 AS new, product_shop.price AS orderprice
				FROM `'._DB_PREFIX_.'category_product` cp
				LEFT JOIN `'._DB_PREFIX_.'product` p
					ON p.`id_product` = cp.`id_product`
				'.Shop::addSqlAssociation('product', 'p').
						(Combination::isFeatureActive() ? ' LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` product_attribute_shop
				ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 
					AND product_attribute_shop.id_shop='.(int)$context->shop->id.')' : '').'
				'.Product::sqlStock('p', 0).'
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
					ON (product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
					ON (p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'image_shop` image_shop
					ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop='.(int)$context->shop->id.')
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il
					ON (image_shop.`id_image` = il.`id_image`
					AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m
					ON m.`id_manufacturer` = p.`id_manufacturer`
				WHERE product_shop.`id_shop` = '.(int)$context->shop->id
						.($active ? ' AND product_shop.`active` = 1' : '')
						.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '')
						.($product_ids ? ' AND p.id_product IN (0, '.pSQL(implode(',', $product_ids)).')' : '')
						.' GROUP BY cp.id_product';

		if ($n)
			$sql .= ' LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n;
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql, true, false);

		if (!$result)
			return array();

		/* Modify SQL result */
		return Product::getProductsProperties($id_lang, $result);
	}

}
