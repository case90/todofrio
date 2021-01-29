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

require_once(_PS_MODULE_DIR_.'pspagebuilder/loader.php');

class AdminPspagebuilderImageController extends ModuleAdminController {

	protected $max_image_size = null;
	public $theme_name;
	public $img_path;
	public $img_url;

	public function __construct()
	{
		$this->bootstrap = true;
		$this->max_image_size = (int)Configuration::get('PS_PRODUCT_PICTURE_MAX_SIZE');
		$this->theme_name = Context::getContext()->shop->getTheme();
		$this->img_path = _PAGEBUILDER_IMAGE_DIR_;
		$this->img_url = _PAGEBUILDER_IMAGE_URL_;
		parent::__construct();
	}

	public function setMedia()
	{
		$this->addCss(__PS_BASE_URI__.str_replace('//', '/', 'modules/pspagebuilder').'/views/css/admin/image.css', 'all');
		return parent::setMedia();
	}

	public function postProcess()
	{
		if (($img_name = Tools::getValue('imgName', false)) !== false)
			unlink($this->img_path.$img_name);

		parent::postProcess();
	}

	/**
	 * renderForm contains all necessary initialization needed for all tabs
	 *
	 * @return void
	 */
	public function renderList()
	{
		$tpl = $this->createTemplate('imagesmanagement.tpl');
		$sort_by = Tools::getValue('sortBy');
		$reload_slider_image = Tools::getValue('reloadSliderImage');
		$images = $this->getImageList($sort_by);
		$tpl->assign(array(
			'images' => $images,
			'reloadSliderImage' => $reload_slider_image,
		));
		if ($reload_slider_image)
			die(Tools::jsonEncode($tpl->fetch()));

		$image_uploader = new HelperImageUploader('file');
		$image_uploader->setSavePath($this->img_path);
		$image_uploader->setMultiple(true)->setUseAjax(true)->setUrl(Context::getContext()->link->getAdminLink('AdminPspagebuilderImage').
						'&ajax=1&action=addSliderImage');

		$tpl->assign(array(
			'countImages' => count($images),
			'images' => $images,
			'max_image_size' => $this->max_image_size / 1024 / 1024,
			'image_uploader' => $image_uploader->render(),
			'imgManUrl' => Context::getContext()->link->getAdminLink('AdminPspagebuilderImage'),
			'token' => $this->token,
			'imgUploadDir' => $this->img_path,
			'add_cls' => Tools::getValue('modal') ? 'modalshowed' : ''
		));

		return $tpl->fetch();
	}

	public function ajaxProcessRenderList()
	{
		return $this->renderList();
	}

	public function getImageList($sort_by)
	{
		$path = $this->img_path;
		$images = glob($path.'/{*.jpeg,*.JPEG,*.jpg,*.JPG,*.gif,*.GIF,*.png,*.PNG}', GLOB_BRACE);

		if ($sort_by == 'name_desc')
			rsort($images);
		if ($sort_by == 'date' || $sort_by == 'date_desc')
			array_multisort(array_map('filemtime', $images), SORT_NUMERIC, SORT_DESC, $images);
		if ($sort_by == 'date_desc')
			rsort($images);

		$result = array();
		foreach ($images as &$file)
		{
			$file_info = pathinfo($file);
			$result[] = array('name' => $file_info['basename'], 'link' => $this->img_url.$file_info['basename']);
		}
		return $result;
	}

	public function ajaxProcessaddSliderImage()
	{
		if (isset($_FILES['file']))
		{
			$image_uploader = new HelperUploader('file');
			$image_uploader->setSavePath($this->img_path);
			$image_uploader->setAcceptTypes(array('jpeg', 'gif', 'png', 'jpg'))->setMaxSize($this->max_image_size);
			$files = $image_uploader->process();
			$total_errors = array();

			foreach ($files as &$file)
			{
				$errors = array();
				// Evaluate the memory required to resize the image: if it's too much, you can't resize it.
				if (!ImageManager::checkImageMemoryLimit($file['save_path']))
					$errors[] = Tools::displayError('Due to memory limit restrictions, this image cannot be loaded.
									Please increase your memory_limit value via your server\'s configuration settings.');

				if (count($errors))
					$total_errors = array_merge($total_errors, $errors);

				//unlink($file['save_path']);
				//Necesary to prevent hacking
				unset($file['save_path']);
				//Add image preview and delete url
			}

			if (count($total_errors))
				$this->context->controller->errors = array_merge($this->context->controller->errors, $total_errors);

			$images = $this->getImageList('date');
			$tpl = $this->createTemplate('imagesmanagement.tpl');
			$tpl->assign(array(
				'images' => $images,
				'reloadSliderImage' => 1,
				'link' => Context::getContext()->link
			));

			die(Tools::jsonEncode($tpl->fetch()));
		}
	}

}
