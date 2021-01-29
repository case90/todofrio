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
{extends file="helpers/form/form.tpl"}

{block name="field"}
    {if $input.type == 'file_lang'}
        <div class="row">
            {foreach from=$languages item=language}

                {if $languages|count > 1}
                    <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
                    {/if}
                    <div class="col-lg-6">
                        <div class="upload-img-form">
                            <img id="thumb_slider_thumbnail_{$language.id_lang|escape:'htmlall':'UTF-8'}" width="50" class="{if !$fields_value[$input.name][$language.id_lang]}nullimg{/if}" alt="" src="{$psBaseModuleUri|escape:'htmlall':'UTF-8'}{$fields_value[$input.name][$language.id_lang]|escape:'htmlall':'UTF-8'}"/>
                            <input id="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}" type="hidden" name="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}" class="hide" value="{$fields_value[$input.name][$language.id_lang]|escape:'htmlall':'UTF-8'}" />
                            <br>
                            <a onclick="image_upload('{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}', 'thumb_slider_thumbnail_{$language.id_lang|escape:'htmlall':'UTF-8'}');" href="javascript::void(0);">{l s='Browse' mod='pssliderlayer' mod='pssliderlayer'}</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                            <a onclick="$('#thumb_slider_thumbnail_{$language.id_lang|escape:'htmlall':'UTF-8'}').attr('src', '');$('#thumb_slider_thumbnail_{$language.id_lang|escape:'htmlall':'UTF-8'}').addClass('nullimg'); $('#{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}').attr('value', '');" href="javascript::void(0);">{l s='Clear' mod='pssliderlayer'}</a>
                        </div>
                        <br/>
                    </div>
                    {if $languages|count > 1}
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                {$language.iso_code|escape:'htmlall':'UTF-8'}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                {foreach from=$languages item=lang}
                                    <li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'htmlall':'UTF-8'});" tabindex="-1">{$lang.name|escape:'htmlall':'UTF-8'}</a></li>
                                {/foreach}
                            </ul>
                        </div>
                    {/if}
                    {if $languages|count > 1}
                    </div>
                {/if}
                <script>
                    $(document).ready(function() {
                        $('#{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}-selectbutton').click(function(e) {
                            $('#{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}').trigger('click');
                        });
                        $('#{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}').change(function(e) {
                            var val = $(this).val();
                            var file = val.split(/[\\/]/);
                            $('#{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}-name').val(file[file.length - 1]);
                        });
                    });
                </script>
                <input id="slider-image_{$language.id_lang|escape:'htmlall':'UTF-8'}" type="hidden" name="image_{$language.id_lang|escape:'htmlall':'UTF-8'}" class="hide" value="{$fields_value["image"][$language.id_lang]|escape:'htmlall':'UTF-8'}" />
            {/foreach}
        </div>
    {/if}
    {if $input.type == 'group_background'}
        <div class="col-lg-9">
            <div class="upload-img-form">
               <img id="img_{$input.id|escape:'htmlall':'UTF-8'}" width="50" class="{if !{$fields_value[$input.name]|escape:'htmlall':'UTF-8'}}nullimg{/if}" alt="{l s='Group Back-ground' mod='pssliderlayer'}" src="{$psBaseModuleUri|escape:'htmlall':'UTF-8'}{$fields_value[$input.name]|escape:'htmlall':'UTF-8'}"/>
               <input id="{$input.id|escape:'htmlall':'UTF-8'}" type="hidden" name="group[background_url]" class="hide" value="{$fields_value[$input.name]|escape:'htmlall':'UTF-8'}" />
               <br>
               <a onclick="background_upload('{$input.id|escape:'htmlall':'UTF-8'}', 'img_{$input.id|escape:'htmlall':'UTF-8'}','{$ajaxfilelink|escape:'htmlall':'UTF-8'}', '{$psBaseModuleUri|escape:'htmlall':'UTF-8'}');" href="javascript:void(0);">{l s='Browse' mod='pssliderlayer'}</a>&nbsp;&nbsp;|&nbsp;&nbsp;
               <a onclick="$('#img_{$input.id|escape:'htmlall':'UTF-8'}').attr('src', '');$('#img_{$input.id|escape:'htmlall':'UTF-8'}').addClass('nullimg'); $('#{$input.id|escape:'htmlall':'UTF-8'}').attr('value', '');" href="javascript:void(0);">{l s='Clear' mod='pssliderlayer'}</a>
           </div>
            <p>{l s='Click to upload or select a back-ground' mod='pssliderlayer'}</p>
        </div>
    {/if}
    {if $input.type == 'group_button' && $input.id_group}
        <div class="form-group">
            <div class="col-lg-9 col-lg-offset-3">
                <div class="btn-group pull-right">
                    <a class="btn btn-default {if $languages|count > 1}dropdown-toggle {else}group-preview {/if}color_danger" href="{$previewLink|escape:'htmlall':'UTF-8'}&id_group={$input.id_group|escape:'htmlall':'UTF-8'}"><i class="icon-eye-open"></i> {l s='Preview Group' mod='pssliderlayer'}</a>
                    {if $languages|count > 1}
                    
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
                        <span class="caret"></span>&nbsp;
                    </button>
                    <ul class="dropdown-menu">
                        {foreach from=$languages item=language}
                        <li>
                            {$arrayParam = ['secure_key' => $msecure_key, 'id_group' => $input.id_group]}
                            <a href="{$link->getModuleLink('pssliderlayer','preview', $arrayParam, null, $language.id_lang)|escape:'htmlall':'UTF-8'}" class="group-preview">
                                <i class="icon-eye-open"></i> {l s='Preview For' mod='pssliderlayer'} {$language.name|escape:'htmlall':'UTF-8'}
                            </a>
                        </li>
                        {/foreach}
                    </ul>
                    {/if}
                </div>
                
                <button class="btn btn-default dash_trend_right" name="submitGroup" id="module_form_submit_btn" type="submit">
                        <i class="icon-save"></i> {l s='Save' mod='pssliderlayer'}
                </button>
                <a class="btn btn-default color_success" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=pssliderlayer&showsliders=1&id_group={$input.id_group|escape:'htmlall':'UTF-8'}"><i class="icon-film"></i> {l s='Manages Sliders' mod='pssliderlayer'}</a>
                <a class="btn btn-default" href="{$exportLink|escape:'htmlall':'UTF-8'}&id_group={$input.id_group|escape:'htmlall':'UTF-8'}"><i class="icon-eye-open"></i> {l s='Export Group and sliders' mod='pssliderlayer'}</a>
                <a class="btn btn-default" href="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=pssliderlayer&deletegroup=1&id_group={$input.id_group|escape:'htmlall':'UTF-8'}" onclick="if (confirm('{l s='Delete Selected Group?' mod='pssliderlayer'}')) {
                            return true;
                        } else {
                            event.stopPropagation();
                            event.preventDefault();
                        }
                        ;" title="{l s='Delete' mod='pssliderlayer'}" class="delete">
                    <i class="icon-trash"></i> {l s='Delete' mod='pssliderlayer'}
                </a>
            </div>
        </div>


    {/if}
    {if $input.type == 'slider_button'}
        <div class="form-group">
            <div class="col-lg-9 col-lg-offset-3">
                <a class="btn btn-default dash_trend_right" href="javascript:void(0)" onclick="return $('#module_form').submit();"><i class="icon-save"></i> {l s='Save Slider' mod='pssliderlayer'}</a>
            </div>
        </div>
    {/if}
    {if $input.type == 'sperator_form'}
        <div class="{if isset($input.class)}{$input.class|escape:'htmlall':'UTF-8'}{else}alert alert-info{/if}">{$input.text|escape:'htmlall':'UTF-8'}</div>
    {/if}
    {if $input.type == 'video_config'}
        <div class="row">
            {foreach from=$languages item=language}
                {if $languages|count > 1}
                    <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
                    {/if}
                    <div class="col-lg-6">
                        <div class="radiolabel">
                            <lable>{l s='Video Type' mod='pssliderlayer'}</lable>
                            <select name="usevideo_{$language.id_lang|escape:'htmlall':'UTF-8'}" class="">
                                <option {if isset($fields_value["usevideo"][$language.id_lang]) && $fields_value["usevideo"][$language.id_lang] && $fields_value["usevideo"][$language.id_lang] eq "0"}selected="selected"{/if} value="0">{l s='No' mod='pssliderlayer'}</option>
                                <option {if isset($fields_value["usevideo"][$language.id_lang]) && $fields_value["usevideo"][$language.id_lang] && $fields_value["usevideo"][$language.id_lang] eq "youtube"}selected="selected"{/if} value="youtube">{l s='Youtube' mod='pssliderlayer'}</option>
                                <option {if isset($fields_value["usevideo"][$language.id_lang]) && $fields_value["usevideo"][$language.id_lang] && $fields_value["usevideo"][$language.id_lang] eq "vimeo"}selected="selected"{/if} value="vimeo">{l s='Vimeo' mod='pssliderlayer'}</option>
                            </select>
                        </div>
                        <div class="radiolabel">
                            <lable>{l s='Video ID' mod='pssliderlayer'}</lable>
                            <input id="videoid_{$language.id_lang|escape:'htmlall':'UTF-8'}" name="videoid_{$language.id_lang|escape:'htmlall':'UTF-8'}" type="text" {if isset($fields_value["videoid"][$language.id_lang]) && $fields_value["videoid"][$language.id_lang]} value="{$fields_value["videoid"][$language.id_lang]|escape:'htmlall':'UTF-8'}"{/if}/>
                            <div class="input-group col-lg-2">
                            </div>
                            <div class="input-group col-lg-2">
                                <lable>{l s='Auto Play' mod='pssliderlayer'}</lable>
                                <select name="videoauto_{$language.id_lang|escape:'htmlall':'UTF-8'}">
                                    <option value="1" {if isset($fields_value["videoauto"][$language.id_lang]) && $fields_value["videoauto"][$language.id_lang] == 1}selected="selected"{/if}>{l s='Yes' mod='pssliderlayer'}</option>
                                    <option value="0" {if isset($fields_value["videoauto"][$language.id_lang]) && $fields_value["videoauto"][$language.id_lang] == 0}selected="selected"{/if}>{l s='No' mod='pssliderlayer'}</option>
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    {if $languages|count > 1}
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                {$language.iso_code|escape:'htmlall':'UTF-8'}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                {foreach from=$languages item=lang}
                                    <li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'htmlall':'UTF-8'});" tabindex="-1">{$lang.name|escape:'htmlall':'UTF-8'}</a></li>
                                    {/foreach}
                            </ul>
                        </div>
                    {/if}
                    {if $languages|count > 1}
                    </div>
                {/if}
            {/foreach}   
        </div>
        <input type="hidden" id="current_language" name="current_language" value="{$id_language|escape:'htmlall':'UTF-8'}"/>
    {/if}
    {if $input.type == 'col_width'}
        <div class="col-lg-9">
            <input type='hidden' class="col-val {$input.class|escape:'htmlall':'UTF-8'}" name='{$input.name|escape:'htmlall':'UTF-8'}' value='{$fields_value[$input.name]|escape:'htmlall':'UTF-8'}'/>
            <button type="button" class="btn btn-default ptsbtn-width dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                <span class="pts-width-val">{$fields_value[$input.name]|replace:'-':'.'}/12</span><span class="pts-width pts-w-{$fields_value[$input.name]|escape:'htmlall':'UTF-8'}"> </span><span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                {foreach from=$pts_width item=itemWidth}
                <li>
                    <a class="pts-w-option" data-width="{$itemWidth|escape:'htmlall':'UTF-8'}" href="javascript:void(0);" tabindex="-1">                                          
                        <span class="pts-width-val">{$itemWidth|replace:'-':'.'|escape:'htmlall':'UTF-8'}/12</span><span class="pts-width pts-w-{$itemWidth|escape:'htmlall':'UTF-8'}"> </span>
                    </a>
                </li>
                {/foreach}
            </ul>
        </div>
    {/if}
    {if $input.type == 'group_class'}
        <div class="col-lg-9">
            <div class="well">
                <p> 
                    <input type="text" class="group-class" value="{$fields_value[$input.name]|escape:'htmlall':'UTF-8'}" name="{$input.name|escape:'htmlall':'UTF-8'}"/><br />
                    {l s='insert new or select classes for toggling content across viewport breakpoints' mod='pssliderlayer'}<br />
                    <ul class="pts-col-class">
                        {foreach from=$hidden_config key=keyHidden item=itemHidden}
                        <li>
                            <input type="checkbox" name="col_{$keyHidden|escape:'htmlall':'UTF-8'}" value="1">
                            <label class="choise-class">{$itemHidden|escape:'htmlall':'UTF-8'}</label>
                        </li>
                        {/foreach}
                    </ul>
                </p>
            </div>
        </div>
    {/if}
    {if $input.type == 'color_lang'}
        <div class="row">
            {foreach from=$languages item=language}
                    {if $languages|count > 1}
                            <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
                    {/if}
                            <div class="col-lg-6">
                                <div class="col-md-4">
                                    <a href="javascript:void(0)" class="btn btn-default btn-update-slider">
                                                <i class="icon-upload"></i> {l s='Select slider background' mod='pssliderlayer'}
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                            <input type="color"
                                            data-hex="true"
                                            {if isset($input.class)}class="{$input.class|escape:'htmlall':'UTF-8'}"
                                            {else}class="color mColorPickerInput"{/if}
                                            name="{$input.name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}"
                                            value="{$fields_value[$input.name]|escape:'html':'UTF-8'}" />
                                    </div>
                                </div>
                            </div>
                    {if $languages|count > 1}
                            <div class="col-lg-2">
                                    <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                            {$language.iso_code|escape:'htmlall':'UTF-8'}
                                            <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                            {foreach from=$languages item=lang}
                                            <li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'htmlall':'UTF-8'});" tabindex="-1">{$lang.name|escape:'htmlall':'UTF-8'}</a></li>
                                            {/foreach}
                                    </ul>
                            </div>
                    {/if}
                    {if $languages|count > 1}
                            </div>
                    {/if}
            {/foreach}
        </div>
    {/if}
    {$smarty.block.parent}
{/block}