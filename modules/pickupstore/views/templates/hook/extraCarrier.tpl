<!-- MODULE pickupstore -->


<script>
	var shipping_id = '{$shipping_id}';
</script>

<div id="pickupstore">
	<div id="PickupStoreFormContainer">
		
		<div class="col-xs-12" style="padding-left: 0px;">
			<h2>{l s='Recoger en tienda.' mod='pickupstore'}</h2>
		</div>

		<div class="col-xs-12 col-md-6" style="padding-left: 0px;">
			<fieldset>
				<div class="form-group">
					<label class="control-label col-sm-12" style="padding-left: 0px;">
						<strong>{l s='Por favor seleccione la sucursal en donde va a recoger la mercanía.' mod='pickupstore'}</strong>
						<span> *</span>
					</label>
					<div class="col-sm-10">
						<div class="row">
							<select name="stores" id="stores" class="form-control">
						    	<option value="0" selected>{l s='Por favor seleccione una sucursal.' mod='pickupstore'}</option>
						    	{assign var=allStores value=[]} 
								{foreach $stores as $store}
									{assign var=row value=[]}
									{$row['id_store'] 	= $store.id_store}
									{$row['name'] 		= $store.name}
									{$row['address1'] 	= $store.address1}
									{$row['address2'] 	= $store.address2}
									{$row['postcode'] 	= $store.postcode}
									{$row['latitude'] 	= $store.latitude}
									{$row['longitude'] 	= $store.longitude}
									{$allStores[] = $row}
						       		<option value="{$store.id_store}" data-latitude="{$store.latitude}" data-longitude="{$store.longitude}" data-address1="{$store.address1}" data-address2="{$store.address2}">{$store.name}</option>
						       	{/foreach}
						    </select>
						</div>
						
						<div class="row">
							<div class="addressStore">
								<span class="lblAddress"><strong>{l s='Dirección: ' mod='pickupstore'}</strong></span>
								<span class="valAddress"></span>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group" >
					<label class="control-label col-sm-12" style="padding-left: 0px; margin-top: 25px;">
						<strong>{l s='Por favor seleccione la fecha en la cual recogerá la mercancía.' mod='pickupstore'}</strong>
						<span> *</span>
					</label>
					<div class="col-sm-10">
						<div class="row">
						   	<div class='input-group date' id='datetimepicker1'>
			                    <input type='date' name="pickupDate" id="pickupDate" class="form-control" />
			                </div>
						</div>
						<div class="row">
							
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="col-xs-12 col-md-6" style="padding: 0px;">
			<div id="PickupStoreMap"></div>
		</div>
	</div>

	
</div>

<script>
	var parseStores = '{$allStores|json_encode}'; 
</script>

{literal}
<script type="text/javascript">
	
	var map;
	var markers 		= [];
	var objStores 		= JSON.parse(parseStores);
	var neighborhoods = [
		{lat: -25.363, lng: 131.044},
	];
	
	var map = new google.maps.Map(document.getElementById('PickupStoreMap'), {
		zoom: 12,
		center: {lat: 25.70, lng: -100.29}
	});
	function addMarkerWithTimeout(position, timeout) {
		
		window.setTimeout(function() {
			markers.push(new google.maps.Marker({
				position: position,
				map: map,
				animation: google.maps.Animation.DROP
			}));
		}, timeout);
	}

	
	clearMarkers();
	for (var i = 0; i < objStores.length; i++) {

		var obj = {lat: parseFloat(objStores[i].latitude), lng: parseFloat(objStores[i].longitude)}
		addMarkerWithTimeout(obj, i * 200);
	}
	
	function clearMarkers() {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
        }
        markers = [];
    }

	function toggleBounce() {
		if (marker.getAnimation() !== null) {
			marker.setAnimation(null);
		} else {
			marker.setAnimation(google.maps.Animation.BOUNCE);
		}
	}





</script>
{/literal}
<!-- /MODULE pickupstore -->