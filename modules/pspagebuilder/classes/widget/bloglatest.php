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

class PsWidgetBloglatest extends PsWidgetPageBuilder {

	public $name = 'bloglatest';

	public static function getWidgetInfo()
	{
		return array('label' => 'Blog Latest', 'explain' => 'Integrate with Leo Blog Module to get blogs', 'group' => 'blog');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();
		$lists = array(
			array('value' => 'list', 'text' => $this->l('List')),
			array('value' => 'grid', 'text' => $this->l('Grid'))
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
					'label' => $this->l('Blogs to display.'),
					'name' => 'nbr',
					'desc' => $this->l('Define the number of blogs displayed in this block.'),
					'default' => '8'
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
					'type' => 'text',
					'label' => $this->l('Image Blog Width'),
					'name' => ('width'),
					//'class' => 'fixed-width-xs',
					'desc' => $this->l('Define the width of images displayed in this block.'),
					'default' => '280'
				),
				array(
					'type' => 'text',
					'label' => $this->l('Image Blog Height.'),
					'name' => ('height'),
					//'class' => 'fixed-width-xs',
					'desc' => $this->l('Define the height of images displayed in this block.'),
					'default' => '240'
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Show View All'),
					'name' => ('show'),
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
					'default' => '1'
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Show Image'),
					'name' => ('show_image'),
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
					'default' => '1'
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Show Title'),
					'name' => ('show_title_blog'),
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
					'default' => '1'
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Show Category'),
					'name' => ('show_category'),
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
					'default' => '0'
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Show Date Add'),
					'name' => ('show_dateadd'),
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
					'default' => '1'
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Show Comment'),
					'name' => ('show_comment'),
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
					'default' => '0'
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Show Description'),
					'name' => ('show_description'),
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
					'default' => '1'
				),
				array(
					'type' => 'switch',
					'label' => $this->l('Show Read more'),
					'name' => ('show_readmore'),
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
					'default' => '0'
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
			'name' => '',
			'html' => '',
			'height' => 130,
			'width' => 170,
			'nbr' => 6,
			'columns' => 4,
			'rows' => 1,
			'show' => 1,
			'show_image' => 1,
			'show_title_blog' => 1,
			'show_category' => 0,
			'show_dateadd' => 1,
			'show_comment' => 0,
			'show_description' => 1,
			'show_readmore' => 0,
			'list_mode' => 'grid',
			'display_mode' => 'carousel',
			'nbr_desktops' => 4,
			'nbr_tablets' => 2,
			'nbr_mobile' => 1,
			'class_widget' => 'bloglatest',
		);

		$setting = array_merge($t, $setting);

		if (file_exists(_PS_MODULE_DIR_.'leoblog/classes/config.php'))
		{
			require_once(_PS_MODULE_DIR_.'leoblog/loader.php');
			$authors = array();
			$config = LeoBlogConfig::getInstance();

			$config->setVar('blockpts_blogs_height', $setting['height']);
			$config->setVar('blockpts_blogs_width', $setting['width']);
			$config->setVar('blockpts_blogs_limit', $setting['nbr']);
			$config->setVar('blockpts_blogs_col', $setting['columns']);
			$config->setVar('blockpts_blogs_show', $setting['show']);

			$limit = (int)$config->get('blockpts_blogs_limit', 6);

			$blogs = LeoBlogBlog::getListBlogs(null, $this->lang_id, 0, $limit, 'date_add', 'DESC', array(), true);
			$helper = LeoBlogHelper::getInstance();

			$image_w = (int)$config->get('blockpts_blogs_width', 170);
			$image_h = (int)$config->get('blockpts_blogs_height', 130);

			$link = LeoBlogHelper::getInstance()->getFontBlogLink();

			foreach ($blogs as $key => $blog) {
				$blog = LeoBlogHelper::buildBlog($helper, $blog, $image_w, $image_h, $config);
				if ($blog['id_employee']) {
					if (!isset($authors[$blog['id_employee']])) {
						$authors[$blog['id_employee']] = new Employee($blog['id_employee']);
					}

					$blog['author'] = $authors[$blog['id_employee']]->firstname.' '.$authors[$blog['id_employee']]->lastname;
					$blog['author_link'] = $helper->getBlogAuthorLink($authors[$blog['id_employee']]->id);
				} else {
					$blog['author'] = '';
					$blog['author_link'] = '';
				}
				$blogs[$key] = $blog;
			}

			$columnspage = (int)$config->get('blockpts_blogs_col', 3);
			$setting['blogs'] = $blogs;
			$setting['config'] = $config;
			$setting['view_all_link'] = $link;

			$setting['columnspage'] = $columnspage;
			$setting['modid'] = time();
			$setting['tabname'] = rand() + $setting['modid'];

			$list_mode_tpl = _PS_MODULE_DIR_.'/pspagebuilder/views/templates/front/widgets/sub/item_blog_'.$setting['list_mode'].'.tpl';
			$tlist_mode_tpl = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/modules/pspagebuilder/views/templates/front/widgets/sub/item_blog_'.$setting['list_mode'].'.tpl';
			if (file_exists($tlist_mode_tpl)) {
				$list_mode_tpl = $tlist_mode_tpl;
			}
			$setting['list_mode_tpl'] = $list_mode_tpl;

			$output = array('type' => 'bloglatest', 'data' => $setting);
			return $output;
		}
	}
}