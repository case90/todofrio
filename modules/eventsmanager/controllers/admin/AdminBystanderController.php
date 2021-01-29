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
use Twilio\Rest\Client;
/**
 * @since 1.6.0
 */
class AdminBystanderController extends ModuleAdminController
{

	protected $_defaultOrderBy = 'a!fullname';
    protected $_defaultOrderWay = 'ASC';
    protected $id_event_manager;

    public function __construct()
    {

        $this->bootstrap = true;
        $this->table = 'bystander';
        $this->className = 'Bystander';
        $this->lang = false;
        $this->allow_export = true;
        $this->explicitSelect = true;
        $this->context = Context::getContext();
        $this->_use_found_rows = false;

        if(Tools::getValue('id_event_manager')){

            $this->context->cookie->id_event_manager_bystander = Tools::getValue('id_event_manager');
        }

        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Borrar Seleccionados'),
                'confirm' => $this->l('Borrar las filas seleccionadas ?'),
                'icon' => 'icon-trash'
            )
        );

        $this->fields_list = array(
            'id_bystander' => array(
                'title' => $this->l('Folio'),
                'filter_key' => 'a!id_bystander',
            ),
            'fullname' => array(
                'title' => $this->l('Nombre'),
                'filter_key' => 'a!fullname',
            ),
            'business_name' => array(
                'title' => $this->l('Razón Social'),
                'filter_key' => 'a!business_name',
            ),
            'curp' => array(
                'title' => $this->l('CURP'),
                'filter_key' => 'a!curp',
            ),
            'phone1' => array(
                'title' => $this->l('Teléfono'),
                'filter_key' => 'a!phone1',
            ),
            'phone2' => array(
                'title' => $this->l('Cel'),
                'filter_key' => 'a!phone2',
            ),
            /*'company' => array(
                'title' => $this->l('Compañía')
            ),*/
            'email' => array(
                'title' => $this->l('Correo Electrónico'),
                'filter_key' => 'a!email',
            ),
            'date_add' => array(
                'title' => $this->l('Fecha de inscripción'),
                'filter_key' => 'a!date_add',
            ),
            /*'total_spent' => array(
                'title' => $this->l('Total Compras'),
                'type' => 'price',
                'search' => false,
                'havingFilter' => true,
                'align' => 'text-right',
                'badge_success' => true
            ),*/
            'attended_event' => array(
                'title' => $this->l('Asistió'),
                'class' => 'fixed-width-xs',
                'active' => 'attended',
                'align' => 'text-center',
                'type' => 'bool',
                'ajax' => true,
                'orderby' => false
            ),
        );

        parent::__construct();
        $this->_where = 'AND a.id_event_manager = '.$this->context->cookie->id_event_manager_bystander;   
    }

    public function setMedia()
    {
        parent::setMedia();
        $this->addCSS('https://use.fontawesome.com/releases/v5.0.13/css/all.css'); 
    }

    public function renderForm()
    {
       
        /** @var Customer $obj */
        if (!($obj = $this->loadObject(true))) {
            return;
        }

        $this->fields_value = array(
            'id_event_manager' => $this->context->cookie->id_event_manager_bystander
        );

        $id_bystander = [];
        if(array_key_exists('updateevent_manager_bystander', Tools::getAllValues())){

            $bystander = new Bystander(Tools::getValue('id_event_manager_bystander'));
            $this->fields_value = array(
                'id_bystander' => $bystander->id_bystander
            );
            $id_bystander = array(
                'type' => 'hidden',
                'label' => $this->l('Cliente'),
                'name' => 'id_bystander',
                'required' => true,
                'class' => 'fixed-width-xxl',
    
            );

        }
        

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Agregar Participante'),
                'icon' => 'icon-user'
            ),
            'input' => array(
                array(
                    'type' => 'hidden',
                    'label' => $this->l('Folio Evento'),
                    'name' => 'id_event_manager',
                    'required' => true,
                    'class' => 'fixed-width-xxl',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Nombre'),
                    'name' => 'name',
                    'required' => true,
                    'class' => 'fixed-width-xxl',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Apellido Paterno'),
                    'name' => 'paternal_name',
                    'required' => true,
                    'class' => 'fixed-width-xxl',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Apellido Materno'),
                    'name' => 'maternal_name',
                    'required' => true,
                    'class' => 'fixed-width-xxl',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Razón Social'),
                    'name' => 'business_name',
                    'required' => true,
                    'class' => 'fixed-width-xxl',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Teléfono'),
                    'name' => 'phone1',
                    'required' => true,
                    'class' => 'fixed-width-xxl',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Celular'),
                    'name' => 'phone2',
                    'required' => false,
                    'class' => 'fixed-width-xxl',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Correo Electrónico'),
                    'name' => 'email',
                    'required' => true,
                    'class' => 'fixed-width-xxl',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('CURP'),
                    'name' => 'curp',
                    'required' => true,
                    'class' => 'fixed-width-xxl',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Lugar de Origen'),
                    'name' => 'place_origin',
                    'required' => false,
                    'class' => 'fixed-width-xxl',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Asistió a evento'),
                    'name' => 'attended_event',
                    'is_bool' => true,
                    'desc' => $this->l('Especifica si el cliente asistió al evento.'),
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
                            
            )
        );


        $this->fields_form['submit'] = array(
            'title' => $this->l('Save'),
        );

        return parent::renderForm();
    }

    public static function getFullNameCustomers($only_active = null, $id_event_manager)
    {
  
        $sql = 'SELECT 
                    b.`id_bystander`, 
                    b.`email`, 
                    CONCAT("ID: ", b.`fullname`, " / ", b.`fullname`) as fullname 
                FROM `'._DB_PREFIX_.'bystander` b
                LEFT JOIN 
                    `ps_event_manager_bystander` emb ON (emb.id_bystander = b.id_bystander AND emb.id_event_manager = '.$id_event_manager.')
                WHERE 1 AND emb.id_event_manager_bystander IS NULL
                ORDER BY `id_bystander` ASC';


        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
    }

    public function initToolbar()
    {
        parent::initToolbar();
        $this->toolbar_btn['syncprices'] = array(
            'href' => $this->context->link->getAdminLink('AdminBystander', true).'&id_event_manager='.(int)Tools::getValue('id_event_manager').'&sendmail=true',
            'desc' => $this->l('Enviar correo'),
            'class' => 'icon-mail-forward'
        );
    }

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

        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Cache-Control: no-store, no-cache');
        header('Content-disposition: attachment; filename="'.$this->table.'_'.date('Y-m-d_His').'.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

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
            'export_precontent' => "\xEF\xBB\xBF",
            'export_headers' => $headers,
            'export_content' => $content,
            'text_delimiter' => $text_delimiter
            )
        );

        $this->layout = 'layout_export_columns_format.tpl';
    }

    public function postProcess()
    {
        parent::postProcess();
        if(Tools::getValue('sendmail'))
        {
            $mails = Bystander::getMailingListForAllBystanderByEvent((int)Tools::getValue('id_event_manager'));
            $this->sendMailing($mails);
        }

    }

    public function sendMailing($mails)
    {
        $result = [];
        $mailes = [
            ['email' => 'alejandrose90@gmail.com', 'fullname' => 'Cesar 1'],
            ['email' => 'alejandro_se90@hotmail.com', 'fullname' => 'Cesar 2'],
            ['email' => 'case_evil@hotmail.com', 'fullname' => 'Cesar 3'],
        ];
        $shop_name          = Configuration::get('PS_SHOP_NAME');
        $id_event_manager   = (int)Tools::getValue('id_event_manager');
        $bystanders         = Bystander::getBystandersByEventManagerId($id_event_manager);

        //foreach($mailes as $b){
        foreach($bystanders as $b){

            if(!Validate::isEmail( $b['email'])){
                $result['mailErrors'][] = $b['email'];
                continue;
            }
            
            if(empty($result['mailErrors'])){
                $params = array(
                    '{shop_name}'   => $shop_name,
                    '{name}'        => $b['fullname'],
                );

                $objBastender = new Bystander((int)$b['id_bystander']);
                if($objBastender->type_mail_sent == 0){
                    $mail = Mail::Send(
                        Context::getContext()->language->id, 
                        'send_remainder_bystander', 
                        'Expo Todofrio', 
                        $params, 
                        $b['email']
                    );
                    if($mail){
                        Db::getInstance()->update(`'._DB_PREFIX_`.'bystander', ['type_mail_sent' => 1], 'id_bystander = '.$b['id_bystander'] );
                    }else{
                        $result['mailErrors'][] = $b;
                        $this->errors[] = $this->l($b['fullname'].' - '.$b['email']);
                    }
                    
                    $result['sendedMails'][] = $b;

                }

            }
        
        }
        d($result);
        return $result;
    }

    public function sendWhatsAppMessagge($mails)
    {


        $sid    = "AC5ca3226ecf575c68c830f178efe948b6";
        $token  = "efd8cd214cb31c9d8ccd1606a3475719";
        $twilio = new Client($sid, $token);
        $message = $twilio->messages
                  ->create("whatsapp:+5218110153582",
                           array(
                               "body" => "Hello there!",
                               "from" => "whatsapp:+14155238886"
                           )
                  );
        print($message->sid);
        d($message);
        return;
        /*$shop_name = Configuration::get('PS_SHOP_NAME');
        

        $mailes = [
            ['email' => 'alejandrose90@gmail.com', 'fullname' => 'Cesar 1'],
            ['email' => 'alejandro_se90@hotmail.com', 'fullname' => 'Cesar 2'],
            ['email' => 'case_evil@hotmail.com', 'fullname' => 'Cesar 3'],
        ];

      
        foreach($mailes as $bystander){
            $params = array(
                '{shop_name}' => $shop_name,
                '{name}' => $bystander['fullname'],
            );
            
            $mail = Mail::Send(
                Context::getContext()->language->id, 
                'send_remainder_bystander', 
                'Expo Todofrio', 
                $params, 
                $bystander['email'], 
                $bystander['fullname']
            );
            p($mail);
        }
        /*
        $result = Mail::Send(
            $employee->id_lang, 
            'employee_password', 
            Mail::l('Your new password', $employee->id_lang), 
            $params, 
            $employee->email, 
            $employee->firstname.' '.$employee->lastname
        );*/

        
    }

    public function ajaxProcessAttendedBystander()
    {
        if (!$id_bystander = (int)Tools::getValue('id_bystander')) {
            die(Tools::jsonEncode(array('success' => false, 'error' => true, 'text' => $this->l('Failed to update the status'))));
        } else {
            $bystander = new Bystander((int)$id_bystander);
            if (Validate::isLoadedObject($bystander)) {
                $bystander->attended_event = $bystander->attended_event == 1 ? 0 : 1;
                $bystander->date_add = date("Y-m-d H:m:s");
                $bystander->date_upd = date("Y-m-d H:m:s");
                $bystander->save() ?
                die(Tools::jsonEncode(array('success' => true, 'text' => $this->l('Se ha editado correctamente el participante')))) :
                die(Tools::jsonEncode(array('success' => false, 'error' => true, 'text' => $this->l('Failed to update the status'))));
            }
        }
    }

}