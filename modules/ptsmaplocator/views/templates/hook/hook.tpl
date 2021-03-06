{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   ptsmaplocator
* @version   1.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
<div class="box ptsmaplocator">
    <h3 class="page-subheading">{l s='Map Locator' mod='ptsmaplocator'}</h3>
    <div class="box-content">
        {if !empty($pts_description)}
            <div class="description">{$pts_description}{* HTML, can not escape *}</div>
        {/if}
        <div class="maplocator">
            <div id="directory-main-bar-{$mod_id|escape:'htmlall':'UTF-8'}" class="gmap"></div>
        </div>
        
        <div class="box-shop">
            {if isset($pts_stores)}
                {assign var='i' value=0}
                {foreach $pts_stores as $key=>$location}
                    {math equation="x + y"  x=$i  y=1 assign=i}
                    <div class="item-location" id="location-{$location["id_store"]|escape:'htmlall':'UTF-8'}" data-id="shop{$i|escape:'htmlall':'UTF-8'}" data-lat="{$location["latitude"]|escape:'htmlall':'UTF-8'}" data-lon="{$location["longitude"]|escape:'htmlall':'UTF-8'}">
                        <div class="shop-title">
                            <i class="icon-map-marker"></i>{$location['name']|escape:'htmlall':'UTF-8'}
                        </div>
                        <div class="shop-address">{$location['address1']|escape:'htmlall':'UTF-8'}</div>
                    </div>
                {/foreach}
            {/if}
        </div>
    </div>
</div>

<script type="text/javascript">
{literal}
var mapDiv, map, infobox;
jQuery(document).ready(function($) {
	mapDiv = $("#directory-main-bar-{/literal}{$mod_id|escape:'htmlall':'UTF-8'}{literal}");
	mapDiv.height({/literal}{$pts_height|escape:'htmlall':'UTF-8'}{literal}).gmap3({
		{/literal}
		{if count($pts_stores) > 1}
		map: {
			options: {
				"draggable": true
				,"mapTypeControl": true
				,"mapTypeId": google.maps.MapTypeId.ROADMAP
				,"scrollwheel": true //Alow scroll zoom in, zoom out
				,"panControl": true
				,"rotateControl": false
				,"scaleControl": true
				,"streetViewControl": true
				,"zoomControl": true
			}
		}
		{else}
		map:{
			options:{
				"mapTypeId": google.maps.MapTypeId.ROADMAP
				,"center": [{$pts_stores[0]['latitude']|escape:'htmlall':'UTF-8'}, {$pts_stores[0]['longitude']|escape:'htmlall':'UTF-8'}]
				,"zoom": 15
				,"maxZoom": 17
			}
		}
		{/if}
		{literal}
		,marker: {
			values: [{/literal}
                            {assign var='i' value=0}
                            {foreach $pts_stores as $location}{literal}
                            {{/literal}
                                {math equation="x + y"  x=$i  y=1 assign=i}
                                    {literal}
                                    latLng: [{/literal}{$location['latitude']|escape:'htmlall':'UTF-8'}, {$location['longitude']|escape:'htmlall':'UTF-8'}],{literal}
                                    options: { {/literal}
                                            icon: "{$location['icon']|escape:'htmlall':'UTF-8'}",
                                            //shadow: "icon-shadow.png",
                                    {literal}
                                    },
                                            {/literal}
                                    data: '<div class="marker-holder">\n\
                                    <div class="marker-content with-image">{if $location.has_picture}<img src="{$img_store_dir|escape:'htmlall':'UTF-8'}{$location.id_store|escape:'htmlall':'UTF-8'}.jpg" alt="">{/if} \n\
                                        <div class="map-item-info">\n\
                                            <div class="title">'+"{$location['name']|escape:'htmlall':'UTF-8'}"+'</div>\n\
                                            <div class="address">'+"{$location['address1']|escape:'htmlall':'UTF-8'}"+'</div>\n\
                                            <div class="description">'+'{$location['working_hours']}{* HTML, can not escape *}'+'</div>\n\
                                            </div><div class="arrow"></div>\n\
                                            <div class="close"></div>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>', 'id':'shop{$i|escape:'htmlall':'UTF-8'}'
                            {literal}},{/literal}
                            {/foreach}
                            {literal}
			],
			options:{
				draggable: false, //Alow move icon location
			},
			cluster:{
				radius: 20,
				// This style will be used for clusters with more than 0 markers
				0: {
					content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
					width: 90,
					height: 80
				},
				// This style will be used for clusters with more than 20 markers
				20: {
					content: "<div class='cluster cluster-2'>CLUSTER_COUNT</div>",
					width: 90,
					height: 80
				},
				// This style will be used for clusters with more than 50 markers
				50: {
					content: "<div class='cluster cluster-3'>CLUSTER_COUNT</div>",
					width: 90,
					height: 80
				},
				events: {
					click: function(cluster) {
						map.panTo(cluster.main.getPosition());
						map.setZoom(map.getZoom() + 2);
					}
				}
			},
			events: {
				click: function(marker, event, context){
					map.panTo(marker.getPosition());

					infobox.setContent(context.data);
					infobox.open(map,marker);

					// if map is small
					var iWidth = 260;
					var iHeight = 300;
					if((mapDiv.width() / 2) < iWidth ){
						var offsetX = iWidth - (mapDiv.width() / 2);
						map.panBy(offsetX,0);
					}
					if((mapDiv.height() / 2) < iHeight ){
						var offsetY = -(iHeight - (mapDiv.height() / 2));
						map.panBy(0,offsetY);
					}

				}
			}
		}
	},"autofit");

	map = mapDiv.gmap3("get");
 	var classhtml = $('html').attr('dir');
	 if(classhtml == 'rtl') {
	  	infobox = new InfoBox({
		   pixelOffset: new google.maps.Size(220, -65),
		   closeBoxURL: '',
		   enableEventPropagation: true,
		   maxWidth: 150,
	  	});
 	} else {
  		infobox = new InfoBox({
		   pixelOffset: new google.maps.Size(-50, -65),
		   closeBoxURL: '',
		   enableEventPropagation: true,
		   maxWidth: 150,
  		});
 	}

	mapDiv.delegate('.infoBox .close','click',function () {
		infobox.close();
	});
        
	$(".box-shop .item-location").click(function(){
		var id = $(this).attr('data-id');
		var marker = $("#directory-main-bar-{/literal}{$mod_id|escape:'htmlall':'UTF-8'}{literal}").gmap3({ get: { id: id } });
		google.maps.event.trigger(marker, 'click');
		map.setCenter(marker.getPosition());
		map.setZoom(15);
	});
});
{/literal}
</script>
