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

class Syncinventory extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'syncinventory';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Axus Technologies';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Synchronize Inventory');
        $this->description = $this->l('Sincronizar los inventarios de los productos con el servidor general de todofrio.');

        $this->confirmUninstall = $this->l('Esta seguro que desea des instalar este modulo ?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        
        $this->setDefaultConfigurations();

        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader');
    }

    public function setDefaultConfigurations()
    {
        Configuration::updateValue('CONNECTIONEXTERNALSERVER_LIVE_MODE', false);
        Configuration::updateValue('CONNECTIONEXTERNALSERVER_LIVE_INVENTORY', false);
        Configuration::updateValue('CONNECTIONEXTERNALSERVER_SYNC_INVENTORY_BUTTON', false);
        Configuration::updateValue('CONNECTIONEXTERNALSERVER_SYNC_PRICES_BUTTON', false);
        Configuration::updateValue('CONNECTIONEXTERNALSERVER_SERVER', '132.148.228.198');
        Configuration::updateValue('CONNECTIONEXTERNALSERVER_USER', 'user_todofrio');
        Configuration::updateValue('CONNECTIONEXTERNALSERVER_PASSWORD', 'Admin.123!');
        Configuration::updateValue('CONNECTIONEXTERNALSERVER_DB_NAME', 'datapv');
    }

    public function uninstall()
    {

        $this->deleteDefaultConfigurations();

        include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall();
    }

    public function deleteDefaultConfigurations()
    {
        Configuration::deleteByName('CONNECTIONEXTERNALSERVER_LIVE_MODE');
        Configuration::deleteByName('CONNECTIONEXTERNALSERVER_LIVE_INVENTORY');
        Configuration::deleteByName('CONNECTIONEXTERNALSERVER_SYNC_INVENTORY_BUTTON');
        Configuration::deleteByName('CONNECTIONEXTERNALSERVER_SYNC_PRICES_BUTTON');
        Configuration::deleteByName('CONNECTIONEXTERNALSERVER_SERVER');
        Configuration::deleteByName('CONNECTIONEXTERNALSERVER_USER');
        Configuration::deleteByName('CONNECTIONEXTERNALSERVER_PASSWORD');
        Configuration::deleteByName('CONNECTIONEXTERNALSERVER_DB_NAME');
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitSyncinventoryModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $this->renderForm().$output;
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
        $helper->submit_action = 'submitSyncinventoryModule';
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
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Activar módulo'),
                        'name' => 'CONNECTIONEXTERNALSERVER_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use esta opcion para habilitar el modulo.'),
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
                        'type' => 'switch',
                        'label' => $this->l('Inventario en tiempo real'),
                        'name' => 'CONNECTIONEXTERNALSERVER_LIVE_INVENTORY',
                        'is_bool' => true,
                        'desc' => $this->l('Esta opción permite consultar las existencias de los productos en tiempo real con el servidor establecido.'),
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
                        'type' => 'switch',
                        'label' => $this->l('Sincronizar existencias manualmente'),
                        'name' => 'CONNECTIONEXTERNALSERVER_SYNC_INVENTORY_BUTTON',
                        'is_bool' => true,
                        'desc' => $this->l('Habilitará un botón en el listado de productos para sincronizar las existencias manualmente.'),
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
                        'type' => 'switch',
                        'label' => $this->l('Sincronizar precios manualmente'),
                        'name' => 'CONNECTIONEXTERNALSERVER_SYNC_PRICES_BUTTON',
                        'is_bool' => true,
                        'desc' => $this->l('Habilitará un botón en el listado de productos para sincronizar los precios manualmente.'),
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
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Introdusca la dirección del servidor'),
                        'name' => 'CONNECTIONEXTERNALSERVER_SERVER',
                        'label' => $this->l('Servidor'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Introdusca el usuario de la base de datos'),
                        'name' => 'CONNECTIONEXTERNALSERVER_USER',
                        'label' => $this->l('Usuario'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Contraseña de la base de datos a conectarse.'),
                        'name' => 'CONNECTIONEXTERNALSERVER_PASSWORD',
                        'label' => $this->l('Contraseña'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-envelope"></i>',
                        'desc' => $this->l('Introdusca el nombre de la base de datos'),
                        'name' => 'CONNECTIONEXTERNALSERVER_DB_NAME',
                        'label' => $this->l('Base de datos'),
                    ),
                ),
                'buttons' => array(
                    'test-conn' => array(
                        'title' => $this->l('Probar Conexión'),
                        'name'  => 'sync_test_conn',
                        'type'  => 'button',
                        'id'    => 'SyncTestConnButton',
                        'class' => 'btn btn-default pull-right',
                        'icon'  => 'process-icon-database',
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
            'CONNECTIONEXTERNALSERVER_LIVE_MODE'                => Configuration::get('CONNECTIONEXTERNALSERVER_LIVE_MODE', false),
            'CONNECTIONEXTERNALSERVER_LIVE_INVENTORY'           => Configuration::get('CONNECTIONEXTERNALSERVER_LIVE_INVENTORY', false),
            'CONNECTIONEXTERNALSERVER_SYNC_INVENTORY_BUTTON'    => Configuration::get('CONNECTIONEXTERNALSERVER_SYNC_INVENTORY_BUTTON', false),
            'CONNECTIONEXTERNALSERVER_SYNC_PRICES_BUTTON'       => Configuration::get('CONNECTIONEXTERNALSERVER_SYNC_PRICES_BUTTON', false),
            'CONNECTIONEXTERNALSERVER_SERVER'       => Configuration::get('CONNECTIONEXTERNALSERVER_SERVER', '132.148.228.198'),
            'CONNECTIONEXTERNALSERVER_USER'         => Configuration::get('CONNECTIONEXTERNALSERVER_USER', 'user_guest'),
            'CONNECTIONEXTERNALSERVER_PASSWORD'     => Configuration::get('CONNECTIONEXTERNALSERVER_PASSWORD', 'C1l?DoeGL+fl'),
            'CONNECTIONEXTERNALSERVER_DB_NAME'      => Configuration::get('CONNECTIONEXTERNALSERVER_DB_NAME', 'datapv'),

        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
       
        if (Tools::getValue('configure') == 'syncinventory') {
            Media::addJsDef(array('baseDir' => $this->context->link->getModuleLink($this->name, 'syncinventory_ajax_test_conn', array(), true)));
            $this->context->controller->addJS($this->_path.'views/js/syncinventory.js');
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
}
