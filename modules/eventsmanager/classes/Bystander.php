<?php
/*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class Bystander extends ObjectModel
{
    public $id_bystander;
	public $id_event_manager;
    public $name;
    public $paternal_name;
    public $maternal_name;
    public $fullname;
    public $business_name;
    public $phone1;
    public $phone2;
    public $email;
    public $curp;
    public $place_origin;
    public $attended_event;
    public $type_mail_sent;
    public $date_add;
    public $date_upd;

    public static $definition = array(
    	'table' => 'bystander',
        'primary' => 'id_bystander',
        'fields' => array(
            'id_event_manager'  =>   array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'name'              =>   array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
            'paternal_name'     => 	 array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
            'maternal_name'     =>   array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
            'fullname'          =>   array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 70),
            'business_name'     =>   array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 70),
            'phone1'            =>   array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'required' => true, 'size' => 32),
            'phone2'            =>   array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'required' => true, 'size' => 32),
            'email'             =>   array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 128),
            'curp'              =>   array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 32),
            'place_origin'      =>   array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 32, 'size' => 70),
            'attended_event'    =>   array('type' => self::TYPE_BOOL, 'validate' => 'isUnsignedId', 'required' => false),
            'type_mail_sent'        =>   array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => false),
            'date_add'          =>   array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd'          =>   array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );

    public function __construct($id = null, $id_lang = null)
    {
    	parent::__construct($id);
        $this->curp = strtoupper($this->curp);
    	if (!is_null($id_lang)) {
            $this->id_lang = (int)(Language::getLanguage($id_lang) !== false) ? $id_lang : Configuration::get('PS_LANG_DEFAULT');
        }
    }

    public function add($autodate = true, $null_values = false)
    {
        $this->fullname = $this->name.' '.$this->paternal_name.' '.$this->maternal_name;
        $this->curp = trim($this->curp);

        $validateCurpFormat = $this->validateCurpFormat($this->curp);
        if(!$validateCurpFormat['success']){
            throw new PrestaShopException('<strong>Error: </strong> '.$validateCurpFormat['message']);
            return false;
        }

        $issetBystander = Db::getInstance()->executeS('
            SELECT EXISTS(
                SELECT 
                    b.`id_bystander` 
                FROM `'._DB_PREFIX_.'bystander` b 
                WHERE b.`id_event_manager` = '.$this->id_event_manager.' AND b.`curp` = "'.$this->curp.'"
            ) AS issetBystander'
        );

        if($issetBystander[0]['issetBystander']){
            throw new PrestaShopException('<strong>Error: </strong> El CURP capturado para el participante ya existe en este evento.');
            return false;
        }
        
        $return = parent::add($autodate, $null_values);
        Hook::exec('actionAdminAfterAddBystander', 
            array(
                'bystander' => $this
            )
        );
        return $return;
    }

    public function update($autodate = true, $null_values = false)
    {
        $this->fullname = $this->name.' '.$this->paternal_name.' '.$this->maternal_name;
        $this->curp = trim($this->curp);

        $validateCurpFormat = $this->validateCurpFormat($this->curp);
        if(!$validateCurpFormat['success']){
            throw new PrestaShopException('<strong>Error: </strong> '.$validateCurpFormat['message']);
            return false;
        }

        $wasChangedCurp = Db::getInstance()->executeS('
            SELECT 
                b.`curp` 
            FROM `'._DB_PREFIX_.'bystander` b 
            WHERE b.`id_bystander` = '.$this->id_bystander
        );

        if($wasChangedCurp[0]['curp'] !== $this->curp){

            $issetBystander = Db::getInstance()->executeS('
                SELECT EXISTS(
                    SELECT 
                        b.`id_bystander` 
                    FROM `'._DB_PREFIX_.'bystander` b 
                    WHERE b.`id_event_manager` = '.$this->id_event_manager.' AND b.`curp` = "'.$this->curp.'"
                ) AS issetBystander'
            );

            if($issetBystander[0]['issetBystander']){
                throw new PrestaShopException('<strong>Error: </strong> El CURP capturado para el participante ya existe en este evento.');
                return false;
            }
        }

        $return = parent::update($autodate, $null_values);
        return $return;
    }

    public static function issetCurpInEvent($id_event_manager, $curp)
    {
        if(!$id_event_manager && !$curp)
            return false;

        $result = Db::getInstance()->executeS('
            SELECT EXISTS(
                SELECT 
                    b.`id_bystander` 
                FROM `'._DB_PREFIX_.'bystander` b 
                WHERE b.`id_event_manager` = '.(int)$id_event_manager.' AND b.`curp` = "'.$curp.'"
            ) AS issetBystander'
        );

        return (bool)$result[0]['issetBystander'];
    }


    /**
     *
     * Valida el formato del CURP
     *
     */
    public static function validateCurpFormat(&$curp)
    {

        $result = [];

        $curp = strtoupper( trim($curp) );
        if(strlen($curp) !== 18){

            $result = array(
                "success" => false,
                "message" => 'La longitud del CURP debe ser de 18 caracteres.'
            );
            
            return $result;
        }
            
        $letras     = substr($curp, 0, 4);
        $numeros    = substr($curp, 4, 6);         
        $sexo       = substr($curp, 10, 1);
        $mxState    = substr($curp, 11, 2); 
        $letras2    = substr($curp, 13, 3); 
        $homoclave  = substr($curp, 16, 2);

        if(ctype_alpha($letras) && 
            ctype_alpha($letras2) && 
            ctype_digit($numeros) && 
            ctype_alnum($homoclave) && 
            self::is_mx_state($mxState) && 
            self::is_sexo_curp($sexo))
        { 
            // seec900503hnlgss02
            $result = array(
                "success" => true,
                "message" => 'Ok'
            );

        }else{

            $result = array(
                "success" => false,
                "message" => 'El formato del CURP introducido no es correcto, favor de verificarlo.'
            );
        
        }

        return $result;

    }

    public static function is_mx_state($state)
    {     
        $mxStates = [         
            'AS','BS','CL','CS','DF','GT',         
            'HG','MC','MS','NL','PL','QR',         
            'SL','TC','TL','YN','NE','BC',         
            'CC','CM','CH','DG','GR','JC',         
            'MN','NT','OC','QT','SP','SR',         
            'TS','VZ','ZS'    
        ];     
        if(in_array(strtoupper($state), $mxStates)){         
            return true;     
        }     
        return false; 
    }

    public static function is_sexo_curp($sexo)
    {     
        $sexoCurp = ['H','M'];     
        if(in_array(strtoupper($sexo),$sexoCurp)){         
            return true;     
        }     
        return false; 
    }

    public static function getMailingListForAllBystanderByEvent($id_event_manager)
    {
        if(!$id_event_manager)
            return false;

        $sql = '
            SELECT 
                LOWER(TRIM(b.`email`)) as email,
                b.fullname
            FROM `'._DB_PREFIX_.'bystander` b 
            WHERE b.`id_event_manager` = '.$id_event_manager;

        return Db::getInstance()->executeS($sql);
     
    }

    public static function getBystandersByEventManagerId($id_event_manager)
    {
        if(!(int)$id_event_manager)
            return false;

        $sql = new DbQuery();
        $sql->select('*');
        $sql->from(self::$definition['table']);
        $sql->where('id_event_manager = '.$id_event_manager);
        return Db::getInstance()->executeS($sql);
    }
}