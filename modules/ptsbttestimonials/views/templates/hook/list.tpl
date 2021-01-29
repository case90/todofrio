{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   ptsbttestimonials
* @version   1.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
<div class="panel">
	<h3><i class="icon-list-ul"></i> {l s='Testimonials list' mod='ptsbttestimonials'}
		<span class="panel-heading-action">
			<a id="desc-product-new" class="list-toolbar-btn"
	           href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=ptsbttestimonials&addTest=1">
	            <label>
	                <span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s='Add new' mod='ptsbttestimonials'}"
	                      data-html="true">
	                    <i class="process-icon-new "></i>
	                </span>
	            </label>
	        </a>
		</span>
	</h3>

    <div id="testsContent" style="width: 400px; margin-top: 30px;">
        <ul id="tests">
        	{foreach from = $tests item = test}
                <li id="tests_{$test.id_test|escape:'htmlall':'UTF-8'}">
                    <strong>#{$test.id_test|escape:'htmlall':'UTF-8'}</strong> {$test.name|escape:'htmlall':'UTF-8'}
                    <p style="float: right">
                        {$test.status}{* HTMl, can not escape *}
                        <a class="btn btn-primary"
                           href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=ptsbttestimonials&id_test={$test.id_test|escape:'htmlall':'UTF-8'}"> {l s='Edit' mod='ptsbttestimonials'}</a>
                        <a class="btn btn-danger"
                           href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=ptsbttestimonials&delete_id_test={$test.id_test|escape:'htmlall':'UTF-8'}"> {l s='Delete' mod='ptsbttestimonials'}</a>
                    </p>
                </li>
            {/foreach}
        </ul>
    </div>
</div>