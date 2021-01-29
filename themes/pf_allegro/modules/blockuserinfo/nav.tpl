	{if !isset($header_cp)}
		{$header_cp = Configuration::get('PTS_CP_HEADER')}
	{/if}
	{if $header_cp && file_exists("$CURRENT_THEMEDIR./sub/headers/{$header_cp}/modules/blockuserinfo/nav.tpl")}
		{include file="$CURRENT_THEMEDIR./sub/headers/{$header_cp}/modules/blockuserinfo/nav.tpl" page_name_skin=$page_name}
	{else}
		<div class="btn-group group-userinfo pull-right">
			<ul class="list-inline">
				<li id="header_user">
		<div class="btn-group group-userinfo">
			<ul class="list-inline">
				<li>
					<!-- Block user information module NAV  -->
					<div class="group-title current hidden-md hidden-lg current"><span class="sub-title">{l s='Settings' mod='blockuserinfo'}</span>&nbsp;<span class="icon icon-angle-down"></span></div>
					<ul class="list-style list-inline content_top toogle_content">
						{if $logged}
							<li>	
								<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account" rel="nofollow"><span class="icon icon-user"></span>&nbsp;&nbsp;<span>{$cookie->customer_firstname} {$cookie->customer_lastname}</span></a>
								<a href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" title="{l s='Log me out' mod='blockuserinfo'}" class="logout" rel="nofollow">({l s='Log out' mod='blockuserinfo'})</a>
							</li>
						{else}
							<li>
								<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='Login to your customer account' mod='blockuserinfo'}" rel="nofollow"><span class="icon icon-user"></span>&nbsp;&nbsp;{l s='Login' mod='blockuserinfo'}</a>
							</li>
						{/if}
						<!--<li >
							<a href="{$link->getModuleLink('blockwishlist', 'mywishlist', array(), true)|addslashes|escape:'html':'UTF-8'}" title="{l s='My wishlists' mod='blockuserinfo'}"><span class="icon icon-heart"></span>&nbsp;&nbsp;{l s='Wish List' mod='blockuserinfo'}</a>
						</li>
						<li>
							<a href="{$link->getPageLink('products-comparison')|escape:'html':'UTF-8'}" title="{l s='Compare' mod='blockuserinfo'}"><span class="icon icon-refresh"></span>&nbsp;&nbsp;{l s='Compare' mod='blockuserinfo'}</a>
						</li>-->
						<li class="last"><a href="{$link->getPageLink($order_process, true)|escape:'html':'UTF-8'}" title="{l s='Checkout' mod='blockuserinfo'}" class="last"><span class="icon icon-cart-plus"></span>&nbsp;&nbsp;{l s='Checkout' mod='blockuserinfo'}</a></li>
					</ul>
				</li>			
			</ul>
		</div>	

				</li>			
			</ul>
		</div>	
	{/if}
