{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   psmegamenu
* @version   2.5
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
{if isset($accordions)}
<div class="widget-accordion block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="widget-heading title_block">
		{$widget_heading|escape:'html':'UTF-8'}
	</div>
	{/if}
	<div class="widget-inner block_content">	<div id="accordion{$id|escape:'html':'UTF-8'}" class="panel-group">
	 	{foreach $accordions as $key => $ac}
		
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h4 class="panel-title">
				      <a href="#collapseAc{$id|escape:'html':'UTF-8'}{$key|escape:'html':'UTF-8'}" data-parent="#accordion{$id|escape:'html':'UTF-8'}" data-toggle="collapse" class="accordion-toggle collapsed">
				       	{$ac.header|escape:'html':'UTF-8'}  
				      </a>
				    </h4>
				  </div>
				  <div class="panel-collapse collapse {if $key==0} in {else} out{/if}" id="collapseAc{$id|escape:'html':'UTF-8'}{$key|escape:'html':'UTF-8'}"  >
				    <div class="panel-body">
				      {$ac.content} {* HTML, Can not Escape *}
				    </div>
				  </div>
				</div>
			
	 	{/foreach}
	</div>	</div>
</div>
{/if}


