{*
* 2007-2016 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if !isset($content_only) || !$content_only}
  			{if Configuration::get('PTS_CP_ENABLE_PBUILDER')&&isset($PTS_PAGEBUILDER_ACTIVED)&&$PTS_PAGEBUILDER_ACTIVED&&$PTS_PAGEBUILDER_FULL}

  				</div ><!-- .columns-container -->
			{else}


							</div>
						</div><!-- #center_column -->
								{if isset($right_column_size) && !empty($right_column_size)}
									<div id="right_column" class="col-xs-12 col-sm-12 col-md-{$right_column_size|intval} column sidebar">{$HOOK_RIGHT_COLUMN}</div>
								{/if}
				
							</div><!-- #columns -->
						</div>
					</div>
				</div>
					{if $page_name =='index'}
					<div id="content-bottom">
						<div class="container">
							<div class="row">
								{hook h='displayContentBottom'}
							</div>
						</div>
					</div>
					{/if}
				</div ><!-- .columns-container -->
				<!-- Bottom-->
				{if $page_name =='index'}
					<div id="bottom">
						<div class="container">
							{hook h='displayBottom'}
						</div>
					</div>
				{/if}
			{/if}
		
			{if isset($PTS_FOOTERBUILDER_CONTENT)&&!empty($PTS_FOOTERBUILDER_CONTENT)}	
				<footer id="footer">
					{$PTS_FOOTERBUILDER_CONTENT}

						{if class_exists('PtsthemePanel')}
							{plugin module='ptssocialsidebar' hook='footer'}
						{/if}

					<div id="pts-footercenter">
						<div class="container">
							<div class="inner">
								<div class="row">
									{$HOOK_FOOTER}
								</div>
							</div>
						</div>
					</div>
				</footer>
			{elseif isset($HOOK_FOOTER)}
			<!-- Footer -->
				<footer id="footer">			
					<div id="pts-footer-top" class="footer-top">
						<div class="container">
							<div class="inner">
								{hook h='displayFootertop'}
								{if class_exists('PtsthemePanel')}
									{plugin module='blocknewsletter' hook='footer'}
								{/if}
								<a href="http://www.pekdijital.com" style="color: #333;">Bartın Web Tasarım</a>
							</div>
						</div>
					</div>
					
					<div id="pts-footercenter" class="footer-center">
						<div class="container">
							<div class="inner">
								<div class="row">
									{$HOOK_FOOTER}
								</div>
							</div>
						</div>
					</div>
					<div id="pts-footer-bottom" class="footer-bottom">
						<div class="container">
							<div class="inner">
									{hook h='displayFooterbottom'}
							</div>
						</div>
					</div>
				</footer>
			{/if}
		</div>
		<!-- gototop -->
		{if !$content_only}
		<a id="to_top" href="javascript:;" style="display: inline;"><span class="hidden-xs hidden-sm">&nbsp;</span></a>
		{/if}
		<!-- #page -->
{/if}

{include file="$tpl_dir./global.tpl"}
	<div id="fancybox-compare-add" style="display:none;">
	   <div id="fancybox-html">
	    <div class="msg">{l s='Add product to compare successful'}</div>
	    <a href="{$link->getPageLink('products-comparison')|escape:'html':'UTF-8'}" title="{l s='compare product'}">
	      <strong>{l s='Compare'} </strong>
	    </a>
	   </div>
	  </div>

	  <div id="fancybox-compare-remove" style="display:none;">
	   <div id="fancybox-html1">
	    <div class="msg">{l s='Remove product successful'}</div>
	    <a href="{$link->getPageLink('products-comparison')|escape:'html':'UTF-8'}" title="{l s='compare product'}">
	     <strong>{l s='Click here to compare'}</strong>
	    </a>
	   </div>
	  </div>
	</body>
</html>