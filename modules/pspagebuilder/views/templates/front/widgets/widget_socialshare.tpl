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

{if $PS_SC_TWITTER || $PS_SC_FACEBOOK || $PS_SC_GOOGLE || $PS_SC_PINTEREST}
	<p class="ptssocialsharing_product list-inline no-print">
		{if $PS_SC_TWITTER}
			<button type="button" class="btn btn-default btn-twitter" onclick="ptssocialsharing_twitter_click('{$pagename|addslashes|escape:'html':'UTF-8'} {$pagelink|addslashes|escape:'html':'UTF-8'}');">
				<i class="icon-twitter"></i> <span>Tweet</span>
			</button>
		{/if}
		{if $PS_SC_FACEBOOK}
			<button type="button" class="btn btn-default btn-facebook" onclick="ptssocialsharing_facebook_click();">
				<i class="icon-facebook"></i><span> facebook</span>
			</button>
		{/if}
		{if $PS_SC_GOOGLE}
			<button type="button" class="btn btn-default btn-google-plus" onclick="ptssocialsharing_google_click();">
				<i class="icon-google-plus"></i> <span>Google+</span>
			</button>
		{/if}
		{if $PS_SC_PINTEREST}
			<button type="button" class="btn btn-default btn-pinterest" onclick="ptssocialsharing_pinterest_click();">
				<i class="icon-pinterest"></i> <span>Pinterest</span>
			</button>
		{/if}
	</p>
{/if}