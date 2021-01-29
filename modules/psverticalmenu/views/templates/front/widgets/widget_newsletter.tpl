{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   psverticalmenu
* @version   1.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
<div id="newsletter_block_footer" class="block pts-newsletter">
	<h4 class="title_block">{l s='Newsletter' mod='psverticalmenu'}</h4>
	<div class="block_content">
 
		<form action="{$link->getPageLink('index')|escape:'html':'UTF-8'}" method="post">
             {if $information}
             <div class="newsletter-info">{$information}{* HTML, can not escape *}</div>
             {/if}
             <div class="alert alert-danger hide">{l s='Newsletter: Invalid email address' mod='psverticalmenu'}</div>
		      <div class="input-group">
				<input   class="form-control"  id="newsletter-input-footer" type="text" name="email"  value="{if isset($value) && $value}{$value|escape:'htmlall':'UTF-8'}{else}{l s='your e-mail' mod='psverticalmenu'}{/if}" />
				<input type="hidden" name="action" value="0" />
                <span class="input-group-btn">                
                     <button type="submit" class="btn btn-default" name="submitNewsletter" >{l s='Go!' mod='psverticalmenu'}</button>              
                </span>

			</div>
		</form>
        {if isset($smarty.post.email) && $smarty.post.email neq {l s='your e-mail' mod='pspagebuilder' js=1} }
        <div class="alert {$classalert}">{$alert}</div>
        {/if}
	</div>
</div>
<!-- /Block Newsletter module-->
 


<script type="text/javascript">
    var placeholder = "{l s='your e-mail' mod='psverticalmenu' js=1}";
    {literal}
        $(document).ready(function() {
            $('#newsletter-input-footer').on({
                focus: function() {
                    if ($(this).val() == placeholder) {
                        $(this).val('');
                    }
                },
                blur: function() {
                    if ($(this).val() == '') {
                        $(this).val(placeholder);
                    }
                }
            });

            $("#newsletter_block_footer form").submit( function(){  
                if ( $('#newsletter-input-footer').val() == placeholder) {
                    $("#newsletter_block_footer .alert").removeClass("hide");
                    return false;
                }else {
                     $("#newsletter_block_footer .alert").addClass("hide");
                     return true;
                }
            } );
        });

    {/literal}
</script>