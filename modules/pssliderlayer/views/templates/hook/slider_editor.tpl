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
<fieldset>
<div class="form-group">
    <div class="col-lg-9 col-lg-offset-3">
        <a class="btn btn-default dash_trend_right" href="javascript:void(0)" onclick="return $('#module_form').submit();"><i class="icon-save"></i> {l s='Save Slider' mod='pssliderlayer'}</a>
        <a id="btn-preview-slider" class="btn btn-default {if $languages|count > 1}dropdown-toggle {else}slider-preview {/if}color_danger" herf="javascript:void(0);" data-link="{$previewLink|escape:'htmlall':'UTF-8'}&id_group={$id_group|escape:'htmlall':'UTF-8'}"><i class="icon-eye-open"></i> {l s='Preview This Slider' mod='pssliderlayer'}</a>
    </div>
</div>
{*editor for each lang*}

{*action tool*}
<div class="col-lg-1">
<div class="slider-toolbar">
    <h4>{l s='Tools Action' mod='pssliderlayer'}</h4>
    <ul>
        <li>
            <div class="btn-create" href="#" data-action="add-image">
                <i class="icon-picture"></i><br/>{l s='Add Image' mod='pssliderlayer'}
            </div></li>
        <li><div class="btn-create" href="#" data-action="add-video">
                <i class="icon-youtube-play"></i><br/>{l s='Add Video' mod='pssliderlayer'}
            </div></li>
        <li><div class="btn-create" href="#" data-action="add-text">
                <i class="icon-text-width"></i><br/>{l s='Add Text' mod='pssliderlayer'}
            </div></li>
    </ul>
    <div class="btn-delete" data-action="delete-layer"><i class="icon-remove"></i> {l s='Delete' mod='pssliderlayer'}</div>
