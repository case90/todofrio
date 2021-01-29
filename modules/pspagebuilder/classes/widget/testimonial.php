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

class PsWidgetTestimonial extends PsWidgetPageBuilder {

	public $name = 'testimonial';

	public static function getWidgetInfo()
	{
		return array('label' => 'Testimonials', 'explain' => 'Integrate with Testimonial Module to show testimonials', 'group' => 'prestabrain');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();

		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues($data),
			'languages' => Context::getContext()->controller->getLanguages(),
			'id_language' => $default_lang
		);

		$module = Module::getInstanceByName('ptsbttestimonials');
		if (!$module || (isset($module->id) && (!$module->id || !$module->active)))
		{
			$this->fields_form[1]['form'] = array(
				'legend' => array(
					'title' => $this->l('Widget Form.'),
					'desc' => $this->l('You need install or active the module ptsbttestimonials before')
				),
			);
			return $helper->generateForm($this->fields_form);
		}
		$positions = array(
			array('id' => 'left', 'name' => $this->l('Left')),
			array('id' => 'center', 'name' => $this->l('Center')),
			array('id' => 'right', 'name' => $this->l('Right')),
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
					'type' => 'select',
					'label' => $this->l('Testimonial Position'),
					'name' => 'testimonial_position',
					'options' => array('query' => $positions,
						'id' => 'id',
						'name' => 'name'),
					'default' => 'center',
					'desc' => $this->l('Apply for Testimonial Style: V1 annd V3')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Limit'),
					'name' => 'testimonial_limit',
					'class' => 'testimonial_limit',
					'default' => '6'
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
			'testimonial_limit' => 6,
			'testimonial_position' => 'center',
			'columns' => 4,
			'rows' => 1,
			'list_mode' => 'grid',
			'display_mode' => 'carousel',
			'nbr_desktops' => 4,
			'nbr_tablets' => 2,
			'nbr_mobile' => 1,
			'class_widget' => 'testimonial',
		);

		$setting = array_merge($t, $setting);

		$module = Module::getInstanceByName('ptsbttestimonials');
		if (!$module || (isset($module->id) && (!$module->id || !$module->active)))
		{
			$output = array('type' => 'testimonial', 'data' => $setting);
			return $output;
		}
		$testimonials = $module->getTestimonials(true, $setting['testimonial_limit']);
		$setting['testimonials'] = $testimonials;
		$setting['testimonial_img_link'] = _MODULE_DIR_.'ptsbttestimonials/views/img/';
		$setting['testimonial_key'] = rand(0, 1000);

		$list_mode_tpl = _PS_MODULE_DIR_.'/pspagebuilder/views/templates/front/widgets/sub/item_testimonial_'.$setting['list_mode'].'.tpl';
		$tlist_mode_tpl = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/modules/pspagebuilder/views/templates/front/widgets/sub/item_testimonial_'.$setting['list_mode'].'.tpl';
		if (file_exists($tlist_mode_tpl)) {
			$list_mode_tpl = $tlist_mode_tpl;
		}
		$setting['list_mode_tpl'] = $list_mode_tpl;

		$output = array('type' => 'testimonial', 'data' => $setting);
		return $output;
	}

}
