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

class PsWidgetCategoriestabs extends PsWidgetPageBuilder {

	public $name = 'categoriestabs';
	public $group = 'product';

	public static function getWidgetInfo()
	{
		return array('label' => ('Categories Tabs'), 'explain' => 'Dislay Categories Tabs', 'group' => 'prestashop');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();

		$this->fields_form[1]['form'] = array(
			'input' => array(
				array(
					'type' => 'category_tab',
					'label' => 'Categories',
					'name' => 'categorytab',
					'default' => '',
				),
				array(
					'type' => 'categoryBox',
					'label' => 'Categories',
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

		$orders = array(
			array('value' => 'date_add', 'name' => $this->l('Date Add')),
			array('value' => 'date_add DESC', 'name' => $this->l('Date Add DESC')),
			array('value' => 'name', 'name' => $this->l('Name')),
			array('value' => 'name DESC', 'name' => $this->l('Name DESC')),
			array('value' => 'quantity', 'name' => $this->l('Quantity')),
			array('value' => 'quantity DESC', 'name' => $this->l('Quantity DESC')),
			array('value' => 'price', 'name' => $this->l('Price')),
			array('value' => 'price DESC', 'name' => $this->l('Price DESC'))
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
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'category_tab',
					'label' => $this->l('Categories'),
					'name' => 'categorytab',
					'category_tpl' => $category_tpl,
					'default' => '',
				),
				array(
					'type' => 'categoryBox',
					'label' => '',
					'name' => 'categoryBox',
					'default' => '',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Limit'),
					'name' => 'limit',
					'default' => 6,
				),
				array(
					'type' => 'select',
					'label' => $this->l('Order By'),
					'name' => 'order_by',
					'options' => array('query' => $orders,
						'id' => 'value',
						'name' => 'name'),
					'default' => 'date_add DESC'
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

		$fields_value = $this->getConfigFieldsValues($data);
		$selected_cat = $values['categoryBox'];
		$fields_value['categoryBox'] = $values['categoryBox'] ? explode(',', $values['categoryBox']) : array();
		$fields_value['categorytab'] = $values['categorytab'] ? Tools::jsonDecode($values['categorytab'], true) : '';

		$helper->tpl_vars = array(
			'fields_value' => $fields_value,
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
	/**
	 *
	 */
	public function renderContent($setting)
	{
		$t = array(
			'categorytab' => '',
			'categoryBox' => '',
			'limit' => 6,
			'itemsperpage' => 4,
			'columns' => 4,
			'rows' => 1,
			'order_by' => 'date_add DESC',

			'list_mode' => 'grid',
			'display_mode' => 'carousel',
			'nbr_desktops' => 4,
			'nbr_tablets' => 2,
			'nbr_mobile' => 1,
			'class_widget' => 'categoriestabs',
		);

		$setting = array_merge($t, $setting);
		$porder = preg_split('#\s+#', $setting['order_by']);
		if (!isset($porder[1])) {
			$porder[1] = null;
		}

		$output = array();
		$context = Context::getContext();
		$categories = $setting['categoryBox'] ? explode(',', $setting['categoryBox']) : false;
		$categorytab = $setting['categorytab'] ? Tools::jsonDecode($setting['categorytab'], true) : array();

		if ($categories) {
			$tg = array();
			foreach ($categories as $id_category) {
				$obj = new Category($id_category, $context->language->id);
				$tg['category_info'] = isset($categorytab[$id_category]) ? $categorytab[$id_category] : '';

				if (is_file(_PAGEBUILDER_IMAGE_DIR_.$tg['category_info']['icon'])) {
					$tg['category_info']['icon'] = _PAGEBUILDER_IMAGE_URL_.$tg['category_info']['icon'];
				} else {
					$tg['category_info']['icon'] = '';
				}

				$tg['category_obj'] = $obj;
				$tg['products'] = $obj->getProducts($context->language->id, 0, $setting['limit'], $porder[0], $porder[1]);
				$output[] = $tg;
			}
		}
		$setting['list_mode_tpl'] = $this->getProductListStyleFile($setting['list_mode'], $setting['product_style']);
		$setting['categories_tabs'] = $output;

		$output = array('type' => 'categoriestabs', 'data' => $setting);
		return $output;
	}

	protected function renderImage($url, $image, $size)
	{
		$setting = array();
		$setting['thumbnailurl'] = _PAGEBUILDER_IMAGE_URL_.$image;
		$setting['imageurl'] = _PAGEBUILDER_IMAGE_URL_.$image;
		if (count($size) == 2) {
			$cache = _PS_CACHE_DIR_.'pspagebuilder/';
			if (!file_exists($cache.$image)) {
				if (!is_dir($cache)) {
					mkdir($cache, 0755);
				}
				if (ImageManager::resize(_PAGEBUILDER_IMAGE_DIR_.$image, $cache.$image, $size[0], $size[1])) {
					$setting['thumbnailurl'] = $url.'cache/pspagebuilder/'.$image;
				}
			} else {
				$setting['thumbnailurl'] = $url.'cache/pspagebuilder/'.$image;
			}
		}
		return $setting;
	}

}
