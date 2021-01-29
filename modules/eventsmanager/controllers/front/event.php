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


 
class EventsManagerEventModuleFrontController extends ModuleFrontController
{ 
	public function initContent()
	{
		$this->display_column_left = true;
		$this->display_column_right = false;

		if(!Configuration::get('EVENTSMANAGER_LIVE_MODE'))
			Tools::redirect('index.php');

		parent::initContent();
		
		
	}

	public function postProcess()
	{
		
		if( !EventManager::isActive((int)Tools::getValue('id_event_manager')) )
			Tools::redirect('index.php');
			
		if(Tools::getValue('action'))
		{
			switch(Tools::getValue('action'))
			{

				/**
				 *
				 * Muestra la información del evento
				 *
				 */
				case 'showevent':

					if(!Tools::getValue('id_event_manager'))
						return false;

					$issetEvent = EventManager::issetEvent(Tools::getValue('id_event_manager'));
					if(!$issetEvent)
						return false;

					$eventManager = new EventManager(Tools::getValue('id_event_manager'));
					$this->context->smarty->assign(array(
						'success' 	=> Tools::getValue('success') ? Tools::getValue('success') : null,
						'event' 	=> $eventManager
					));

					$this->setTemplate('event.tpl');

				break;
				
				/**
				 *
				 * Muestra el formulario para agregar
				 * un participante
				 *
				 */
				case 'showform':

					$this->showFormBystander(Tools::getValue('id_event_manager'));

				break;	

				/**
				 *
				 * Agrega un nuevo participante al evento
				 *
				 */
				case 'add':

					if(!Tools::getValue('id_event_manager'))
						return false;

					if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					    // Preparamos el objeto Bystander
					    $bystander = new Bystander();
					    $bystander->id_event_manager = Tools::getValue('id_event_manager');
					    $bystander->name = Tools::getValue('name');
					    $bystander->paternal_name = Tools::getValue('paternal_name');
					    $bystander->maternal_name = Tools::getValue('maternal_name');
					    $bystander->business_name = Tools::getValue('business_name');
					    $bystander->phone1 = Tools::getValue('phone1');
					    $bystander->phone2 = Tools::getValue('phone2');
					    $bystander->email = Tools::getValue('email');
					    $bystander->curp = Tools::getValue('curp');
					    $bystander->place_origin = Tools::getValue('place_origin');
					    $bystander->fullname = $bystander->name.' '.$bystander->paternal_name.' '.$bystander->maternal_name;
					    $bystander->attended_event = 0;
					   	
					   	$this->errors = array_unique(array_merge($this->errors, $bystander->validateController()));
					   	$this->validateCurpFormat($bystander->curp);
					   	
					   	if (!count($this->errors)) {

					   		
					   		// Se verifica que el curp no exista para este evento
					   		$issetCurpInEvent = Bystander::issetCurpInEvent($bystander->id_event_manager, $bystander->curp);
					   		if($issetCurpInEvent){
					   			$this->errors[] = Tools::displayError('Error: El CURP capturado ya existe en este evento.');
					   			$this->context->smarty->assign(array(
						   			'values' => Tools::getAllValues()
								));
					   		}else{

					   			if($bystander->add()){
									Tools::redirect('index.php?fc=module&module=eventsmanager&controller=event&id_event_manager='.$bystander->id_event_manager.'&action=showevent&success=addedBystander');
					   			}

					   		}

					   	}else{
					   		$this->context->smarty->assign(array(
					   			'values' => Tools::getAllValues(),
								'hasError' => !empty($this->errors),
                    			'errors' => $this->errors,
							));
					   	}

						$this->showFormBystander(Tools::getValue('id_event_manager'));
					    
					}
				
				break;
			}
		}
	}

	

	public function showFormBystander($id_event_manager)
	{
		$id_event_manager = (int)$id_event_manager;
		if(!$id_event_manager)
			return false;
		
		$issetEvent = EventManager::issetEvent($id_event_manager);

		$this->context->smarty->assign(array(
			'issetEvent' => $issetEvent,
			'id_event_manager' 	=> $id_event_manager
		));

		$this->setTemplate('form.tpl');

	}


	/**
	 *
	 * Valida el formato del CURP
	 *
	 */
	public function validateCurpFormat(&$curp)
	{
		$curp = strtoupper( trim($curp) );
		if(strlen($curp) !== 18){
			$this->errors[] = Tools::displayError('La longitud del CURP debe ser de 18 caracteres.');
			return false;
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
			return true; 
		}else{
			$this->errors[] = Tools::displayError('El formato del CURP introducido no es correcto, favor de verificarlo.');
			return false;
		}

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

}