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

class PsWidgetNewsletter extends PsWidgetPageBuilder {

	public $name = 'map';

	const GUEST_NOT_REGISTERED = -1;
	const CUSTOMER_NOT_REGISTERED = 0;
	const GUEST_REGISTERED = 1;
	const CUSTOMER_REGISTERED = 2;
	
	public static function getWidgetInfo()
	{

		return array('label' => 'Newsletter Form',
			'explain' => 'Create Newsletter Form Working With Newsletter Block Of Prestashop.', 'group' => 'prestashop');
	}

	public function renderForm($data)
	{
		$helper = $this->getFormHelper();

		$key = time();
		$this->fields_form[1]['form'] = array(
			'legend' => array(
				'title' => $this->l('Widget Form.'),
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Css Class'),
					'name' => 'class',
					'default' => 'pts-newsletter',
				),
				array(
					'type' => 'text',
					'label' => $this->l('Image File'),
					'name' => 'imagefile',
					'class' => 'imageupload',
					'default' => '',
					'id' => 'imagefile'.$key,
					'desc' => 'Put image folder in the image folder ROOT_SHOP_DIR/img/'
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Information'),
					'name' => 'information',
					'cols' => 20,
					'rows' => 10,
					'value' => true,
					'lang' => true,
					'default' => 'Sign up to our newsletter and get exclusive 
						deals you wont find anywhere else straight to your inbox!',
					'autoload_rte' => true,
				)
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
				</script>
			';
		return $helper->generateForm($this->fields_form).$string;
	}
	
	public function renderContent($setting)
	{
		$class = '';
		$alert = $this->newsletterRegistration();

		if(isset($this->error)) {
			$class = 'warning_inline';
		}elseif(isset($this->valid)) {
			$class = 'success_inline';
		}

		$t = array(
			'class' => 'pts-newsletter',
			'imagefile' => '',
			'alert' => $alert,
			'classalert' => $class
		);
		$setting = array_merge($t, $setting);

		$language_id = $this->lang_id;
		$setting['information'] = isset($setting['information_'.$language_id])
						? html_entity_decode($setting['information_'.$language_id], ENT_QUOTES, 'UTF-8') : '';

		$setting['background'] = _PAGEBUILDER_IMAGE_URL_.$setting['imagefile'];
		$output = array('type' => 'newsletter', 'data' => $setting);
		return $output;
	}
	/**
	 * Check if this mail is registered for newsletters
	 *
	 * @param string $customer_email
	 *
	 * @return int -1 = not a customer and not registered
	 *                0 = customer not registered
	 *                1 = registered in block
	 *                2 = registered in customer
	 */
	public function isNewsletterRegistered($customer_email)
	{
		$sql = 'SELECT `email`
				FROM '._DB_PREFIX_.'newsletter
				WHERE `email` = \''.pSQL($customer_email).'\'
				AND id_shop = '.$this->context->shop->id;

		if (Db::getInstance()->getRow($sql))
			return self::GUEST_REGISTERED;

		$sql = 'SELECT `newsletter`
				FROM '._DB_PREFIX_.'customer
				WHERE `email` = \''.pSQL($customer_email).'\'
				AND id_shop = '.$this->context->shop->id;

		if (!$registered = Db::getInstance()->getRow($sql))
			return self::GUEST_NOT_REGISTERED;

		if ($registered['newsletter'] == '1')
			return self::CUSTOMER_REGISTERED;

		return self::CUSTOMER_NOT_REGISTERED;
	}

	/**
	 * Register in block newsletter
	 */
	protected function newsletterRegistration()
	{

		if (!Tools::getValue('email') || !Validate::isEmail(Tools::getValue('email')))
			return $this->error = $this->l('Invalid email address.');
		
		/* Unsubscription */
		else if (Tools::getValue('action') == '1')
		{
			$register_status = $this->isNewsletterRegistered(Tools::getValue('email'));

			if ($register_status < 1)
				return $this->error = $this->l('This email address is not registered.');

			if (!$this->unregister(Tools::getValue('email'), $register_status))
				return $this->error = $this->l('An error occurred while attempting to unsubscribe.');

			return $this->valid = $this->l('Unsubscription successful.');
		}
		/* Subscription */
		else if (Tools::getValue('action') == '0')
		{
			$register_status = $this->isNewsletterRegistered(Tools::getValue('email'));
			if ($register_status > 0)
				return $this->error = $this->l('This email address is already registered.');

			$email = pSQL(Tools::getValue('email'));
			
			if (!$this->isRegistered($register_status))
			{
				
				if (Configuration::get('NW_VERIFICATION_EMAIL'))
				{
					// create an unactive entry in the newsletter database
					if ($register_status == self::GUEST_NOT_REGISTERED)
						$this->registerGuest($email, false);

					if (!$token = $this->getToken($email, $register_status))
						return $this->error = $this->l('An error occurred during the subscription process.');

					$this->sendVerificationEmail($email, $token);

					return $this->valid = $this->l('A verification email has been sent. Please check your inbox.');
				}
				else
				{
					if ($this->register($email, $register_status))
						return  $this->valid = $this->l('You have successfully subscribed to this newsletter.');
					else
						return $this->error = $this->l('An error occurred during the subscription process.');

					if ($code = Configuration::get('NW_VOUCHER_CODE'))
						$this->sendVoucher($email, $code);

					if (Configuration::get('NW_CONFIRMATION_EMAIL'))
						$this->sendConfirmationEmail($email);
				}
			}
		}
	}
	
	/**
	 * Return true if the registered status correspond to a registered user
	 *
	 * @param int $register_status
	 *
	 * @return bool
	 */
	protected function isRegistered($register_status)
	{
		return in_array(
			$register_status,
			array(self::GUEST_REGISTERED, self::CUSTOMER_REGISTERED)
		);
	}


	/**
	 * Subscribe an email to the newsletter. It will create an entry in the newsletter table
	 * or update the customer table depending of the register status
	 *
	 * @param string $email
	 * @param int    $register_status
	 */
	protected function register($email, $register_status)
	{
		if ($register_status == self::GUEST_NOT_REGISTERED)
			return $this->registerGuest($email);

		if ($register_status == self::CUSTOMER_NOT_REGISTERED)
			return $this->registerUser($email);

		return false;
	}

	protected function unregister($email, $register_status)
	{
		if ($register_status == self::GUEST_REGISTERED)
			$sql = 'DELETE FROM '._DB_PREFIX_.'newsletter WHERE `email` = \''.pSQL($email).'\' AND id_shop = '.$this->context->shop->id;
		else if ($register_status == self::CUSTOMER_REGISTERED)
			$sql = 'UPDATE '._DB_PREFIX_.'customer SET `newsletter` = 0 WHERE `email` = \''.pSQL($email).'\' AND id_shop = '.$this->context->shop->id;

		if (!isset($sql) || !Db::getInstance()->execute($sql))
			return false;

		return true;
	}

	/**
	 * Subscribe a customer to the newsletter
	 *
	 * @param string $email
	 *
	 * @return bool
	 */
	protected function registerUser($email)
	{
		$sql = 'UPDATE '._DB_PREFIX_.'customer
				SET `newsletter` = 1, newsletter_date_add = NOW(), `ip_registration_newsletter` = \''.pSQL(Tools::getRemoteAddr()).'\'
				WHERE `email` = \''.pSQL($email).'\'
				AND id_shop = '.$this->context->shop->id;

		return Db::getInstance()->execute($sql);
	}

	/**
	 * Subscribe a guest to the newsletter
	 *
	 * @param string $email
	 * @param bool   $active
	 *
	 * @return bool
	 */
	protected function registerGuest($email, $active = true)
	{
		$sql = 'INSERT INTO '._DB_PREFIX_.'newsletter (id_shop, id_shop_group, email, newsletter_date_add, ip_registration_newsletter, http_referer, active)
				VALUES
				('.$this->context->shop->id.',
				'.$this->context->shop->id_shop_group.',
				\''.pSQL($email).'\',
				NOW(),
				\''.pSQL(Tools::getRemoteAddr()).'\',
				(
					SELECT c.http_referer
					FROM '._DB_PREFIX_.'connections c
					WHERE c.id_guest = '.(int)$this->context->customer->id.'
					ORDER BY c.date_add DESC LIMIT 1
				),
				'.(int)$active.'
				)';

		return Db::getInstance()->execute($sql);
	}


	public function activateGuest($email)
	{
		return Db::getInstance()->execute(
			'UPDATE `'._DB_PREFIX_.'newsletter`
						SET `active` = 1
						WHERE `email` = \''.pSQL($email).'\''
		);
	}

	/**
	 * Returns a guest email by token
	 *
	 * @param string $token
	 *
	 * @return string email
	 */
	protected function getGuestEmailByToken($token)
	{
		$sql = 'SELECT `email`
				FROM `'._DB_PREFIX_.'newsletter`
				WHERE MD5(CONCAT( `email` , `newsletter_date_add`, \''.pSQL(Configuration::get('NW_SALT')).'\')) = \''.pSQL($token).'\'
				AND `active` = 0';

		return Db::getInstance()->getValue($sql);
	}

	/**
	 * Returns a customer email by token
	 *
	 * @param string $token
	 *
	 * @return string email
	 */
	protected function getUserEmailByToken($token)
	{
		$sql = 'SELECT `email`
				FROM `'._DB_PREFIX_.'customer`
				WHERE MD5(CONCAT( `email` , `date_add`, \''.pSQL(Configuration::get('NW_SALT')).'\')) = \''.pSQL($token).'\'
				AND `newsletter` = 0';

		return Db::getInstance()->getValue($sql);
	}

	/**
	 * Return a token associated to an user
	 *
	 * @param string $email
	 * @param string $register_status
	 */
	protected function getToken($email, $register_status)
	{
		if (in_array($register_status, array(self::GUEST_NOT_REGISTERED, self::GUEST_REGISTERED)))
		{
			$sql = 'SELECT MD5(CONCAT( `email` , `newsletter_date_add`, \''.pSQL(Configuration::get('NW_SALT')).'\')) as token
					FROM `'._DB_PREFIX_.'newsletter`
					WHERE `active` = 0
					AND `email` = \''.pSQL($email).'\'';
		}
		else if ($register_status == self::CUSTOMER_NOT_REGISTERED)
		{
			$sql = 'SELECT MD5(CONCAT( `email` , `date_add`, \''.pSQL(Configuration::get('NW_SALT')).'\' )) as token
					FROM `'._DB_PREFIX_.'customer`
					WHERE `newsletter` = 0
					AND `email` = \''.pSQL($email).'\'';
		}

		return Db::getInstance()->getValue($sql);
	}

	/**
	 * Ends the registration process to the newsletter
	 *
	 * @param string $token
	 *
	 * @return string
	 */
	public function confirmEmail($token)
	{
		$activated = false;

		if ($email = $this->getGuestEmailByToken($token))
			$activated = $this->activateGuest($email);
		else if ($email = $this->getUserEmailByToken($token))
			$activated = $this->registerUser($email);

		if (!$activated)
			return $this->l('This email is already registered and/or invalid.');

		if ($discount = Configuration::get('NW_VOUCHER_CODE'))
			$this->sendVoucher($email, $discount);

		if (Configuration::get('NW_CONFIRMATION_EMAIL'))
			$this->sendConfirmationEmail($email);

		return $this->l('Thank you for subscribing to our newsletter.');
	}

	/**
	 * Send the confirmation mails to the given $email address if needed.
	 *
	 * @param string $email Email where to send the confirmation
	 *
	 * @note the email has been verified and might not yet been registered. Called by AuthController::processCustomerNewsletter
	 *
	 */
	public function confirmSubscription($email)
	{
		if ($email)
		{
			if ($discount = Configuration::get('NW_VOUCHER_CODE'))
				$this->sendVoucher($email, $discount);

			if (Configuration::get('NW_CONFIRMATION_EMAIL'))
				$this->sendConfirmationEmail($email);
		}
	}

	/**
	 * Send an email containing a voucher code
	 *
	 * @param $email
	 * @param $code
	 *
	 * @return bool|int
	 */
	protected function sendVoucher($email, $code)
	{
		return Mail::Send($this->context->language->id, 'newsletter_voucher', Mail::l('Newsletter voucher', $this->context->language->id), array('{discount}' => $code), $email, null, null, null, null, null, dirname(__FILE__).'/mails/', false, $this->context->shop->id);
	}

	/**
	 * Send a confirmation email
	 *
	 * @param string $email
	 *
	 * @return bool
	 */
	protected function sendConfirmationEmail($email)
	{
		return Mail::Send($this->context->language->id, 'newsletter_conf', Mail::l('Newsletter confirmation', $this->context->language->id), array(), pSQL($email), null, null, null, null, null, dirname(__FILE__).'/mails/', false, $this->context->shop->id);
	}

	/**
	 * Send a verification email
	 *
	 * @param string $email
	 * @param string $token
	 *
	 * @return bool
	 */
	protected function sendVerificationEmail($email, $token)
	{
		$verif_url = Context::getContext()->link->getModuleLink(
			'blocknewsletter', 'verification', array(
				'token' => $token,
			)
		);

		return Mail::Send($this->context->language->id, 'newsletter_verif', Mail::l('Email verification', $this->context->language->id), array('{verif_url}' => $verif_url), $email, null, null, null, null, null, dirname(__FILE__).'/mails/', false, $this->context->shop->id);
	}
}
