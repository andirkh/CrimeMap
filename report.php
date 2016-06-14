<?php
include "dbconnect.php"
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Import -->
	<link rel="stylesheet" href="css/lib/foundation.min.css">
	<link rel="stylesheet" href="css/lib/bootstrap-material-datetimepicker.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="css/app.css">
    
    <link rel="shortcut icon" type="image/png" href="img/favicon.ico"/>
	<!-- Import -->

	<style type="text/css">
		.row{
			padding: 10px 0;
		}

		.title-row{
			background-color: #6699ff;
			color: white;
			padding: 20px;
			text-align: center;
			max-width: 100%;
			margin: 0 0 20px 0;
		}

		.btn-flat{
			padding: 8px;
			margin: 0 5px;
			background-color: #6699ff;
			color: white;
			border-radius: 4px;
		}
		.material-icons{
			color:white;
		}
		.dtp-header{
			background-color: #6699ff !important;
		}
	</style>

	<title>CrimeMap - Report A Crime</title>
</head>
<body>

	<div class="row title-row">
		<div class="large-12 columns">
            <a href=index.php><img src="img/crimemaplogofull.png" width="150px" /></a>
		</div>
	</div>
	<form action="submit.php" method="get">
		<div class="row" style="padding: 0">
			<div class="small-12 large-6 columns" style="background-color: white;">
				<div class="row">
					<div class="small-6 columns">
						Name
					</div>
					<div class="small-6 columns">
						<!-- <input type="text"/> -->
						<a onclick="alert('User function has not been implemented yet.');">PutUsernameHere</a>
					</div>
				</div>
				
				<div class="row">
					<div class="small-6 columns">
						Crime Type
					</div>
					<div class="small-6 columns">
						<select name="inputCrime">
							<?php
							$sql = "SELECT crime_id, crime_name FROM `crimes`";
							$result = mysqli_query($conn, $sql);
							if (mysqli_num_rows($result) > 0) {
							    // output data of each row
								while($row = mysqli_fetch_assoc($result)) {
									echo"<option value=" . $row['crime_id'] . ">" . $row['crime_name'] . "</option>";
								}
							} else {
								echo "0 results";
							}
							?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="small-6 columns">
						Time
					</div>
					<div class="small-6 columns">
						<!--input type="text"/-->
						<input name="inputTime" type="text" id="date-format" />
					</div>
				</div>

				<div class="row">
					<div class="small-6 columns">
						Crime Location
					</div>
					<div class="small-6 columns">
						<div class="row">
							<div class="small-9	 columns">
								<input id="address" type="text" value="">
							</div>									
							<div class="small-3 columns">
								<div class="button tiny" id="searchMap"><i class="material-icons">search</i></div>
							</div>
						</div>
						<div class="row">
							<div class="small-6 columns">
								<input name="inputLat" id="latText" type="text"/>
							</div>
							<div class="small-6 columns">
								<input name="inputLng" id="longText" type="text"/>
							</div>
						</div>
					</div>
				</div>			
				<!-- div class="row">
					<div class="button" onclick="">Create Marker Test</div>
				</div> -->		
			</div>
			<div class="small-12 large-6 columns" style="background-color: white;">
				<div class="row" style="padding: 0;">
					<div id="google_map" style="width:100%;height:400px;"></div>
				</div>
			</div>
		</div>
		<div class="row" style="margin-top: 30px;">
			<div class="small-3 small-offset-9 large-1 large-centered columns">
				<input type="submit" class="alert button" value="Report">
			</div>
		</div>	
	</form>

</body>
<!-- Import -->
<script src="js/lib/what-input.js"></script>
<script src="js/lib/jquery.js"></script>
<script src="js/lib/foundation.min.js"></script>
<script src="js/lib/moment.js"></script>
<script src="js/lib/bootstrap-material-datetimepicker.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCUS5MdQUGiFzAQ5nz3qWgjnrYdHZXBFdw"></script>
<script src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>
<script src="js/lib/jquery.geocomplete.js"></script>
<script src="js/app.js"></script>
<!-- Import -->
<script type="text/javascript">
	var geoLatitude = -7.2574527;
	var geoLongitude = 112.7489953;

	$(document).ready(function() {

		// Responsive Google Map
		google.maps.event.addDomListener(window, "resize", function() {
			var center = map.getCenter();
			google.maps.event.trigger(map, "resize");
			map.setCenter(center); 
		});

		// Date Time Stuff
		$('#date-format').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:MM:SS', nowButton: true });
		$('#date-format').val(moment().format('YYYY-MM-DD HH:MM:SS'));

		// Geolocation
		if (navigator.geolocation) {
			var startPos;
			var geoSuccess = function(position) {
				var startPos = position;
				geoLatitude = startPos.coords.latitude;
				geoLongitude = startPos.coords.longitude;
				$("#latText").val(geoLatitude);
				$("#longText").val(geoLongitude);
				myCenter = new google.maps.LatLng(geoLatitude, geoLongitude);

				map_initialize(); // load map
			};
			navigator.geolocation.getCurrentPosition(geoSuccess);
		}
		else {
			geoLatitude = -7.2574527;
			geoLongitude = 112.7489953;
		}

	});

	function map_initialize(){
		var mapProp = {
			center:myCenter,
			zoom:13,
			mapTypeId:google.maps.MapTypeId.ROADMAP
		};

		map = new google.maps.Map(document.getElementById("google_map"),mapProp);
		marker=new google.maps.Marker({position:myCenter});
		marker.setMap(map);

		
		/*fitur search geocode*/
		var geocoder = new google.maps.Geocoder();
		document.getElementById('searchMap').addEventListener('click', function() {
			geocodeAddress(geocoder, map);
		});

		/*fungsi geocode untuk mencari lokasi*/
		function geocodeAddress(geocoder, resultsMap) {
			var address = document.getElementById('address').value;
			geocoder.geocode({'address': address}, function(results, status) {
				if (status === google.maps.GeocoderStatus.OK) {
					resultsMap.setCenter(results[0].geometry.location);
					marker.setPosition(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
					document.getElementById("latText").value= results[0].geometry.location.lat();
					document.getElementById("longText").value= results[0].geometry.location.lng();
				} else {
					alert('Geocode was not successful for the following reason: ' + status);
				}
			});

		}

		var input =(document.getElementById('address'));
		var options = {
			bounds: myCenter,
			zoom:20,
			types: ['establishment']
		};
		autocomplete = new google.maps.places.Autocomplete(input, options);
		autocomplete.bindTo('bounds', map);

			//update marker
			google.maps.event.addListener(map, 'click', function(event) {
				/*placeMarker(event.latLng);*/

				var infowindow = new google.maps.InfoWindow({
					content: 'Latitude: ' + '<br>Longitude: ' });
				
				marker.setPosition(new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()));
				document.getElementById("latText").value= event.latLng.lat();
				document.getElementById("longText").value= event.latLng.lng();
			});
		}
</script>
</html>
