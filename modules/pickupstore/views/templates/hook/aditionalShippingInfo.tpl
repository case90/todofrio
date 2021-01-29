<script>
	var latitude = '{$latitude}';
	var longitude = '{$longitude}';
</script>

<div class="col-xs-4 nopadding">
	<div id="PickupStoreAdditionalInfo" style="line-height: 50px;">
		<div>
			<span><strong>{l s='Sucursal: ' mod='pickupstore'}</strong>{$pickupstore.name}</span>
		</div>
		<div>
			<span><strong>{l s='Fecha para recoger mercancía: ' mod='pickupstore'}</strong>{$pickupstore.pickup_date|date_format:"%d/%b/%y"}</span>
		</div>
		<div>
			<span><strong>{l s='Dirección: ' mod='pickupstore'}</strong>{$pickupstore.address1} {$pickupstore.address2}</span>
		</div>
	</div>
</div>
<div class="col-xs-8 nopadding">
	<div id="historyMap" style="width: 100%; height: 400px;"></div>
</div>

{literal}
<script type="text/javascript">

        var neighborhoods = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
        var map = new google.maps.Map(document.getElementById('historyMap'), {
          zoom: 15,
          center: neighborhoods
        });
        var marker = new google.maps.Marker({
          position: neighborhoods,
          map: map
        });
    
</script>
{/literal}

