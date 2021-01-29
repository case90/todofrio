<?php
/*
* 2007-2016 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since 1.6.0
 */
class AdminEventManagerController extends ModuleAdminController
{

	protected $_defaultOrderBy = 'id_event_manager';
    protected $_defaultOrderWay = 'DESC';

    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'event_manager';
        $this->className = 'EventManager';
        $this->lang = false;
        $this->allow_export = true;
        $this->explicitSelect = true;
        $this->context = Context::getContext();
        $this->_use_found_rows = false;

        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->addRowAction('bystander');

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Borrar Seleccionados'),
                'confirm' => $this->l('Borrar las filas seleccionadas ?'),
                'icon' => 'icon-trash'
            )
        );
     
        $this->fields_list = array(
            'id_event_manager' => array(
                'title' => $this->l('Folio'),
                'align' => 'text-center',
                'class' => 'fixed-width-xs'
            ),
            'title' => array(
                'title' => $this->l('Titulo')
            ),
            'event_place' => array(
                'title' => $this->l('Lugar del Evento')
            ),
            'address' => array(
                'title' => $this->l('Dirección')
            ),
            /*'total_bystander' => array(
                'title' => $this->l('Participantes'),
                'align' => 'text-center',
                'class' => 'fixed-width-xs',
                'search' => false,
                'badge_success' => true
            ),*/
            'event_date' => array(
                'title' => $this->l('Fecha del Evento'),
                'type' => 'date',
            )
        );

        /*$this->_select = '
        (
            SELECT COUNT(em.id_event_manager_bystander)
            FROM '._DB_PREFIX_.'event_manager_bystander em
            WHERE a.id_event_manager = em.id_event_manager
        ) as total_bystander';*/
        
        parent::__construct();

    }

    public function displayBystanderLink($token = null, $id, $name = null)
    {
        

        $tpl = $this->createTemplate('helpers/list/list_action_edit.tpl');
        if (!array_key_exists('Participantes', self::$cache_lang))
            self::$cache_lang['Participantes'] = $this->l('Participantes', 'Helper');
    
        $tpl->assign(array(
                'href' => $this->context->link->getAdminLink('AdminBystander', true).'&'.$this->identifier.'='.$id,
                'action' => self::$cache_lang['Participantes'],
                'id' => $id
        ));
    
        return $tpl->fetch();
    }


    public function renderForm()
    {
        /** @var Customer $obj */
        if (!($obj = $this->loadObject(true))) {
            return;
        }

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Agregar Eventos'),
                'icon' => 'icon-user'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Titulo'),
                    'name' => 'title',
                    'required' => true,
                    'col' => '4',
                    'hint' => $this->l('Invalid characters:').' 0-9!&lt;&gt;,;?=+()@#"°{}_$%:'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Lugar del Evento'),
                    'name' => 'event_place',
                    'required' => false,
                    'col' => '4'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Dirección'),
                    'name' => 'address',
                    'required' => false,
                    'col' => '4'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Latitude'),
                    'name' => 'lat',
                    'required' => false,
                    'col' => '4'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Longitud'),
                    'name' => 'lang',
                    'required' => false,
                    'col' => '4'
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Fecha de Evento'),
                    'name' => 'event_date',
                    'required' => true,
                    'col' => '4',
                    'hint' => $this->l('Invalid characters:').' 0-9!&lt;&gt;,;?=+()@#"°{}_$%:'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Activo'),
                    'name' => 'active',
                    'is_bool' => true,
                    'desc' => $this->l('Especifica si el evento está activo.'),
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
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Descripción'),
                    'name' => 'description',
                    'col' => '8',
                    'rows' => '15',
                    'class' => 'rte',
                    'required' => false,
                    
                ),
            
            )
        );

        $this->fields_form['submit'] = array(
            'title' => $this->l('Save'),
        );

        return parent::renderForm();
    }

    public function listBystanderTable($id_event_manager)
    {
        $fields_list = array(
            
            'id_event_manager_bystander' => array(
                'title' => $this->l('Folio de Evento'),
                'type' => 'text',
            ),
            'id_customer' => array(
                'title' => $this->l('Folio del Cliente'),
                'type' => 'text',
            ),
            'firstname' => array(
                'title' => $this->l('Nombre'),
                'type' => 'text',
            ),
            'lastname' => array(
                'title' => $this->l('Apellido'),
                'type' => 'text',
            ),
            'email' => array(
                'title' => $this->l('Correo Electrónico'),
                'type' => 'text',
            ),

        );

        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = true;
        $helper->actions = array('edit', 'delete', 'view');

        $helper->identifier = 'id_event_manager_bystander';
        $helper->show_toolbar = true;
        $helper->allow_export   = true;
        $helper->title = 'Clientes';
        $helper->table = 'event_manager_bystander';
    
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        return $helper->generateList($this->getBystanderContent(), $fields_list);
    }

    public function getBystanderContent()
    {
        $sql = '
            SELECT emb.id_event_manager_bystander, b.* FROM `'._DB_PREFIX_.'event_manager_bystander` emb
            LEFT JOIN `'._DB_PREFIX_.'bystander` b ON b.id_bystander = emb.id_bystander;
        ';

        $content = Db::getInstance()->executeS($sql);

        return $content;
    }

    public function setMedia()
    {
    	parent::setMedia();
    	$this->addJs(_PS_MODULE_DIR_.'/eventsmanager/views/js/back.js');
    }

    /**
     * @param string $text_delimiter
     * @throws PrestaShopException
     */
    public function processExport($text_delimiter = '"')
    {
        // clean buffer
        if (ob_get_level() && ob_get_length() > 0) {
            ob_clean();
        }
        $this->getList($this->context->language->id, null, null, 0, false);
        if (!count($this->_list)) {
            return;
        }

        header('Content-type: text/csv');
        header('Content-Type: application/force-download; charset=UTF-8');
        header('Cache-Control: no-store, no-cache');
        header('Content-disposition: attachment; filename="'.$this->table.'_'.date('Y-m-d_His').'.csv"');

        $headers = array();

        foreach ($this->fields_list as $key => $datas) {
            if ($datas['title'] == 'PDF') {
                unset($this->fields_list[$key]);
            } else {
                $headers[] = Tools::htmlentitiesDecodeUTF8($datas['title']);
            }
        }
        $content = array();
        foreach ($this->_list as $i => $row) {
            $content[$i] = array();
            $path_to_image = false;
            foreach ($this->fields_list as $key => $params) {
                $field_value = isset($row[$key]) ? Tools::htmlentitiesDecodeUTF8(Tools::nl2br($row[$key])) : '';
                if ($key == 'image') {
                    if ($params['image'] != 'p' || Configuration::get('PS_LEGACY_IMAGES')) {
                        $path_to_image = Tools::getShopDomain(true)._PS_IMG_.$params['image'].'/'.$row['id_'.$this->table].(isset($row['id_image']) ? '-'.(int)$row['id_image'] : '').'.'.$this->imageType;
                    } else {
                        $path_to_image = Tools::getShopDomain(true)._PS_IMG_.$params['image'].'/'.Image::getImgFolderStatic($row['id_image']).(int)$row['id_image'].'.'.$this->imageType;
                    }
                    if ($path_to_image) {
                        $field_value = $path_to_image;
                    }
                }
                if (isset($params['callback'])) {
                    $callback_obj = (isset($params['callback_object'])) ? $params['callback_object'] : $this->context->controller;
                    if (!preg_match('/<([a-z]+)([^<]+)*(?:>(.*)<\/\1>|\s+\/>)/ism', call_user_func_array(array($callback_obj, $params['callback']), array($field_value, $row)))) {
                        $field_value = call_user_func_array(array($callback_obj, $params['callback']), array($field_value, $row));
                    }
                }
                $content[$i][] = $field_value;
            }
        }

        $this->context->smarty->assign(array(
            'export_precontent' => "",
            'export_headers' => $headers,
            'export_content' => $content,
            'text_delimiter' => $text_delimiter
            )
        );

        $this->layout = 'custom_templates/export/layout-formated_columns.tpl';
    }

   
}