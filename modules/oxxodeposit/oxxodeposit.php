<?php
/**
* 2007-2018 PrestaShop
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
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Oxxodeposit extends PaymentModule
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'oxxodeposit';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = 'Alex Segura';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Oxxo Deposit');
        $this->description = $this->l('Permite hacer deposito en establecimientos como oxxo y seven');

        $this->confirmUninstall = $this->l('Esta seguro que desea des instalar este modulo ?');

        $this->limited_countries = array('MX');

        $this->limited_currencies = array('MXN');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        include(dirname(__file__) . '/sql/install.php');

        if (extension_loaded('curl') == false)
        {
            $this->_errors[] = $this->l('You have to enable the cURL extension on your server to install this module');
            return false;
        }

        $iso_code = Country::getIsoById(Configuration::get('PS_COUNTRY_DEFAULT'));

        if (in_array($iso_code, $this->limited_countries) == false)
        {
            $this->_errors[] = $this->l('This module is not available in your country');
            return false;
        }

        Configuration::updateValue('OXXODEPOSIT_LIVE_MODE', true);
        Configuration::updateValue('OXXODEPOSIT_DEFAULT_ORDER_PAYMENT', 2);

        /*$this->addOrderStates('Esperando comprobante de deposito', '#9804F0', 'waiting_proof_payment');
        $this->addOrderStates('Verificando depósito', '#329ACF', 'check_payment');*/

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('payment') &&
            $this->registerHook('paymentReturn') &&
            $this->registerHook('actionPaymentConfirmation') &&
            $this->registerHook('displayPayment') &&
            $this->registerHook('displayPaymentReturn') &&
            $this->registerHook('displayPaymentTop');
    }

    public function uninstall()
    {
    
        /*$sql = 'SELECT * FROM '._DB_PREFIX_.'oxxodeposit_order_states';
        if ($results = Db::getInstance()->ExecuteS($sql)){
            foreach ($results as $row){
                $order_state = new OrderState($row['id_order_state']);
                $order_state->delete();
                
            }
        }*/

        include(dirname(__file__) . '/sql/uninstall.php');
        Configuration::deleteByName('OXXODEPOSIT_LIVE_MODE');

        return parent::uninstall();
    }

    public function addOrderStates($name, $color, $template)
    {  
        
        $state_exist = false;
        $states = OrderState::getOrderStates((int)$this->context->language->id);
 
        // check if order state exist
        foreach ($states as $state) {
            if (in_array($name, $state)) {
                $state_exist = true;
                break;
            }
        }

        if (!$state_exist) {

            $order_state = new OrderState();
            $order_state->color = $color;
            $order_state->send_email = true;
            $order_state->module_name = 'oxxodeposit';
            $order_state->template = $template;
            $order_state->name = array();
            $languages = Language::getLanguages(false);
            foreach ($languages as $language)
                $order_state->name[ $language['id_lang'] ] = $name;

            $order_state->add();

            return Db::getInstance()->insert('oxxodeposit_order_states', array(
                'id_order_state'    => (int)$order_state->id,
                'name'              => pSQL('OXXODEPOSIT_STATE_'.$order_state->id),
            ));

          
        }


    }

    public static function getState($name)
    {
        $sql = 'SELECT * FROM '._DB_PREFIX_.'oxxodeposit_order_states WHERE name = "'.$name.'" ';
        if ($results = Db::getInstance()->ExecuteS($sql))
            foreach ($results as $row)
                return (int)$row['id_order_state']; 

    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitOxxodepositModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $this->renderForm();
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
        $helper->submit_action = 'submitOxxodepositModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {

        $allStates = OrderState::getOrderStates((int)$this->context->language->id);

        $options = array(
            array(
                'id_option' => 1,       // The value of the 'value' attribute of the <option> tag.
                'name' => 'Method 1'    // The value of the text content of the  <option> tag.
            ),
            array(
                'id_option' => 2,
                'name' => 'Method 2'
            ),
        );

        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Live mode'),
                        'name' => 'OXXODEPOSIT_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in live mode'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'select',                              // This is a <select> tag.
                        'label' => $this->l('Estatus predeterminado:'),         // The <label> for this <select> tag.
                        'desc' => $this->l('Estatus predeterminado con el que se creará la orden al hacer un pago mediante este módulo'),  // A help text, displayed right next to the <select> tag.
                        'name' => 'OXXODEPOSIT_DEFAULT_ORDER_PAYMENT',                     // The content of the 'id' attribute of the <select> tag.
                        'required' => true,                              // If set to true, this option must be set.
                        'options' => array(
                            'query' => $allStates,                           // $options contains the data itself.
                            'id' => 'id_order_state',                           // The value of the 'id' key must be the same as the key for 'value' attribute of the <option> tag in each $options sub-array.
                            'name' => 'name'                               // The value of the 'name' key must be the same as the key for the text content of the <option> tag in each $options sub-array.
                        )
                    ),
                    array(
                        'col' => 8,
                        'type' => 'textarea',
                        'rows' => 10,
                        'cols' => 10,
                        'class' => 'rte',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Enter a valid email address'),
                        'name' => 'OXXODEPOSIT_INFO',
                        'label' => $this->l('Información general'),
                    ),
                    array(
                        'col' => 8,
                        'type' => 'textarea',
                        'rows' => 10,
                        'cols' => 10,
                        'class' => 'rte',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Enter a valid email address'),
                        'name' => 'OXXODEPOSIT_INFO_FOOTER',
                        'label' => $this->l('Información pie de pagina'),
                    ),
                 
                ),
                'submit' => array(
                    'title' => $this->l('Guardar'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'OXXODEPOSIT_LIVE_MODE' => Configuration::get('OXXODEPOSIT_LIVE_MODE'),
            'OXXODEPOSIT_INFO' => Configuration::get('OXXODEPOSIT_INFO'),
            'OXXODEPOSIT_INFO_FOOTER' => Configuration::get('OXXODEPOSIT_INFO_FOOTER'),
            'OXXODEPOSIT_DEFAULT_ORDER_PAYMENT' => Configuration::get('OXXODEPOSIT_DEFAULT_ORDER_PAYMENT'),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key), true);
        }
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }


    public function hookDisplayPayment($params)
    {
        $currency_id = $params['cart']->id_currency;
        $currency = new Currency((int)$currency_id);

        if (in_array($currency->iso_code, $this->limited_currencies) == false)
            return false;

        $this->smarty->assign('module_dir', $this->_path);
        return $this->display(__FILE__, 'displayPayment.tpl');

    }

    public function hookDisplayPaymentReturn($params)
    {

        /* Place your code here. */
        if ($this->active == false)
            return;

        $order = $params['objOrder'];

        if ($order->getCurrentOrderState()->id != Configuration::get('PS_OS_ERROR'))
            $this->smarty->assign('status', 'ok');

        $this->smarty->assign(array(
            'info_deposit' => Configuration::get('OXXODEPOSIT_INFO'),
            'info_footer' => Configuration::get('OXXODEPOSIT_INFO_FOOTER'),
            'id_order' => $order->id,
            'reference' => $order->reference,
            'params' => $params,
            'status' => 'ok',
            'current_date' => date('d/m/Y'),
            'total' => Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false),
        ));

        return $this->display(__FILE__, 'views/templates/hook/confirmation.tpl');
    }

    public function hookActionPaymentConfirmation()
    {
        /* Place your code here. */
    }

    public function hookDisplayPaymentTop()
    {
        /* Place your code here. */
    }

    /**
     * This method is used to render the payment button,
     * Take care if the button should be displayed or not.
     */
    public function hookPayment($params)
    {
        /**
         * THIS HOOK NOT WORK USE INSTEAD "hookDisplayPayment"
         */
    }

    /**
     * This hook is used to display the order confirmation page.
     */
    public function hookPaymentReturn($params)
    {

        /**
         * THIS HOOK NOT WORK USE INSTEAD "hookDisplayPaymentReturn"
         */

    }
}
