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

class PsPagebuilderHelper {

	public static function clearUnexpected($string)
	{
		return preg_replace('#!s:(\d+):"(.*?)";!e#', "'s:'.strlen('$2').':\"$2\";'", $string);
	}

	/**
	 * Execute modules for specified hook
	 *
	 * @param string $hook_name Hook Name
	 * @param array $hook_args Parameters for the functions
	 * @param int $id_module Execute hook for this module only
	 * @return string modules output
	 */
	public static function moduleExec($hook_name, $modulename, $hook_args = array(),
					$id_module = null, $array_return = false, $use_push = false, $id_shop = null)
	{
		static $disable_non_native_modules = null;

		$retro_hook_name = Hook::getRetroHookName($hook_name);
		// Look on modules list
		$altern = 0;
		$output = '';
		if ($disable_non_native_modules && !isset(Hook::$native_module))
			Hook::$native_module = Module::getNativeModuleList();

		$different_shop = false;
		$context = Context::getContext();
		if ($id_shop !== null && Validate::isUnsignedId($id_shop) && $id_shop != $context->shop->getContextShopID())
		{
			$old_context = $context->shop->getContext();
			$old_shop = clone $context->shop;
			$shop = new Shop((int)$id_shop);
			if (Validate::isLoadedObject($shop))
			{
				$context->shop = $shop;
				$context->shop->setContext(Shop::CONTEXT_SHOP, $shop->id);
				$different_shop = true;
			}
		}

		$module_list = array();

		$module_list[] = array('module' => $modulename, 'id_module' => 0);

		$live_edit = false;

		foreach ($module_list as $array)
		{
			$array['live_edit'] = false;
			// Check errors
			if ($id_module && $id_module != $array['id_module'])
				continue;

			if ((bool)$disable_non_native_modules && Hook::$native_module && count(Hook::$native_module) && !in_array($array['module'], self::$native_module))
				continue;

			if (!($module_instance = Module::getInstanceByName($array['module'])))
				continue;

			if ($use_push && !$module_instance->allow_push)
				continue;

			$hook_callable = is_callable(array($module_instance, 'hook'.$hook_name));
			$hook_retro_callable = is_callable(array($module_instance, 'hook'.$retro_hook_name));

			if (($hook_callable || $hook_retro_callable) && Module::preCall($module_instance->name))
			{
				$hook_args['altern'] = ++$altern;

				if ($use_push && isset($module_instance->push_filename) && file_exists($module_instance->push_filename))
					Tools::waitUntilFileIsModified($module_instance->push_filename, $module_instance->push_time_limit);

				// Call hook method
				if ($hook_callable)
					$display = $module_instance->{'hook'.$hook_name}($hook_args);
				elseif ($hook_retro_callable)
					$display = $module_instance->{'hook'.$retro_hook_name}($hook_args);

				if (!$array_return && $array['live_edit'] && Tools::isSubmit('live_edit') && Tools::getValue('ad') &&
								Tools::getValue('liveToken') == Tools::getAdminToken('AdminModulesPositions'.
												(int)Tab::getIdFromClassName('AdminModulesPositions').(int)Tools::getValue('id_employee')))
				{
					$live_edit = true;
					$output .= Hook::wrapLiveEdit($display, $module_instance, $array['id_hook']);
				}
				else if ($array_return)
					$output[$module_instance->name] = $display;
				else
					$output .= $display;
			}
		}

		if ($different_shop)
		{
			$context->shop = $old_shop;
			$context->shop->setContext($old_context, $shop->id);
		}

		if ($array_return)
			return $output;
		else
			return ($live_edit ? '<script type="text/javascript">hooks_list.push(\''.$hook_name.'\');</script>
				<div id="'.$hook_name.'" class="dndHook" style="min-height:50px">' : '').$output.($live_edit ? '</div>' : '');
	}

	public static function detectSfxClasses()
	{
		$pagestyle = __PS_BASE_URI__.'modules/pspagebuilder/views/css/pagebuilder.css';
		$tcss = _PS_THEME_DIR_.'css/modules/pspagebuilder/views/css/pagebuilder.css';

		if (file_exists($tcss))
			$content = Tools::file_get_contents($tcss);
		else
			$content = Tools::file_get_contents(Context::getContext()->link->getMediaLink($pagestyle));

		$captions = array('col' => array(), 'row' => array());

		preg_match_all('#\.pts-col\.(\w+)\s*{\s*#', $content, $matches);
		if (isset($matches[1]))
			$captions['col'] = $matches[1];

		preg_match_all('#\.pts-row\.(\w+)\s*{\s*#', $content, $matches);
		if (isset($matches[1]))
			$captions['row'] = $matches[1];

		return $captions;
	}


	public static function detectSfxClassesByStyle( $classpattern )
	{
		$pagestyle = __PS_BASE_URI__.'modules/pspagebuilder/views/css/pagebuilder.css';
		$tcss = _PS_THEME_DIR_.'css/modules/pspagebuilder/views/css/pagebuilder.css';

		if (file_exists($tcss))
			$content = Tools::file_get_contents($tcss);
		else
			$content = Tools::file_get_contents(Context::getContext()->link->getMediaLink($pagestyle));

	

		preg_match_all( $classpattern , $content, $matches);	 
		if (isset($matches[1])){
			$css = array();

			$css[] = array( 'name' => "---", 'class' => '' );

			foreach( $matches[1] as $style ){
				$css[] = array( 'name' => Tools::ucfirst($style), 'class' => 'calltoaction-'.$style );
 			}
 			return $css;
		}



		 return array();
	}



	public static function detectWidgetClasses()
	{
		$pagestyle = __PS_BASE_URI__.'modules/pspagebuilder/views/css/pagebuilder.css';
		$tcss = _PS_THEME_DIR_.'css/modules/pspagebuilder/views/css/pagebuilder.css';

		if (file_exists($tcss))
			$content = Tools::file_get_contents(Context::getContext()->link->getMediaLink(_THEME_DIR_.'css/modules/pspagebuilder/views/css/pagebuilder.css'));
		else
			$content = Tools::file_get_contents(Context::getContext()->link->getMediaLink($pagestyle));

		$captions = array('widget' => array());

		preg_match_all('#\.widget\.(\w+)\s*{\s*#', $content, $matches);
		if (isset($matches[1]))
		{
			foreach ($matches[1] as $class)
			{
				$id = $class == 'default' ? '' : $class;
				$captions['widget'][] = array('name' => $class, 'class' => $id);
			}
		}

		return $captions;
	}

	public static function mergeColData($col)
	{
		$col->attrs = '';

		$styles = array();
		if ($col->bgcolor)
			$styles[] = 'background-color:'.$col->bgcolor;

		if (isset($col->bgimage) && $col->bgimage)
		{
			$col->bgimage = _PAGEBUILDER_IMAGE_URL_.$col->bgimage;
			$styles[] = ' background-image:url(\''.$col->bgimage.'\') ';
		}

		if( isset($col->margin) && !empty($col->margin) ){
			$styles[] = ' margin:'.$col->margin;
		}

		if( isset($col->padding) && !empty($col->padding) ){
			$styles[] = ' padding:'.$col->padding;
		}
		
 		

		$col->attrs = 'style="'.implode(';', $styles).'"';

		return $col;
	}

	public static function mergeRowData($row)
	{
		$row->attrs = '';
		$styles = array();
		if ($row->bgcolor)
			$styles[] = 'background-color:'.$row->bgcolor;

		if (isset($row->bgimage) && $row->bgimage)
		{
			$row->bgimage = _PAGEBUILDER_IMAGE_URL_.$row->bgimage;
			$styles[] = ' background-image:url(\''.$row->bgimage.'\') ';
		}
	

		if( isset($row->margin) && !empty($row->margin) ){
			$styles[] = ' margin:'.$row->margin;
		}

		if( isset($row->padding) && !empty($row->padding) ){
			$styles[] = ' padding:'.$row->padding;
		}
		
		$row->attrs = 'style="'.implode(';', $styles).'"';
		return $row;
	}

	public static function addAdminMedia($file, $type = 'css')
	{
		$filepath = __PS_BASE_URI__.'modules/pspagebuilder/views/'.$type.'/admin/'.$file;
		if (file_exists(_PS_THEME_DIR_.'modules/pspagebuilder/views/'.$type.'/admin/'.$file))
			$filepath = _PS_THEME_DIR_.'modules/pspagebuilder/views/'.$type.'/admin/'.$file;
		if ($type == 'css')
			Context::getContext()->controller->addCSS($filepath);
		else
			Context::getContext()->controller->addJS($filepath);
	}

}
