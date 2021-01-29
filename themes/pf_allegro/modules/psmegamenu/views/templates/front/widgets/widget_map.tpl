{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   psmegamenu
* @version   2.5
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
<div id="map-canvas" style="width:{$width|escape:'html':'UTF-8'}; height:{$height|escape:'html':'UTF-8'};"></div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
	var map;
    function initialize() {
		try{
			if(google){ 
				var myLatlng = new google.maps.LatLng( {$latitude|escape:'html':'UTF-8'}, {$longitude|escape:'html':'UTF-8'} );
				var mapOptions = {
					zoom: {$zoom|escape:'html':'UTF-8'},
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};

				map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
				var marker = new google.maps.Marker({
				            position: myLatlng,
				            title: " "
				           });
				marker.setMap(map);
			}
			
		}catch(e){

		}	
    } 
 	google.maps.event.addDomListener(window, 'load', initialize);

</script>
