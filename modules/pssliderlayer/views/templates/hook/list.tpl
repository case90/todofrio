{*
 *  Ps Prestashop SliderShow for Prestashop 1.6.x
 *
 * @package   pssliderlayer
 * @version   3.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 PrestaBrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}
<div class="alert alert-danger" id="slider-warning" style="display:none"></div>
<fieldset>
<div class="panel">
<div class="panel-heading">
	<i class="icon-list-ul"></i> {l s='Slides list' mod='pssliderlayer'}
	<span class="panel-heading-action">
		<a id="desc-product-new" class="list-toolbar-btn" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=pssliderlayer&addNewSlider=1&id_group={$id_group|escape:'htmlall':'UTF-8'}">
			<label><span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="Add new" data-html="true"><i class="process-icon-new "></i></span></label>
		</a>
	</span>
</div>
        <div class="alert alert-info">{l s='Config of Group:' mod='pssliderlayer'} {$group_title|escape:'htmlall':'UTF-8'} - <a href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=pssliderlayer&editgroup=1&id_group={$id_group|escape:'htmlall':'UTF-8'}" alt={l s='Back to group' mod='pssliderlayer'}>{l s='Back to Group' mod='pssliderlayer'}</a></div>                    
	<div id="slidesContent" style="width: 500px; margin-top: 30px;">
		<ul id="slides">
		{foreach from=$slides item=slide}
			<li id="slides_{$slide.id_slide|escape:'htmlall':'UTF-8'}">
				<strong>#{$slide.id_slide|escape:'htmlall':'UTF-8'}</strong> {$slide.title|truncate:32:'...'|escape:'html':'UTF-8'}
				<div style="float: right;margin-top: -5px;">
					{$slide.status}{* HTML, can not escape *}
                                        <div class="btn-group">
                                            <a class="btn btn-default dropdown-toggle" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=pssliderlayer&editSlider=1&id_slide={$slide.id_slide|escape:'htmlall':'UTF-8'}&id_group={$id_group|escape:'htmlall':'UTF-8'}"> 
                                                {if $slide.id_slide == $currentSliderID}
                                                    {l s='Editting' mod='pssliderlayer'}
                                                {else}
                                                    {l s='Action' mod='pssliderlayer'}
                                                {/if}
                                            </a>

                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
                                                <span class="caret"></span>&nbsp;
                                            </button>
                                            <ul class="dropdown-menu" style="border: none">
                                                <li style="background-color:#fff;border: none">
                                                   <a class="" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=pssliderlayer&editSlider=1&id_slide={$slide.id_slide|escape:'htmlall':'UTF-8'}&id_group={$id_group|escape:'htmlall':'UTF-8'}"> 
                                                       <i class="icon-edit"></i> {l s='Click to Edit' mod='pssliderlayer'}
                                                   </a>
                                                </li>
                                                <li style="background-color:#fff;border: none">
                                                    <a class="color_danger btn-actionslider" data-confirm="{l s='Are you sure you want to delete this slider?' mod='pssliderlayer'}" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=pssliderlayer&ptsajax=1&action=deleteSlider&id_slide={$slide.id_slide|escape:'htmlall':'UTF-8'}"><i class="icon-remove-sign"></i> {l s='Delete This slider' mod='pssliderlayer'}</a>
                                                </li>
                                                <li style="background-color:#fff;border: none">
                                                   <a class="btn-actionslider" data-confirm="{l s='Are you sure you want to duplicate this slider?' mod='pssliderlayer'}" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=pssliderlayer&ptsajax=1&action=duplicateSlider&id_slide={$slide.id_slide|escape:'htmlall':'UTF-8'}"> 
                                                       <i class="icon-film"></i> {l s='Duplicate This Slider' mod='pssliderlayer'}
                                                   </a>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                        
                                        <div class="btn-group"> 
                                            <a class="btn btn-default {if $languages|count > 1}dropdown-toggle {else}slider-preview {/if}color_danger" href="{$previewLink|escape:'htmlall':'UTF-8'}&id_group={$id_group|escape:'htmlall':'UTF-8'}&id_slide={$slide.id_slide|escape:'htmlall':'UTF-8'}"><i class="icon-eye-open"></i> {l s='Preview' mod='pssliderlayer'}</a>
                                            {if $languages|count > 1}

                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
                                                <span class="caret"></span>&nbsp;
                                            </button>
                                            <ul class="dropdown-menu" style="border: none">
                                                {foreach from=$languages item=language}
                                                <li style="background-color:#fff;border: none">
                                                    {$arrayParam = ['secure_key' => $msecure_key, 'id_group' => $id_group, 'id_slide'=>$slide.id_slide]}
                                                    <a href="{$link->getModuleLink('pssliderlayer','preview', $arrayParam, null, $language.id_lang)|escape:'htmlall':'UTF-8'}" class="slider-preview">
                                                        <i class="icon-eye-open"></i> {l s='Preview For' mod='pssliderlayer'} {$language.name|escape:'htmlall':'UTF-8'}
                                                    </a>
                                                </li>
                                                {/foreach}
                                            </ul>
                                            {/if}
                                        </div>
				</div>
			</li>
		{/foreach}
		</ul>
	</div>
</div>
</fieldset>
