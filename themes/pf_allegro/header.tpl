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
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<html{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}" {/if} dir="{$LANG_DIRECTION}" class="{$LANG_DIRECTION}">
	<head>
		<meta charset="utf-8" />
		<title>{$meta_title|escape:'html':'UTF-8'}</title>
{if isset($meta_description) AND $meta_description}
		<meta name="description" content="{$meta_description|escape:'html':'UTF-8'}" />
{/if}
{if isset($meta_keywords) AND $meta_keywords}
		<meta name="keywords" content="{$meta_keywords|escape:'html':'UTF-8'}" />
{/if}
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
		<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" /> 
		<meta name="apple-mobile-web-app-capable" content="yes" /> 
		<link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />
		<link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />
{if isset($css_files)}
	{foreach from=$css_files key=css_uri item=media}
		{if preg_match("#global#",$css_uri)}
		<link rel="stylesheet" href="{$css_uri|escape:'html':'UTF-8'}"  id="global-style" type="text/css" media="{$media|escape:'html':'UTF-8'}" />
		{else}
		<link rel="stylesheet" href="{$css_uri|escape:'html':'UTF-8'}" type="text/css" media="{$media|escape:'html':'UTF-8'}" />
		{/if}
	{/foreach}
{/if}
{if isset($js_defer) && !$js_defer && isset($js_files) && isset($js_def)}
	{$js_def}
	{foreach from=$js_files item=js_uri}
	<script type="text/javascript" src="{$js_uri|escape:'html':'UTF-8'}"></script>
	{/foreach}
{/if}
		{$HOOK_HEADER}
		<link href='http{if Tools::usingSecureMode()}s{/if}://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700' rel='stylesheet' type='text/css' media="all" />
		<link href='http{if Tools::usingSecureMode()}s{/if}://fonts.googleapis.com/css?family=Heebo:300,400,500,700,800,900' rel='stylesheet' type='text/css' media="all" />
		<!--[if IE 8]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	</head>
	<body{if isset($page_name)} id="{$page_name|escape:'html':'UTF-8'}"{/if} class="{if isset($page_name)}{$page_name|escape:'html':'UTF-8'}{/if}{if isset($body_classes) && $body_classes|@count} {implode value=$body_classes separator=' '}{/if}{if $hide_left_column} hide-left-column{/if}{if $hide_right_column} hide-right-column{/if}{if isset($content_only) && $content_only} content_only{/if} lang_{$lang_iso} layout-{$DEFAUTL_LAYOUT}" >

	{if !isset($content_only) || !$content_only}
		{if isset($restricted_country_mode) && $restricted_country_mode}
			<div id="restricted-country">
				<p>{l s='You cannot place a new order from your country.'} <span class="bold">{$geolocation_country|escape:'html':'UTF-8'}</span></p>
			</div>
		{/if}
			
		<div id="page">
			{capture name='displayBanner'}{hook h='displayBanner'}{/capture}
			{if $smarty.capture.displayBanner}
				<div  class="banner hidden-xs hidden-sm">
					<div class="container">
						{$smarty.capture.displayBanner}
					</div>
				</div>
			{/if}
			{if !isset($header_cp)}
				{$header_cp = Configuration::get('PTS_CP_HEADER')}
			{/if}
			{if $header_cp && file_exists("$CURRENT_THEMEDIR./sub/headers/{$header_cp}/{$header_cp}.tpl")}
				{include file="$CURRENT_THEMEDIR./sub/headers/{$header_cp}/{$header_cp}.tpl" page_name_skin=$page_name}
				
			{/if}
    
            {if Configuration::get('PTS_CP_ENABLE_PBUILDER')&&isset($PTS_PAGEBUILDER_ACTIVED)&&$PTS_PAGEBUILDER_ACTIVED&&$PTS_PAGEBUILDER_FULL}
            	<div id="columns" class="pagebuilder-content">
					{$PTS_PAGEBUILDER_CONTENT}
			{else}
			{if $page_name =='index'}
           		<div  id="pts-slideshow" class="slideshow">
		                {hook h="displayslideshow"}
           		</div>
            {/if}
            {if $page_name =='index'}
	          	<div  id="pts-promotion-top" class="promotion-top">
					<div class="container">
			            {hook h="displaypromotetop"}
			        </div>       
	            </div>
            {/if}
			<div id="columns" class="offcanvas-siderbars">
				{if $page_name =='index'}
					<div id="top_column" class="top_column ">
						<div class="container">{hook h="displayTopColumn"}</div>
					</div>				
				{/if}	
				{if $page_name !='index' && $page_name !='pagenotfound'}
					<div id="breadcrumb">
						{include file="$tpl_dir./breadcrumb.tpl"}
					</div>
				{/if}
				<div class="main-content">	
					<div class="main-content-inner no-gutter   aaaa">
						<div class="container">											
							<div class="row">
								{if isset($left_column_size) && !empty($left_column_size)}
									<div id="left_column" class="sidebar column col-xs-12 col-sm-12 col-md-{$left_column_size|intval} col-lg-{$left_column_size|intval} offcanvas-sidebar">
										{$HOOK_LEFT_COLUMN}
									</div>
								{/if}
							{if isset($left_column_size) && isset($right_column_size)}{assign var='cols' value=(12 - $left_column_size - $right_column_size)}{else}{assign var='cols' value=12}{/if}
							<div id="center_column" class="center_column col-xs-12 col-sm-12 col-md-{$cols|intval} col-lg-{$cols|intval}">
								<div id="content">
									
				{/if}
			{/if}
