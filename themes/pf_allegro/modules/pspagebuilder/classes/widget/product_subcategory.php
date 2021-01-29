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

class PsWidgetProduct_subcategory extends PsWidgetPageBuilder {

		public $name = 'product_subcategory';

		public  static function getWidgetInfo(){
			return array( 'label' => 'Display Product and Subcategories', 'explain' => 'Display Subcategories', 'group' => 'prestashop'  );
		}

		public static function renderButton(){

		}

		public function renderForm( $data ){
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
			
			$orders = array(
	            0 => array('value' => 'date_add', 'name' => $this->l('Date Add')),
	            1 => array('value' => 'date_add DESC', 'name' => $this->l('Date Add DESC')),
	            2 => array('value' => 'name', 'name' => $this->l('Name')),
	            3 => array('value' => 'name DESC', 'name' => $this->l('Name DESC')),
	            4 => array('value' => 'quantity', 'name' => $this->l('Quantity')),
	            5 => array('value' => 'quantity DESC', 'name' => $this->l('Quantity DESC')),
	            6 => array('value' => 'price', 'name' => $this->l('Price')),
	            7 => array('value' => 'price DESC', 'name' => $this->l('Price DESC'))
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
						'label' => $this->l('Sub Title'),
						'name' => 'subtitle',
						'default' => '',
						'lang' => true
					),
	                array(
	                    'type' => 'text',
	                    'label' => $this->l('Limit Subcategories'),
	                    'name' => 'limit_sub',
	                    'default'=> '6',
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Banner Image'),
	                    'name'  => 'imagefile',
	                    'class' => 'imageupload',
	                    'default'=> '',
	                    'id'	 => 'imagefile'.$key
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Banner URL'),
	                    'name'  => 'url',
	                    'default'=> '#',
	                    'lang' => true
	                ),
	                array(
	                    'type' => 'select',
	                    'label' => $this->l( 'Order By' ),
	                    'name' => 'order_by',
	                    'options' => array(
	                    	'query' => $orders ,
	                    	'id' => 'value',
                            'name' => 'name'
                        ),
	                    'default' => "date_add"
	                ),
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Limit'),
	                    'name'  => 'limit',
	                    'default'=> 6,
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
	                'fields_value' => $this->getConfigFieldsValues( $data  ),
	                'languages' => Context::getContext()->controller->getLanguages(),
	                'id_language' => $default_lang
        	);  

			$string = '
					<script type="text/javascript">
						$(".imageupload").WPO_Gallery({gallery:false} );
					</script>';
			return  '<div id="imageslist'.$key.'">'.$helper->generateForm( $this->fields_form ) .$string."</div>";
		}

		public function renderContent($setting)
		{
			$t  = array(
				'id_parent' => '',
				'limit_sub' => 6,
				'imagefile' => '',
				'url' => '#',
				'limit' => 6,
				'itemsperpage' => 4,
				'columns' => 4,
				'order_by' => 'date_add DESC',
				'rows' => 1,
				'list_mode' => 'grid',
				'display_mode' => 'carousel',
				'nbr_desktops' => 4,
				'nbr_tablets' => 2,
				'nbr_mobile' => 1,
				'subtitle' => '',
			);

			$setting = array_merge( $t, $setting );
			$setting['id_category'] = $setting['id_parent'];
			$porder = preg_split("#\s+#", $setting['order_by']);
            if (!isset($porder[1])) {
                $porder[1] = null;
            }
			$context = Context::getContext();
			$languageID = $context->language->id;
			$setting['subtitle'] = isset($setting['subtitle_'.$languageID]) ? ($setting['subtitle_'.$languageID]) : '';
			if ($setting['id_parent']) {
				$obj = new Category($setting['id_parent'], $context->language->id);
				$products = $obj->getProducts($context->language->id, 0, $setting['limit'], null, null, false);
				$setting['products'] = $products;

				$subcategories = self::getSubCategories($setting['id_parent'], $setting['limit_sub'], $context->language->id);
				$setting['subcategories'] = $subcategories;
				$setting['imageurl'] = '';
				if ($setting['imagefile'] && file_exists(_PAGEBUILDER_IMAGE_DIR_.$setting['imagefile'])) {
					$setting['imageurl'] = _PAGEBUILDER_IMAGE_URL_.$setting['imagefile'];
				}
				$setting['url'] = isset($setting['url_'.$languageID]) ? ($setting['url_'.$languageID]) : '';
			}
			$setting['list_mode_tpl'] = $this->getProductListStyleFile($setting['list_mode'], $setting['product_style']);

            $setting['wkey'] = rand(0,time());
			//d($setting);
			$output = array('type'=>'product_subcategory', 'data' => $setting);

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

	}
?>