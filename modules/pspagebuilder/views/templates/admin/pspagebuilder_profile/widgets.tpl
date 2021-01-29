{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   pspagebuilder
* @version   5.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
<div class="wpo-widgets clearfix">
	
	<div class="widgets-filter">
		<div class="form-group has-success clearfix">
			<label class="col-lg-2 control-label" for="searchwidgets">{l s='Filter By Name' mod='pspagebuilder'}</label>
			<div class="col-lg-10">
				<input type="text" id="searchwidgets"  name="searchwidgets">
			</div>
		</div>

		<div class="form-group clearfix">
			<label class="col-lg-2 control-label" for="searchwidgets">{l s='Filter By Group' mod='pspagebuilder'}</label>
			<div class="col-lg-10" id="filterbygroups">
				 <ul class="nav nav-pills">
				 	<li class="filter-option" data-option="all">
						<a href="#">{l s='All' mod='pspagebuilder'}<span class="badge"></span></a>
					</li>

				 	{foreach from=$groups item=group name=group}
					<li class="filter-option" data-option="{$group.key|escape:'html':'UTF-8'}">
						<a href="#">{$group.group|escape:'html':'UTF-8'}<span class="badge"></span></a>
					</li>
			 		{/foreach}
				</ul>
	      </div>  
		</div>
 	</div>

	<ul>
		{foreach from=$widgets item=widget name=widget}
		<li class="wpo-wg-button" data-group="{$widget.group|escape:'html':'UTF-8'}">
			{$widget.button}{* HTML, cannot escape *}
		</li>
		{/foreach}
 	</ul>
 	<div class="clearfix"></div>
</div>

 