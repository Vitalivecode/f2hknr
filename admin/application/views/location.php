<table class="table table-bordered table-hover table-striped responsive">
	<tbody>
													<tr><td>IP</td><td><?=$location->ip;?></td></tr>
													<tr><td>Country</td><td><?=$location->country_name;?></td></tr>
													<tr><td>Region</td><td><?=$location->region_name;?></td></tr>
													<tr><td>City</td><td><?=$location->city;?></td></tr>
													<tr><td>Zip code</td><td><?=$location->zip_code;?></td></tr>
													<tr><td>Latitude and Longitude</td><td><?=$location->latitude.','.$location->longitude;?></td></tr>
													<tr><td>Area and Metro codes</td><td><?=$location->metro_code;?></td></tr>
												</tbody>
</table>
<div id="google-map-tab">
	<div id="map-location" style="width:100%; height:500px;"></div>
</div>
<script type="text/javascript">
								if ($('#map-location').length) {
									jQuery(function($) {
										$(document).ready(function() {
										var baseurl = '<?=base_url();?>';
										var lat = '<?=$location->latitude; ?>';
										var lang = '<?=$location->longitude; ?>';
									var map,
										service;
											var latlng = new google.maps.LatLng(lat,lang);
											var myOptions = {
												zoom: 16,
												center: latlng,
												mapTypeId: google.maps.MapTypeId.ROADMAP,
												scrollwheel: false
											};
								
											map = new google.maps.Map(document.getElementById("map-location"), myOptions);
								
											var marker = new google.maps.Marker({
												position: latlng,
												map: map,
												icon: baseurl+'img/hotel.png'
											});
											marker.setMap(map);
										});
									});
}
</script>