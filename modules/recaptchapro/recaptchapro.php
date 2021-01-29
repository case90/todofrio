<?php
/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (! defined('_PS_VERSION_')) {
    exit;
}

class Recaptchapro extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'recaptchapro';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'PrestaBucket';
        $this->need_instance = 1;
        $this->module_key = '3c8df6e2fdf1c6affd7486e46914c6fc';
        $this->tabb = (Tools::getIsset('atab') && Tools::getValue('atab')) ? Tools::getValue('atab') : 'configuration';

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Google No CAPTCHA reCaptcha PRO - ALL in 1');
        $this->description =
        $this->l('Protect your Website from spam and abuse using an Advanced Risk Analysis Engine.');
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        // Load default values for backoffice settings
        $languages = Language::getLanguages(false);
        $values = array();
        
        foreach ($languages as $key => $lang) {
            if ($key == 0) {
                $values['RECAPTCHAPRO_WHITELISTMESSAGE'][$lang['id_lang']] = '';
            } else {
                $values['RECAPTCHAPRO_WHITELISTMESSAGE'][$lang['id_lang']] = '';
            }
        }
        
        Configuration::updateValue('RECAPTCHAPRO_SITE_KEY', '');
        Configuration::updateValue('RECAPTCHAPRO_SECRET_KEY', '');
        Configuration::updateValue('RECAPTCHAPRO_ENABLE_FOR', '1;4');
        Configuration::updateValue('RECAPTCHAPRO_FAIL_LOGINA', 4);
        Configuration::updateValue('RECAPTCHAPRO_RECAPTCHAV', 1);
        Configuration::updateValue('RECAPTCHAPRO_RETHEME', 'light');
        Configuration::updateValue('RECAPTCHAPRO_RELANGUAGE', 1);
        Configuration::updateValue('RECAPTCHAPRO_CUSTOMLANGUAGE', 'en');
        Configuration::updateValue('RECAPTCHAPRO_RESIZE', 'normal');
        Configuration::updateValue('RECAPTCHAPRO_SPAMPR', true);
        
        // Include install core where we install database tables
        include(dirname(__FILE__) . '/sql/install.php');
        
        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayFooter') &&
            $this->registerHook('actionAdminLoginControllerSetMedia');
    }

    public function uninstall()
    {
        Configuration::deleteByName('RECAPTCHAPRO_SITE_KEY');
        Configuration::deleteByName('RECAPTCHAPRO_SECRET_KEY');
        Configuration::deleteByName('RECAPTCHAPRO_ENABLE_FOR');
        Configuration::deleteByName('RECAPTCHAPRO_FAIL_LOGINA');
        Configuration::deleteByName('RECAPTCHAPRO_RECAPTCHAV');
        Configuration::deleteByName('RECAPTCHAPRO_RETHEME');
        Configuration::deleteByName('RECAPTCHAPRO_RELANGUAGE');
        Configuration::deleteByName('RECAPTCHAPRO_CUSTOMLANGUAGE');
        Configuration::deleteByName('RECAPTCHAPRO_RESIZE');
        Configuration::deleteByName('RECAPTCHAPRO_WHITELISTMESSAGE');
        Configuration::deleteByName('RECAPTCHAPRO_SPAMPR');

        include(dirname(__FILE__) . '/sql/uninstall.php');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '&atab=recaptchapro';
        $url = Tools::substr($url, 0, strpos($url, '&atab='));
        
        $this->context->smarty->assign('module_dir', Tools::getProtocol(Tools::usingSecureMode())
        . $_SERVER['HTTP_HOST'] . $this->getPathUri());
        $this->context->smarty->assign('module_link', $url);
        $this->context->smarty->assign('tab', $this->tabb);
        $this->context->smarty->assign('uri', $this->getPathUri());
        $this->context->smarty->assign('ajax_token', Tools::getAdminToken('AdminModules'));
        $this->context->smarty->assign('version', Tools::substr(_PS_VERSION_, 0, 3));

        $output = $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl');
        
        // Productsheet tab functionality
        if ($this->tabb == 'whitelist') {
            if (Tools::isSubmit('delete' . $this->name)) {
                if (Tools::getIsset('id_whitelist')) {
                    $this->deleteWhitelist(Tools::getValue('id_whitelist'));
                }
                
                return $this->displayConfirmation($this->l('Settings saved successfully.')) .
                    $output . $this->displayList();
            }
        }
        
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitRecaptchaproModule')) == true) {
            if ($this->tabb == 'configuration') {
                return $this->postProcess() . $output . $this->renderForm();
            } elseif ($this->tabb == 'whitelist') {
                return $output . $this->displayList();
            }
        } else {
            if ($this->tabb == 'configuration') {
                return $output . $this->renderForm();
            } elseif ($this->tabb == 'whitelist') {
                if (Tools::getIsset('re_successfully')) {
                    return $this->displayConfirmation($this->l('Settings saved successfully.')) .
                        $output . $this->displayList();
                } else {
                    return $output . $this->displayList();
                }
            }
        }
    }
    
    /**
     * Create the Helper List
     */
    public function displayList()
    {
        $sql = 'SELECT id_whitelist, ip_address, date_added FROM ' . _DB_PREFIX_ . 'rec_whitelist';
        
        if (Tools::getValue('submitFilter' . $this->name)) {
            if (Tools::getValue($this->name . 'Filter_ip_address')) {
                $sql .= ' WHERE ip_address LIKE "%' . pSQL(Tools::getValue($this->name . 'Filter_ip_address')) . '%"';
            }
        }
        
        $sql .= ' ORDER BY id_whitelist DESC';
        
        $result = Db::getInstance()->ExecuteS($sql);
        
        $this->fields_list = array(
            'ip_address' => array(
                'title' => $this->l('IP address'),
                'type' => 'text'
            ),
            'date_added' => array(
                'title' => $this->l('Date added'),
                'search' => false
            )
        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->identifier = 'id_whitelist';
        $helper->show_toolbar = true;
        $helper->listTotal = count($result);
        $helper->toolbar_btn['new'] = array(
            'desc' => $this->l('Add IP address to Whitelist'),
            'class' => 'rec-add-ip-whitelist'
        );
        $helper->title = $this->l('Whitelist');
        $helper->table = $this->name;
        $helper->actions = array('delete');
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex .
        '&configure=' . $this->name . '&token=' .
        Tools::getAdminTokenLite('AdminModules') . '&atab=whitelist';
        
        return $helper->generateList($result, $this->fields_list);
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitRecaptchaproModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'uri' => $this->getPathUri(),
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );
    
        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        $captcha_m1 = 'This message will be displayed instead of the ReCaptcha';
        $captcha_m2 = ' in all forms except the Registration form. Leave empty for nothing.';
        
        $fail_captcha1 = 'How many fail logins it will take the captcha';
        $fail_captcha2 = ' to be displayed. Enter 0 for instant display.';
        
        return array(
            'form' => array(
                'legend'  => array(
                'title'   => $this->l('Settings'),
                'icon'    => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type'      => 'text',
                        'label'     => $this->l('Site Key'),
                        'required'  => true,
                        'name'      => 'RECAPTCHAPRO_SITE_KEY',
                        'class'     => 'resitekey'
                    ),
                    array(
                        'type'      => 'text',
                        'label'     => $this->l('Secret Key'),
                        'required'  => true,
                        'name'      => 'RECAPTCHAPRO_SECRET_KEY',
                        'class'     => 'resecretkey'
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Enable ReCaptcha for'),
                        'name' => 'RECAPTCHAPRO_ENABLE_FOR[]',
                        'multiple' => true,
                        'options' => array(
                            'query' => array(
                                array('key' => '1', 'name' => $this->l('Contact form')),
                                array('key' => '2', 'name' => $this->l('Backend Login form')),
                                array('key' => '3', 'name' => $this->l('Frontend login form')),
                                array('key' => '4', 'name' => $this->l('Registration form')),
                                array('key' => '5', 'name' => $this->l('Reset password form')),
                                array('key' => '6', 'name' => $this->l('Comments form')),
                                array('key' => '7', 'name' => $this->l('Newsletter form')),
                            ),
                            'id' => 'key',
                            'name' => 'name'
                        ),
                        'class' => 'enablefor_re'
                    ),
                    array(
                        'type'      => 'text',
                        'label'     => $this->l('Show ReCaptcha after fail customer login attempts'),
                        'required'  => true,
                        'name'      => 'RECAPTCHAPRO_FAIL_LOGINA',
                        'class'     => 'faillogina',
                        'desc'      => $this->l($fail_captcha1 . $fail_captcha2)
                    ),
                    array(
                        'type'     => 'switch',
                        'label'    => $this->l('Advanced Spam protection(qq.com, 139.com, 163.com, etc.)'),
                        'name'     => 'RECAPTCHAPRO_SPAMPR',
                        'is_bool'  => true,
                        'values'   => array(
                            array(
                                'id'     => 'active_on',
                                'value'  => true,
                                'label'  => $this->l('Enabled')
                            ),
                            array(
                                'id'     => 'active_off',
                                'value'  => false,
                                'label'  => $this->l('Disabled')
                            )
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('reCaptcha version'),
                        'name' => 'RECAPTCHAPRO_RECAPTCHAV',
                        'options' => array(
                            'query' => array(
                                array('key' => '1', 'name' => $this->l('Version 2')),
                                array('key' => '2', 'name' => $this->l('Invisible reCaptcha'))
                            ),
                            'id' => 'key',
                            'name' => 'name'
                        )
                    ),
                    (Configuration::get('RECAPTCHAPRO_RECAPTCHAV') == 1 ?
                    array(
                        'type' => 'select',
                        'label' => $this->l('reCaptcha theme'),
                        'name' => 'RECAPTCHAPRO_RETHEME',
                        'class' => 'retheme_db',
                        'options' => array(
                            'query' => array(
                                array('key' => 'light', 'name' => $this->l('Light')),
                                array('key' => 'dark', 'name' => $this->l('Dark'))
                            ),
                            'id' => 'key',
                            'name' => 'name'
                        )
                    ) : array(
                        'type' => 'select',
                        'label' => $this->l('reCaptcha theme'),
                        'name' => 'RECAPTCHAPRO_RETHEME',
                        'options' => array(
                            'query' => array(
                                array('key' => '1', 'name' => 'no-input')
                            ),
                            'id' => 'key',
                            'name' => 'name'
                        )
                    )),
                    array(
                        'type' => 'select',
                        'label' => $this->l('reCaptcha language'),
                        'name' => 'RECAPTCHAPRO_RELANGUAGE',
                        'options' => array(
                            'query' => array(
                                array('key' => '1', 'name' => $this->l('Default shop language')),
                                array('key' => '2', 'name' => $this->l('Select custom language'))
                            ),
                            'id' => 'key',
                            'name' => 'name'
                        ),
                        'desc' => $this->l('Default language work with multilanguage too.')
                    ),
                    (Configuration::get('RECAPTCHAPRO_RELANGUAGE') == 2 ?
                    array(
                        'type' => 'select',
                        'label' => $this->l('Custom language'),
                        'name' => 'RECAPTCHAPRO_CUSTOMLANGUAGE',
                        'class' => 'customlanguage_db',
                        'options' => array(
                            'query' => array(
                                array('key' => 'ar', 'name' => $this->l('Arabic')),
                                array('key' => 'af', 'name' => $this->l('Afrikaans')),
                                array('key' => 'am', 'name' => $this->l('Amharic')),
                                array('key' => 'hy', 'name' => $this->l('Armenian')),
                                array('key' => 'az', 'name' => $this->l('Azerbaijani')),
                                array('key' => 'eu', 'name' => $this->l('Basque')),
                                array('key' => 'bn', 'name' => $this->l('Bengali')),
                                array('key' => 'bg', 'name' => $this->l('Bulgarian')),
                                array('key' => 'ca', 'name' => $this->l('Catalan')),
                                array('key' => 'zh-HK', 'name' => $this->l('Chinese (Hong Kong)')),
                                array('key' => 'zh-CN', 'name' => $this->l('Chinese (Simplified)')),
                                array('key' => 'zh-TW', 'name' => $this->l('Chinese (Traditional)')),
                                array('key' => 'hr', 'name' => $this->l('Croatian')),
                                array('key' => 'cs', 'name' => $this->l('Czech')),
                                array('key' => 'da', 'name' => $this->l('Danish')),
                                array('key' => 'nl', 'name' => $this->l('Dutch')),
                                array('key' => 'en-GB', 'name' => $this->l('English (UK)')),
                                array('key' => 'en', 'name' => $this->l('English (US)')),
                                array('key' => 'et', 'name' => $this->l('Estonian')),
                                array('key' => 'fil', 'name' => $this->l('Filipino')),
                                array('key' => 'fi', 'name' => $this->l('Finnish')),
                                array('key' => 'fr', 'name' => $this->l('French')),
                                array('key' => 'fr-CA', 'name' => $this->l('French (Canadian)')),
                                array('key' => 'gl', 'name' => $this->l('Galician')),
                                array('key' => 'ka', 'name' => $this->l('Georgian')),
                                array('key' => 'de', 'name' => $this->l('German')),
                                array('key' => 'de-AT', 'name' => $this->l('German (Austria)')),
                                array('key' => 'de-CH', 'name' => $this->l('German (Switzerland)')),
                                array('key' => 'el', 'name' => $this->l('Greek')),
                                array('key' => 'gu', 'name' => $this->l('Gujarati')),
                                array('key' => 'iw', 'name' => $this->l('Hebrew')),
                                array('key' => 'hi', 'name' => $this->l('Hindi')),
                                array('key' => 'hu', 'name' => $this->l('Hungarain')),
                                array('key' => 'is', 'name' => $this->l('Icelandic')),
                                array('key' => 'id', 'name' => $this->l('Indonesian')),
                                array('key' => 'it', 'name' => $this->l('Italian')),
                                array('key' => 'ja', 'name' => $this->l('Japanese')),
                                array('key' => 'kn', 'name' => $this->l('Kannada')),
                                array('key' => 'ko', 'name' => $this->l('Korean')),
                                array('key' => 'lo', 'name' => $this->l('Laothian')),
                                array('key' => 'lv', 'name' => $this->l('Latvian')),
                                array('key' => 'lt', 'name' => $this->l('Lithuanian')),
                                array('key' => 'ms', 'name' => $this->l('Malay')),
                                array('key' => 'ml', 'name' => $this->l('Malayalam')),
                                array('key' => 'mr', 'name' => $this->l('Marathi')),
                                array('key' => 'mn', 'name' => $this->l('Mongolian')),
                                array('key' => 'no', 'name' => $this->l('Norwegian')),
                                array('key' => 'fa', 'name' => $this->l('Persian')),
                                array('key' => 'pl', 'name' => $this->l('Polish')),
                                array('key' => 'pt', 'name' => $this->l('Portuguese')),
                                array('key' => 'pt-BR', 'name' => $this->l('Portuguese (Brazil)')),
                                array('key' => 'pt-PT', 'name' => $this->l('Portuguese (Portugal)')),
                                array('key' => 'ro', 'name' => $this->l('Romanian')),
                                array('key' => 'ru', 'name' => $this->l('Russian')),
                                array('key' => 'sr', 'name' => $this->l('Serbian')),
                                array('key' => 'si', 'name' => $this->l('Sinhalese')),
                                array('key' => 'sk', 'name' => $this->l('Slovak')),
                                array('key' => 'sl', 'name' => $this->l('Slovenian')),
                                array('key' => 'es', 'name' => $this->l('Spanish')),
                                array('key' => 'es-419', 'name' => $this->l('Spanish (Latin America)')),
                                array('key' => 'sw', 'name' => $this->l('Swahili')),
                                array('key' => 'sv', 'name' => $this->l('Latvian')),
                                array('key' => 'ta', 'name' => $this->l('Tamil')),
                                array('key' => 'te', 'name' => $this->l('Telugu')),
                                array('key' => 'th', 'name' => $this->l('Thai')),
                                array('key' => 'tr', 'name' => $this->l('Turkish')),
                                array('key' => 'uk', 'name' => $this->l('Ukrainian')),
                                array('key' => 'ur', 'name' => $this->l('Urdu')),
                                array('key' => 'vi', 'name' => $this->l('Vietnamese')),
                                array('key' => 'zu', 'name' => $this->l('Zulu'))
                            ),
                            'id' => 'key',
                            'name' => 'name'
                        )
                    ) : array(
                        'type' => 'select',
                        'label' => $this->l('Custom language'),
                        'name' => 'RECAPTCHAPRO_CUSTOMLANGUAGE',
                        'options' => array(
                            'query' => array(
                                array('key' => 'ar', 'name' => $this->l('Arabic')),
                                array('key' => 'af', 'name' => $this->l('Afrikaans')),
                                array('key' => 'am', 'name' => $this->l('Amharic')),
                                array('key' => 'hy', 'name' => $this->l('Armenian')),
                                array('key' => 'az', 'name' => $this->l('Azerbaijani')),
                                array('key' => 'eu', 'name' => $this->l('Basque')),
                                array('key' => 'bn', 'name' => $this->l('Bengali')),
                                array('key' => 'bg', 'name' => $this->l('Bulgarian')),
                                array('key' => 'ca', 'name' => $this->l('Catalan')),
                                array('key' => 'zh-HK', 'name' => $this->l('Chinese (Hong Kong)')),
                                array('key' => 'zh-CN', 'name' => $this->l('Chinese (Simplified)')),
                                array('key' => 'zh-TW', 'name' => $this->l('Chinese (Traditional)')),
                                array('key' => 'hr', 'name' => $this->l('Croatian')),
                                array('key' => 'cs', 'name' => $this->l('Czech')),
                                array('key' => 'da', 'name' => $this->l('Danish')),
                                array('key' => 'nl', 'name' => $this->l('Dutch')),
                                array('key' => 'en-GB', 'name' => $this->l('English (UK)')),
                                array('key' => 'en', 'name' => $this->l('English (US)')),
                                array('key' => 'et', 'name' => $this->l('Estonian')),
                                array('key' => 'fil', 'name' => $this->l('Filipino')),
                                array('key' => 'fi', 'name' => $this->l('Finnish')),
                                array('key' => 'fr', 'name' => $this->l('French')),
                                array('key' => 'fr-CA', 'name' => $this->l('French (Canadian)')),
                                array('key' => 'gl', 'name' => $this->l('Galician')),
                                array('key' => 'ka', 'name' => $this->l('Georgian')),
                                array('key' => 'de', 'name' => $this->l('German')),
                                array('key' => 'de-AT', 'name' => $this->l('German (Austria)')),
                                array('key' => 'de-CH', 'name' => $this->l('German (Switzerland)')),
                                array('key' => 'el', 'name' => $this->l('Greek')),
                                array('key' => 'gu', 'name' => $this->l('Gujarati')),
                                array('key' => 'iw', 'name' => $this->l('Hebrew')),
                                array('key' => 'hi', 'name' => $this->l('Hindi')),
                                array('key' => 'hu', 'name' => $this->l('Hungarain')),
                                array('key' => 'is', 'name' => $this->l('Icelandic')),
                                array('key' => 'id', 'name' => $this->l('Indonesian')),
                                array('key' => 'it', 'name' => $this->l('Italian')),
                                array('key' => 'ja', 'name' => $this->l('Japanese')),
                                array('key' => 'kn', 'name' => $this->l('Kannada')),
                                array('key' => 'ko', 'name' => $this->l('Korean')),
                                array('key' => 'lo', 'name' => $this->l('Laothian')),
                                array('key' => 'lv', 'name' => $this->l('Latvian')),
                                array('key' => 'lt', 'name' => $this->l('Lithuanian')),
                                array('key' => 'ms', 'name' => $this->l('Malay')),
                                array('key' => 'ml', 'name' => $this->l('Malayalam')),
                                array('key' => 'mr', 'name' => $this->l('Marathi')),
                                array('key' => 'mn', 'name' => $this->l('Mongolian')),
                                array('key' => 'no', 'name' => $this->l('Norwegian')),
                                array('key' => 'fa', 'name' => $this->l('Persian')),
                                array('key' => 'pl', 'name' => $this->l('Polish')),
                                array('key' => 'pt', 'name' => $this->l('Portuguese')),
                                array('key' => 'pt-BR', 'name' => $this->l('Portuguese (Brazil)')),
                                array('key' => 'pt-PT', 'name' => $this->l('Portuguese (Portugal)')),
                                array('key' => 'ro', 'name' => $this->l('Romanian')),
                                array('key' => 'ru', 'name' => $this->l('Russian')),
                                array('key' => 'sr', 'name' => $this->l('Serbian')),
                                array('key' => 'si', 'name' => $this->l('Sinhalese')),
                                array('key' => 'sk', 'name' => $this->l('Slovak')),
                                array('key' => 'sl', 'name' => $this->l('Slovenian')),
                                array('key' => 'es', 'name' => $this->l('Spanish')),
                                array('key' => 'es-419', 'name' => $this->l('Spanish (Latin America)')),
                                array('key' => 'sw', 'name' => $this->l('Swahili')),
                                array('key' => 'sv', 'name' => $this->l('Latvian')),
                                array('key' => 'ta', 'name' => $this->l('Tamil')),
                                array('key' => 'te', 'name' => $this->l('Telugu')),
                                array('key' => 'th', 'name' => $this->l('Thai')),
                                array('key' => 'tr', 'name' => $this->l('Turkish')),
                                array('key' => 'uk', 'name' => $this->l('Ukrainian')),
                                array('key' => 'ur', 'name' => $this->l('Urdu')),
                                array('key' => 'vi', 'name' => $this->l('Vietnamese')),
                                array('key' => 'zu', 'name' => $this->l('Zulu'))
                            ),
                            'id' => 'key',
                            'name' => 'name'
                        )
                    )),
                    (Configuration::get('RECAPTCHAPRO_RECAPTCHAV') == 1 ?
                    array(
                        'type' => 'select',
                        'label' => $this->l('reCaptcha size'),
                        'name' => 'RECAPTCHAPRO_RESIZE',
                        'options' => array(
                            'query' => array(
                                array('key' => 'normal', 'name' => $this->l('Normal')),
                                array('key' => 'compact', 'name' => $this->l('Compact'))
                            ),
                            'id' => 'key',
                            'name' => 'name'
                        )
                    ) : array(
                        'type' => 'select',
                        'label' => $this->l('reCaptcha size'),
                        'name' => 'RECAPTCHAPRO_RESIZE',
                        'options' => array(
                            'query' => array(
                                array('key' => '1', 'name' => 'no-input')
                            ),
                            'id' => 'key',
                            'name' => 'name'
                        )
                    )),
                    array(
                        'type'      => 'text',
                        'label'     => $this->l('Whitelist message'),
                        'desc'      => $this->l($captcha_m1 . $captcha_m2),
                        'name'      => 'RECAPTCHAPRO_WHITELISTMESSAGE',
                        'lang'      => true
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            )
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        $languages = Language::getLanguages(false);
        $fields = array();
        
        foreach ($languages as $lang) {
            $fields['RECAPTCHAPRO_WHITELISTMESSAGE'][$lang['id_lang']] =
            Configuration::get('RECAPTCHAPRO_WHITELISTMESSAGE', $lang['id_lang']);
        }
        
        $fields['RECAPTCHAPRO_ENABLE_FOR[]'] = explode(';', Configuration::get('RECAPTCHAPRO_ENABLE_FOR'));
        
        $fields['RECAPTCHAPRO_SITE_KEY'] = Configuration::get('RECAPTCHAPRO_SITE_KEY');
        $fields['RECAPTCHAPRO_SECRET_KEY'] = Configuration::get('RECAPTCHAPRO_SECRET_KEY');
        $fields['RECAPTCHAPRO_FAIL_LOGINA'] = Configuration::get('RECAPTCHAPRO_FAIL_LOGINA');
        $fields['RECAPTCHAPRO_RECAPTCHAV'] = Configuration::get('RECAPTCHAPRO_RECAPTCHAV');
        $fields['RECAPTCHAPRO_RETHEME'] = Configuration::get('RECAPTCHAPRO_RETHEME');
        $fields['RECAPTCHAPRO_RELANGUAGE'] = Configuration::get('RECAPTCHAPRO_RELANGUAGE');
        $fields['RECAPTCHAPRO_CUSTOMLANGUAGE'] = Configuration::get('RECAPTCHAPRO_CUSTOMLANGUAGE');
        $fields['RECAPTCHAPRO_RESIZE'] = Configuration::get('RECAPTCHAPRO_RESIZE');
        $fields['RECAPTCHAPRO_SPAMPR'] = Configuration::get('RECAPTCHAPRO_SPAMPR');
        
        return $fields;
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $errors = array();
        $values = array();
        
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            $languages = Language::getLanguages(false);
            // Language distribuitor
            if ($key == 'RECAPTCHAPRO_WHITELISTMESSAGE') {
                foreach ($languages as $lang) {
                    $values[$key][$lang['id_lang']] = Tools::getValue($key . '_' . $lang['id_lang']);
                }
                
                Configuration::updateValue($key, $values[$key]);
            } elseif ($key == 'RECAPTCHAPRO_SITE_KEY') {
                if (! Tools::getValue($key) && trim(Tools::strlen(Tools::getValue($key)) < 1)) {
                    $errors['site_key'] = $this->l('Site Key field can not be empty. Field required.');
                } else {
                    Configuration::updateValue($key, Tools::getValue($key));
                }
            } elseif ($key == 'RECAPTCHAPRO_SECRET_KEY') {
                if (! Tools::getValue($key) && trim(Tools::strlen(Tools::getValue($key)) < 1)) {
                    $errors['secret_key'] = $this->l('Secret Key field can not be empty. Field required.');
                } else {
                    Configuration::updateValue($key, Tools::getValue($key));
                }
            } elseif ($key == 'RECAPTCHAPRO_FAIL_LOGINA') {
                if (! Tools::getValue($key) && trim(Tools::strlen(Tools::getValue($key)) < 1)) {
                    $errors['fail_logina'] = 'Login attemps field can not be empty. Field required.';
                } elseif (! is_numeric(Tools::getValue($key))) {
                    $errors['fail_logina'] = 'Login attemps field can be only a number.';
                } else {
                    Configuration::updateValue($key, Tools::getValue($key));
                }
            } elseif ($key == 'RECAPTCHAPRO_ENABLE_FOR[]') {
                if (Tools::getValue('RECAPTCHAPRO_ENABLE_FOR')) {
                    $implode_r = implode(';', Tools::getValue('RECAPTCHAPRO_ENABLE_FOR'));
                    Configuration::updateValue('RECAPTCHAPRO_ENABLE_FOR', $implode_r);
                } else {
                    Configuration::updateValue('RECAPTCHAPRO_ENABLE_FOR', '');
                }
            } else {
                Configuration::updateValue($key, Tools::getValue($key));
            }
        }
        
        if ($errors) {
            $this->_clearCache('footer.tpl');
            return $this->displayError(implode('<br>', $errors));
        } else {
            $this->_clearCache('footer.tpl');
            return $this->displayConfirmation($this->l('Settings saved successfully.'));
        }
    }
    
    /**
     * Delete ips from whitelist table
     */
    protected function deleteWhitelist($pid)
    {
        $sql = 'SELECT id_whitelist FROM ' . _DB_PREFIX_ . 'rec_whitelist WHERE id_whitelist = "' . pSQL($pid) . '"';
        
        if ($row = Db::getInstance()->getRow($sql)) {
            $id_whitelist = $row['id_whitelist'];
            
            Db::getInstance()->delete('rec_whitelist', 'id_whitelist = "' . (int)$id_whitelist . '"');
        }
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if ((Tools::getValue('controller') == 'AdminProducts' && Tools::getValue('id_product'))
            || (Tools::getValue('controller') == 'AdminModules'
            && (Tools::getValue('configure') == $this->name
            || Tools::getValue('module_name') == $this->name))) {
            Media::addJsDef(
                array(
                    'l_light' => $this->l('Light'),
                    'l_dark'  => $this->l('Dark'),
                    'l_normal'  => $this->l('Normal'),
                    'l_compact'  => $this->l('Compact')
                )
            );
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path . '/views/js/front.js');
        $this->context->controller->addCSS($this->_path . '/views/css/front.css');
    }

    public function hookDisplayFooter()
    {
        $captcha_enable = explode(';', Configuration::get('RECAPTCHAPRO_ENABLE_FOR'));
        $captcha_contact = false;
        $captcha_frontend = false;
        $captcha_registration = false;
        $captcha_resetp = false;
        $captcha_comments = false;
        $captcha_newsletter = false;
        
        foreach ($captcha_enable as $each_e) {
            switch ($each_e) {
                case 1:
                    $captcha_contact = true;
                    break;
                case 3:
                    $captcha_frontend = true;
                    break;
                case 4:
                    $captcha_registration = true;
                    break;
                case 5:
                    $captcha_resetp = true;
                    break;
                case 6:
                    $captcha_comments = true;
                    break;
                case 7:
                    $captcha_newsletter = true;
                    break;
            }
        }
        
        // Register the correct language for Smarty display
        if (Configuration::get('RECAPTCHAPRO_RELANGUAGE') == 1) {
            $re_language = $this->context->language->iso_code;
        } elseif (Configuration::get('RECAPTCHAPRO_RELANGUAGE') == 2) {
            $re_language = Configuration::get('RECAPTCHAPRO_CUSTOMLANGUAGE');
        } else {
            $re_language = 'en';
        }
        
        // Check if fail customer login attemps exceded
        if (Configuration::get('RECAPTCHAPRO_FAIL_LOGINA') != 0 && $captcha_frontend == true) {
            $cookie_n = new Cookie('register_us');
        }
        
        if (Tools::substr(_PS_VERSION_, 0, 3) == '1.7') {
            if (Tools::getIsset('submitLogin')) {
                if (Configuration::get('RECAPTCHAPRO_FAIL_LOGINA') != 0 && $captcha_frontend == true) {
                    if ($cookie_n->__isset('pbfa')) {
                        if ($cookie_n->pbfa_e < time()) {
                            $expiry = time() + 600;
                            $cookie_n->__set('pbfa', '1');
                            $cookie_n->__set('pbfa_e', $expiry);
                        } else {
                            $cookie_n->__set('pbfa', $cookie_n->pbfa + 1);
                        }
                    } else {
                        $expiry = time() + 600;
                        $cookie_n->__set('pbfa', '1');
                        $cookie_n->__set('pbfa_e', $expiry);
                        
                        $captcha_frontend = true;
                    }
                }
            }
        } else {
            if (Tools::getIsset('SubmitLogin')) {
                if (Configuration::get('RECAPTCHAPRO_FAIL_LOGINA') != 0 && $captcha_frontend == true) {
                    if ($cookie_n->__isset('pbfa')) {
                        if ($cookie_n->pbfa_e < time()) {
                            $expiry = time() + 600;
                            $cookie_n->__set('pbfa', '1');
                            $cookie_n->__set('pbfa_e', $expiry);
                        } else {
                            $cookie_n->__set('pbfa', $cookie_n->pbfa + 1);
                        }
                    } else {
                        $expiry = time() + 600;
                        $cookie_n->__set('pbfa', '1');
                        $cookie_n->__set('pbfa_e', $expiry);
                        
                        $captcha_frontend = true;
                    }
                }
            }
        }
        
        // Check the current cookie
        if (Configuration::get('RECAPTCHAPRO_FAIL_LOGINA') != 0 && $captcha_frontend == true) {
            if ($cookie_n->__isset('pbfa')) {
                if ($cookie_n->pbfa_e < time()) {
                    $expiry = time() + 600;
                    $cookie_n->__set('pbfa', '1');
                    $cookie_n->__set('pbfa_e', $expiry);
                    
                    if ($cookie_n->pbfa < Configuration::get('RECAPTCHAPRO_FAIL_LOGINA')) {
                        $captcha_frontend = false;
                    } else {
                        $captcha_frontend = true;
                    }
                } else {
                    if ($cookie_n->pbfa < Configuration::get('RECAPTCHAPRO_FAIL_LOGINA')) {
                        $captcha_frontend = false;
                    } else {
                        $captcha_frontend = true;
                    }
                }
            } else {
                $captcha_frontend = false;
            }
        }
        
        // Check if Whitelisted
        $public_ip = '';
        $whitelisted = false;
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $public_ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $public_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $public_ip = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $public_ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $public_ip = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $public_ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $public_ip = 'UNKNOWN';
        }
        
        if ($public_ip != 'UNKNOWN') {
            $sql = 'SELECT * FROM '._DB_PREFIX_.'rec_whitelist WHERE ip_address = "' . pSQL(trim($public_ip)) . '"';
            if (Db::getInstance()->ExecuteS($sql)) {
                $whitelisted = true;
            }
        }
        
        $assign = array(
            'enabled'       => 'true',
            'whitelisted'  => $whitelisted,
            'captcha_contact' => $captcha_contact,
            'captcha_frontend' => $captcha_frontend,
            'captcha_registration' => $captcha_registration,
            'captcha_resetp' => $captcha_resetp,
            'captcha_comments' => $captcha_comments,
            'captcha_newsletter' => $captcha_newsletter,
            'site_key' => Configuration::get('RECAPTCHAPRO_SITE_KEY'),
            'secret_key' => Configuration::get('RECAPTCHAPRO_SECRET_KEY'),
            'remote_ip' => $_SERVER['REMOTE_ADDR'],
            'is_https' => (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == "on" ? 1 : 0),
            'ajax_token' => Tools::getToken(false),
            're_version' => Configuration::get('RECAPTCHAPRO_RECAPTCHAV'),
            're_theme' => Configuration::get('RECAPTCHAPRO_RETHEME'),
            're_language' => $re_language,
            're_size' => Configuration::get('RECAPTCHAPRO_RESIZE'),
            'whitelist_m' => Configuration::get('RECAPTCHAPRO_WHITELISTMESSAGE', $this->context->language->id)
        );
        
        if (Tools::substr(_PS_VERSION_, 0, 3) == '1.7') {
            $this->context->smarty->assign('base_dir_ssl', $this->context->shop->getBaseURL(true, false));
        }
        
        $this->context->smarty->assign($assign);
        $this->context->smarty->assign('version', Tools::substr(_PS_VERSION_, 0, 3));
        
        return $this->display(__FILE__, 'footer.tpl');
    }
    
    public function hookActionAdminLoginControllerSetMedia()
    {
        $captcha_enable = explode(';', Configuration::get('RECAPTCHAPRO_ENABLE_FOR'));
        
        foreach ($captcha_enable as $each_e) {
            if ($each_e == 2) {
                // Check if Whitelisted
                $public_ip = '';
                if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                    $public_ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $public_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
                    $public_ip = $_SERVER['HTTP_X_FORWARDED'];
                } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                    $public_ip = $_SERVER['HTTP_FORWARDED_FOR'];
                } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
                    $public_ip = $_SERVER['HTTP_FORWARDED'];
                } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                    $public_ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $public_ip = 'UNKNOWN';
                }
                
                if ($public_ip != 'UNKNOWN') {
                    $sql = 'SELECT * FROM '._DB_PREFIX_.'rec_whitelist WHERE ip_address = "' .
                        pSQL(trim($public_ip)) . '"';
                    if (Db::getInstance()->ExecuteS($sql)) {
                    } else {
                        if ((array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == "on" ? 1 : 0)) {
                            $base_dir = 'https://' . Tools::getHttpHost(false) . __PS_BASE_URI__;
                        } else {
                            $base_dir = 'http://' . Tools::getHttpHost(false) . __PS_BASE_URI__;
                        }
                        
                        // Register the correct language for Smarty display
                        if (Configuration::get('RECAPTCHAPRO_RELANGUAGE') == 1) {
                            $re_language = $this->context->language->iso_code;
                        } elseif (Configuration::get('RECAPTCHAPRO_RELANGUAGE') == 2) {
                            $re_language = Configuration::get('RECAPTCHAPRO_CUSTOMLANGUAGE');
                        } else {
                            $re_language = 'en';
                        }
                        
                        $assign = array(
                            'there_is1' => $this->l('There is 1 error'),
                            'wrong_captcha_s_o_d' => $this->l('Wrong Captcha secret key or Duplicate submit detected.'),
                            'wrong_captcha' => $this->l('Wrong captcha.'),
                            'please_fill_captcha' => $this->l('Please fill the reCaptcha site key.'),
                            'enabled'       => 'true',
                            'site_key' => Configuration::get('RECAPTCHAPRO_SITE_KEY'),
                            'secret_key' => Configuration::get('RECAPTCHAPRO_SECRET_KEY'),
                            'remote_ip' => $_SERVER['REMOTE_ADDR'],
                            'is_https' => (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == "on" ? 1 : 0),
                            'ajax_token' => Tools::getAdminToken('AdminModules'),
                            're_version' => Configuration::get('RECAPTCHAPRO_RECAPTCHAV'),
                            're_theme' => Configuration::get('RECAPTCHAPRO_RETHEME'),
                            're_language' => $re_language,
                            're_size' => Configuration::get('RECAPTCHAPRO_RESIZE'),
                            'base_dir' => $base_dir
                        );
                        
                        if (Tools::substr(_PS_VERSION_, 0, 3) == '1.7') {
                            $base_dir_ssl_p = $this->context->shop->getBaseURL(true, false);
                            $this->context->smarty->assign('base_dir_ssl', $base_dir_ssl_p);
                        }
                        
                        $this->context->smarty->assign($assign);
                        $this->context->smarty->assign('version', Tools::substr(_PS_VERSION_, 0, 3));
                        
                        echo $this->display(__FILE__, 'views/templates/admin/footer.tpl');
                    }
                }
            }
        }
    }
}
