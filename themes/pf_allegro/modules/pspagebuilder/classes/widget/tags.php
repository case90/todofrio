<?php
/**
 * Pts Prestashop Theme Framework for Prestashop 1.6.x
 *
 * @package   pspagebuilder
 * @version   5.0
 * @author    http://www.Prestabrain.com
 * @copyright Copyright (C) October 2013 Prestabrain.com <@emai:Prestabrain@gmail.com>
 *               <info@Prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

class PsWidgetTags extends PsWidgetPageBuilder {

		public $name = 'tags';

	

		public  static function getWidgetInfo(){
			return array( 'label' => 'Tags Block', 'explain' => 'Create Tags Block', 'group' => 'prestashop'  );
		}

		public static function renderButton(){

		}

		public function renderForm( $data ){
			$helper = $this->getFormHelper();

			$this->fields_form[1]['form'] = array(
	            'legend' => array(
	                'title' => $this->l('Widget Form.'),
	            ),
	            'input' => array(
	                
	                array(
	                    'type'  => 'text',
	                    'label' => $this->l('Displayed tags'),
	                    'name'  => 'tags_nbr',
	                    'default'=> '10'
	                ),	 
	 				array(
	                    'type'  => 'text',
	                    'label' => $this->l('Tags levels'),
	                    'name'  => 'max_level',
	                    'default'=> '3',
	                    'desc' => $this->l('Set the number of different tags levels you would like to use. (default: 3)')
	                ),
	                array(
                    	'type' => 'switch',
                    	'label' => $this->l('Random display'),
                    	'name' => 'randomize',
                    	'class' => 'fixed-width-xs',
                    	'desc' => $this->l('If enabled, displays tags randomly. By default, random display is disabled and the most used tags are displayed first.'),
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
                    	'default' => false
                    )	
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
			return  $helper->generateForm( $this->fields_form );

		}
		public function renderContent(  $setting ){
			
			$t  = array(
				'tags_nbr'=> '10',
				'max_level'   => '3',
				'randomize' => false
			);
			$setting = array_merge( $t, $setting );

			$tags = Tag::getMainTags((int)(Context::getContext()->language->id), (int)($t['tags_nbr']));

			$max = -1;
			$min = -1;
			foreach ($tags as $tag)
			{
				if ($tag['times'] > $max)
					$max = $tag['times'];
				if ($tag['times'] < $min || $min == -1)
					$min = $tag['times'];
			}

			if ($min == $max)
				$coef = $max;
			else
				$coef = ($t['max_level'] - 1) / ($max - $min);

			if (count($tags))
			{
				if ($t['randomize'])
					shuffle($tags);
				foreach ($tags as &$tag)
					$tag['class'] = 'tag_level'.(int)(($tag['times'] - $min) * $coef + 1);
			}
			$setting['tags'] = $tags;
			
			$output = array('type' => 'tags','data' => $setting );

	  		return $output;
		}
		 
	}
?>