{*
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
*}
<div id="OxxoDisplayPayment">
	<div class="container">
		<div class="row">
			<div class="wrapperPaymentInfo col-xs-12 col-md-8 col-md-offset-2">
				<div class="col-01 col-xs-12 col-md-4">
					<div class="col_01_head">
						<div>{l s='Detalle de' mod='oxxodeposit'}</div>
						<div class="axsTitle03 weight_bold">{l s='Pago' mod='oxxodeposit'}</div>
					</div>

					<div class="col_01_body">
						<div class="col_01_body_row">
							<div>{l s='Total' mod='oxxodeposit'}</div>
							<div class="axsTitle04 weight_bold">{convertPrice price=$total|floatval} {$iso_code}</div>
						</div>
						<div class="col_01_body_row">
							<div>{l s='Fecha' mod='oxxodeposit'}</div>
							<div class="axsTitle04 weight_bold">{$current_date}</div>
						</div>
			
					</div>

				</div>
				<div class="col-02 col-xs-12 col-md-8">
					<div class="col_02_head">
						<div class="row">
							<div class="col-xs-4 col-xs-offset-4">
								<div class="oxxodeposit_oxxologo"><img src="{$modules_dir}oxxodeposit/views/img/oxxologo.svg" alt=""></div>
							</div>
							
						</div>
					</div>
					<div class="col_02_body">
						{$info_deposit}
					</div>
					<div class="col_02_footer">
						<div class="col_02_footer_info">{$info_footer}</div>
						<div class="buttonFooterArea">
							<a href="{$link->getModuleLink('oxxodeposit', 'confirmation', ['cart_id' => $cart_id, 'secure_key' => $secure_key], true)|escape:'htmlall':'UTF-8'}" class="button btn btn-default" title="Pasar por la caja" style="">
								<span>Confirmar Compra<i class="icon-chevron-right right"></i></span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