</div>
</div>
{*editor content*}
<div class="col-lg-11">
{foreach from=$languages item=language}
<form action="{$link->getAdminLink('AdminModules')|escape:'htmlall':'UTF-8'}&configure=pssliderlayer&ptsajax=1&action=submitslider" method="post" enctype="multipart/form-data" class="slider-form" id="slider-form_{$language.id_lang|escape:'htmlall':'UTF-8'}">
    {if $languages|count > 1}
        <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'} form-language" data-action="{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $id_language}style="display:none"{/if}>
            <div class="col-lg-12">
                <div class="col-lg-10"></div>
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
            </div>
        {/if}
        <div class="col-lg-12">
            <div class="form-group layers-wrapper clearfix" id="slider-toolbar_{$language.id_lang|escape:'htmlall':'UTF-8'}">
                
            <div class="slider-layers bannercontainer">
                <div class="back-ground">
                    <div class="title-back">
                        {l s='BackGround' mod='pssliderlayer'}
                    </div>
                    <div class="col-md-6">
                        <a href="javascript:void(0)" class="btn btn-default btn-update-slider">
                            <i class="icon-upload"></i> {l s='Set Background Image' mod='pssliderlayer'}
                        </a>
                        <a href="javascript:void(0)" class="btn btn-default btn-remove-backurl" style="color:red">
                            <i class="icon-remove"></i> {l s='Remove' mod='pssliderlayer'}
                        </a>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-4">
                            <lable>{l s='Background Color' mod='pssliderlayer'}:</lable>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="color" data-hex="true" class="slider-backcolor color mColorPickerInput" data-lang="{$language.id_lang|escape:'htmlall':'UTF-8'}" value="{if isset($sliderBack[$language.id_lang])}{$sliderBack[$language.id_lang]|escape:'htmlall':'UTF-8'}{/if}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-editor-wrap" id="slider-editor-wrap_{$language.id_lang|escape:'htmlall':'UTF-8'}" style="width:{$sliderGroup.width|escape:'htmlall':'UTF-8'}px;height:{if $sliderGroup.fullwidth=="fullscreen"}{$sliderGroup.height|escape:'htmlall':'UTF-8' + 200}{else}{$sliderGroup.height|escape:'htmlall':'UTF-8'}{/if}px">
                    <div class="simage">
                        <img src="{if isset($slideImg[$language.id_lang])}{$psBaseModuleUri|escape:'htmlall':'UTF-8'}{$slideImg[$language.id_lang]|escape:'htmlall':'UTF-8'}{/if}" alt=""/>
                    </div>
                    <div class="slider-editor" id="slider-editor_{$language.id_lang|escape:'htmlall':'UTF-8'}" style="width:{$sliderGroup.width|escape:'htmlall':'UTF-8'}px;height:{if $sliderGroup.fullwidth=="fullscreen"}{$sliderGroup.height|escape:'htmlall':'UTF-8' + 200}{else}{$sliderGroup.height|escape:'htmlall':'UTF-8'}{/if}px">

                    </div>
                </div>
                <div class="layer-video-inpts dialog-video" id="dialog-video_{$language.id_lang|escape:'htmlall':'UTF-8'}">
                    <table class="form">
                        <tr>
                            <td>{l s='Video Type' mod='pssliderlayer'}</td>
                            <td>
                                <select name="layer_video_type" id="layer_video_type_{$language.id_lang|escape:'htmlall':'UTF-8'}">
                                    <option value="youtube">Youtube</option>
                                    <option value="vimeo">Vimeo</option>
                                </select>	
                            </td>
                        </tr>
                        <tr>
                            <td>{l s='Video ID' mod='pssliderlayer'}</td>
                            <td><input name="layer_video_id" type="text" id="dialog_video_id_{$language.id_lang|escape:'htmlall':'UTF-8'}">
                                <p>{l s='for example youtube' mod='pssliderlayer'}: <b>VA770wpLX-Q</b> and vimeo: <b>17631561</b> </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label>{l s='Height' mod='pssliderlayer'}</label>
                                <input name="layer_video_height" type="text" value="200">
                                <label>{l s='Width' mod='pssliderlayer'}</label>
                                <input name="layer_video_width" type="text" value="300">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="layer_video_thumb" id="layer_video_thumb_{$language.id_lang|escape:'htmlall':'UTF-8'}">
                                <div class="buttons">
                                    <div class="btn layer-find-video">{l s='Find Video' mod='pssliderlayer'}</div>
                                    <div class="btn layer-apply-video apply_this_video" id="apply_this_video_{$language.id_lang|escape:'htmlall':'UTF-8'}" style="display:none;">{l s='Use This Video' mod='pssliderlayer'}</div>
                                    <div class="btn btn-green" onclick="$('#dialog-video_{$language.id_lang|escape:'htmlall':'UTF-8'}').hide();">{l s='Close' mod='pssliderlayer'}</div>
                                </div>
                            </td>
                        </tr>	
                    </table>
                    <div id="video-preview_{$language.id_lang|escape:'htmlall':'UTF-8'}"></div>
                </div>
                <div class="slider-foot">
                    <div class="layer-collection-wrapper">
                        <h4>{l s='Layer Collection' mod='pssliderlayer'}</h4>
                        <div class="layer-collection" id="layer-collection_{$language.id_lang|escape:'htmlall':'UTF-8'}"></div>	
                    </div>
                </div>
                <div class="layer-form" id="layer-form_{$language.id_lang|escape:'htmlall':'UTF-8'}">
                    <h4>{l s='Edit Layer Data' mod='pssliderlayer'}</h4>
                    <input type="hidden" class="layer_id" id="layer_id_{$language.id_lang|escape:'htmlall':'UTF-8'}" name="layer_id"/>
                    <input type="hidden" class="layer_content" id="layer_content_{$language.id_lang|escape:'htmlall':'UTF-8'}" name="layer_content"/>
                    <input type="hidden" class="layer_type" id="layer_type_{$language.id_lang|escape:'htmlall':'UTF-8'}" name="layer_type"/>

                    <table class="form" style="width:100%">
                        <tr>
                            <td>{l s='Class Style' mod='pssliderlayer'}</td>
                            <td>

                                <input type="text" class="layer_class" name="layer_class" id="input-layer-class_{$language.id_lang|escape:'htmlall':'UTF-8'}"/>
                                <span class="buttons">
                                    <span class="btn btn-typo btn-insert-typo" id="btn-insert-typo_{$language.id_lang|escape:'htmlall':'UTF-8'}">{l s='Insert Typo' mod='pssliderlayer'}</span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>{l s='Caption Html' mod='pssliderlayer'}</td>
                            <td>
                                <p>{l s='Allow insert html code' mod='pssliderlayer'}</p>
                                <textarea style="height:60px" class="input-slider-caption" name="layer_caption" id="input-slider-caption_{$language.id_lang|escape:'htmlall':'UTF-8'}" data-for="caption-layer" ></textarea>
                                
                                <table class="text-attr">
                                    <tr>
                                        <td>{l s='font-size' mod='pssliderlayer'}</td>
                                        <td>{l s='Background Color' mod='pssliderlayer'}</td>
                                        <td>{l s='Text Color' mod='pssliderlayer'}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="layer_font_size" class="layer_font_size">
                                                <option value="" selected="selected">{l s='Auto' mod='pssliderlayer'}</option>
                                                {for $foo=9 to 100}
                                                <option value="{$foo|escape:'htmlall':'UTF-8'}px">{$foo|escape:'htmlall':'UTF-8'}px</option>
                                                {/for}
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="color" data-hex="true" name="layer_background_color" class="layer_background_color color mColorPickerInput" value=""/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="color" data-hex="true" name="layer_color" class="layer_color color mColorPickerInput" value=""/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><br/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>{l s='Link' mod='pssliderlayer'}</td>
                            <td>
                                <input type="text" class="layer_link" name="layer_link" id="layer_link_{$language.id_lang|escape:'htmlall':'UTF-8'}">
                                <p>{l s='Do not input will get link from slider' mod='pssliderlayer'}</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><hr></td>
                        </tr>
                        <tr>
                            <td>{l s='Effect' mod='pssliderlayer'}</td>
                            <td><label>{l s='Animation' mod='pssliderlayer'}</label>
                                <select class="layer_animation" name="layer_animation">
                                    {foreach from=$layerAnimation item=lanimation}
                                        <option {if $lanimation.id=="fade"}selected="selected"{/if} value="{$lanimation.id|escape:'htmlall':'UTF-8'}">{$lanimation.name|escape:'htmlall':'UTF-8'}</option>
                                    {/foreach}
                                </select>	
                                <p>	
                                    <label>{l s='Easing' mod='pssliderlayer'}</label>
                                    <select class="layer_easing" name="layer_easing" id="layer_easing_{$language.id_lang|escape:'htmlall':'UTF-8'}">
                                        <option value="easeOutBack">easeOutBack</option>
                                        <option value="easeInQuad">easeInQuad</option>
                                        <option value="easeOutQuad">easeOutQuad</option>
                                        <option value="easeInOutQuad">easeInOutQuad</option>
                                        <option value="easeInCubic">easeInCubic</option>
                                        <option value="easeOutCubic">easeOutCubic</option>
                                        <option value="easeInOutCubic">easeInOutCubic</option>
                                        <option value="easeInQuart">easeInQuart</option>
                                        <option value="easeOutQuart">easeOutQuart</option>
                                        <option value="easeInOutQuart">easeInOutQuart</option>
                                        <option value="easeInQuint">easeInQuint</option>
                                        <option value="easeOutQuint">easeOutQuint</option>
                                        <option value="easeInOutQuint">easeInOutQuint</option>
                                        <option value="easeInSine">easeInSine</option>
                                        <option value="easeOutSine">easeOutSine</option>
                                        <option value="easeInOutSine">easeInOutSine</option>
                                        <option value="easeInExpo">easeInExpo</option>
                                        <option selected="selected" value="easeOutExpo">easeOutExpo</option>
                                        <option value="easeInOutExpo">easeInOutExpo</option>
                                        <option value="easeInCirc">easeInCirc</option>
                                        <option value="easeOutCirc">easeOutCirc</option>
                                        <option value="easeInOutCirc">easeInOutCirc</option>
                                        <option value="easeInElastic">easeInElastic</option>
                                        <option value="easeOutElastic">easeOutElastic</option>
                                        <option value="easeInOutElastic">easeInOutElastic</option>
                                        <option value="easeInBack">easeInBack</option>
                                        <option value="easeOutBack">easeOutBack</option>
                                        <option value="easeInOutBack">easeInOutBack</option>
                                        <option value="easeInBounce">easeInBounce</option>
                                        <option value="easeOutBounce">easeOutBounce</option>
                                        <option value="easeInOutBounce">easeInOutBounce</option>
                                    </select>	
                                </p>	
                            </td>
                        </tr>
                        <tr>
                            <td>{l s='Speed' mod='pssliderlayer'}</td>
                            <td>
                                <input class="layer_speed" name="layer_speed" id="layer_speed_{$language.id_lang|escape:'htmlall':'UTF-8'}" type="text">
                            </td>

                        </tr>
                        <tr>
                            <td>
                                {l s='Position' mod='pssliderlayer'}
                            </td>
                            <td>
                                <label>{l s='Top' mod='pssliderlayer'}:</label><input size="3" type="text" class="layer_top" name="layer_top" id="layer_top_{$language.id_lang|escape:'htmlall':'UTF-8'}">
                                <label>{l s='Left' mod='pssliderlayer'}:</label><input size="3" type="text" class="layer_left" name="layer_left" id="layer_left_{$language.id_lang|escape:'htmlall':'UTF-8'}">
                        </tr>
                        <tr>
                            <td colspan="2"><hr></td>
                        </tr>
                    </table>
                    <div class="other-effect">
                        <h5>{l s='Other Animation' mod='pssliderlayer'}</h5>
                        <table class="form" style="width:100%">
                            <tr>
                                <td>{l s='End Time' mod='pssliderlayer'}</td>
                                <td><input type="text" class="layer_endtime" name="layer_endtime" id="layer_endtime_{$language.id_lang|escape:'htmlall':'UTF-8'}"> </td>
                            </tr>
                            <tr>
                                <td>{l s='End Speed' mod='pssliderlayer'}</td>
                                <td><input type="text" class="layer_endspeed" name="layer_endspeed" id="layer_endspeed_{$language.id_lang|escape:'htmlall':'UTF-8'}"> </td>
                            </tr>
                            <tr>
                                <td>{l s='End Animation' mod='pssliderlayer'}</td>
                                <td>
                                    <select type="text" class="layer_endanimation" name="layer_endanimation" id="layer_endanimation_{$language.id_lang|escape:'htmlall':'UTF-8'}"> 
                                        <option selected="selected" value="auto">{l s='Choose Automatic' mod='pssliderlayer'}</option>
                                        <option value="fadeout">{l s='Fade Out' mod='pssliderlayer'}</option>
                                        <option value="stt">{l s='Short to Top' mod='pssliderlayer'}</option>
                                        <option value="stb">{l s='Short to Bottom' mod='pssliderlayer'}</option>
                                        <option value="stl">{l s='Short to Left' mod='pssliderlayer'}</option>
                                        <option value="str">{l s='Short to Right' mod='pssliderlayer'}</option>
                                        <option value="ltt">{l s='Long to Top' mod='pssliderlayer'}</option>
                                        <option value="ltb">{l s='Long to Bottom' mod='pssliderlayer'}</option>
                                        <option value="ltl">{l s='Long to Left' mod='pssliderlayer'}</option>
                                        <option value="ltr">{l s='Long to Right' mod='pssliderlayer'}</option>
                                        <option value="randomrotateout">{l s='Random Rotate Out' mod='pssliderlayer'}</option>
                                    </select>
                                </td>
                            </tr>	
                            <tr>
                                <td>{l s='End Easing' mod='pssliderlayer'}</td>
                                <td>
                                    <select class="layer_endeasing" name="layer_endeasing" id="layer_endeasing_{$language.id_lang|escape:'htmlall':'UTF-8'}"> 
                                        <option selected="selected" value="nothing">{l s='No Change' mod='pssliderlayer'}</option>
                                        <option value="easeOutBack">easeOutBack</option>
                                        <option value="easeInQuad">easeInQuad</option>
                                        <option value="easeOutQuad">easeOutQuad</option>
                                        <option value="easeInOutQuad">easeInOutQuad</option>
                                        <option value="easeInCubic">easeInCubic</option>
                                        <option value="easeOutCubic">easeOutCubic</option>
                                        <option value="easeInOutCubic">easeInOutCubic</option>
                                        <option value="easeInQuart">easeInQuart</option>
                                        <option value="easeOutQuart">easeOutQuart</option>
                                        <option value="easeInOutQuart">easeInOutQuart</option>
                                        <option value="easeInQuint">easeInQuint</option>
                                        <option value="easeOutQuint">easeOutQuint</option>
                                        <option value="easeInOutQuint">easeInOutQuint</option>
                                        <option value="easeInSine">easeInSine</option>
                                        <option value="easeOutSine">easeOutSine</option>
                                        <option value="easeInOutSine">easeInOutSine</option>
                                        <option value="easeInExpo">easeInExpo</option>
                                        <option value="easeOutExpo">easeOutExpo</option>
                                        <option value="easeInOutExpo">easeInOutExpo</option>
                                        <option value="easeInCirc">easeInCirc</option>
                                        <option value="easeOutCirc">easeOutCirc</option>
                                        <option value="easeInOutCirc">easeInOutCirc</option>
                                        <option value="easeInElastic">easeInElastic</option>
                                        <option value="easeOutElastic">easeOutElastic</option>
                                        <option value="easeInOutElastic">easeInOutElastic</option>
                                        <option value="easeInBack">easeInBack</option>
                                        <option value="easeOutBack">easeOutBack</option>
                                        <option value="easeInOutBack">easeInOutBack</option>
                                        <option value="easeInBounce">easeInBounce</option>
                                        <option value="easeOutBounce">easeOutBounce</option>
                                        <option value="easeInOutBounce">easeInOutBounce</option>
                                    </select>
                                </td>
                            </tr>		
                        </table>

                    </div>
                </div>
            </div>
          </div>
        </div>

        {if $languages|count > 1}
        </div>
    {/if}
    
</form>    
{/foreach}
</div>

<div class="col-lg-12 form-group clearfix">
    <div class="row">
        <div class="col-lg-9 col-lg-offset-3">
            <a class="btn btn-default dash_trend_right" href="javascript:void(0)" onclick="return $('#module_form').submit();"><i class="icon-save"></i> {l s='Save Slider' mod='pssliderlayer'}</a>
        </div>
    </div>
</div>

{*script for all language*}
{literal}
    <script type="text/javascript">
        var title_image = "{/literal}{l s='Image Management'}{literal}";
        var txt_input_title = "{/literal}{l s='Please input title of slider for all language'}{literal}";
        
        $(".btn-remove-backurl").click(function(){
            var field = 'slider-image_';
            langID = findActiveLang();
            if ($('#' + field + langID).val()) {
                correctLink = "";
                $('#' + field + langID).val(correctLink);
                $("#slider-editor-wrap_"+langID+" .simage").html('');
            }
        });
 
        $(".btn-update-slider").click(function() {
            var field = 'slider-image_';
            $('#dialog').remove();
            $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="'+ajaxfilelink+'&lang_id='+findActiveLang()+'" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

            $('#dialog').dialog({
                title: title_image,
                close: function(event, ui) {
                    langID = findActiveLang();
                    if ($('#' + field + langID).val()) {
                        correctLink = $('#' + field + langID).val();
                        $('#' + field + langID).val(correctLink);
                        $("#slider-editor-wrap_"+langID+" .simage").html('<img src="' + psBaseModuleUri + correctLink + '">');
                    }
                },
                bgiframe: false,
                width: 782,
                height: 445,
                resizable: true,
                draggable:false,
                modal: false
            });
        });


    </script>
    <script type="text/javascript">
        $( document ).ready( function(){
            var $ptsEditor = $(document).ptsSliderEditor();
            var delay = '{/literal}{$delay|escape:'htmlall':'UTF-8'}{literal}';
            {/literal}
            {foreach from=$languages item=language}{literal}
                $ptsEditor.countItem[{/literal}{$language.id_lang|escape:'htmlall':'UTF-8'}{literal}] = 0;
            {/literal}{/foreach}
            {literal}
            $ptsEditor.process(SURLIMAGE, delay);
            {/literal}
            {if $layers}
            {foreach from=$layers item=layer}{literal}
                $ptsEditor.createList( '{/literal}{$layer.content}{* JSON data, can not escape *}{literal}' , {/literal}{$layer.langID|escape:'htmlall':'UTF-8'}{literal} );
            {/literal}{/foreach}{/if}
            {literal}
            $(".btn-actionslider").click(function(){
                if($(this).attr("href").indexOf("deleteSlider") != -1){
                    if(!confirm('Delete Selected Slider?')) return false;
                }
                $.ajax( {url:$(this).attr("href"),  dataType:"JSON",type: "GET"}  ).done( function(output){
                        if(output.error){
                            alert(output.text);
                        }else{
                            location.reload();
                        }
                } );
                return false;          
            });
            
            $(".slider-backcolor").change(function() {
                $(this).closest(".slider-layers").find(".simage").first().css("background-color",$(this).val());
            });
            
            $(".slider-backcolor").each(function() {
                if($(this).val())
                $(this).closest(".slider-layers").find(".simage").first().css("background-color",$(this).val());
            });
        });


        $(".slider-preview").click(function() {
            var url = $(this).attr("href")+"&content_only=1";
            $('#dialog').remove();
            $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe name="iframename2" src="' + url + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
            $('#dialog').dialog({
                title: 'Preview Management',
                close: function(event, ui) {

                },
                bgiframe: true,
                width: 1000,
                height: 500,
                resizable: false,
                draggable:false,
                modal: true
            });
            return false;
        });
        
        function image_upload(field, thumb) {
            $('#dialog').remove();

            $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="'+ajaxfilelink+'&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

            $('#dialog').dialog({
                    title: title_image,
                    close: function (event, ui) {
                        correctLink = $('#' + field).val();
                        $('#' + field).val(correctLink);
                        $('#' + thumb).attr("src",psBaseModuleUri+correctLink);
                        $('#' + thumb).show();
                    },	
                    bgiframe: false,
                    width: 700,
                    height: 400,
                    resizable: false,
                    draggable:false,
                    modal: false
            });
        };
    </script>
    <script type="text/javascript">
        function findActiveLang(){
            languageID = $("#current_language").val();
            if($('.form-language').length){
                $('.form-language').each(function(){
                    if($(this).is(':visible')){
                        languageID = $(this).attr("data-action");
                        return false;
                    }
                });
            }
            return languageID;
        }
    </script>
{/literal}
</fieldset>