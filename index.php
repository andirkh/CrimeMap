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
			html,
			body {
				height: 90%;
			}
			
			.row {
				padding: 10px 0;
				margin: 0;
				max-width: 100%;
			}
			
			.title-row {
				background-color: #6699ff;
				color: white;
				padding: 20px;
				text-align: center;
				max-width: 100%;
				position: relative;
			}
		</style>

		<title>CrimeMap - Crime Heatmap Viewer</title>
	</head>

	<body>

		<div class="row title-row">
			<div class="large-12 columns">
				<a href=#><img src="img/crimemaplogofull.png" width="150px" /></a>
			</div>
		</div>
		<div class="row" style="padding: 0; height: 100%; text-align: center;">
			<div id="google_map" style="width:100%;height:100%;"></div>
		</div>
		<div class="row" style="text-align: center;">
			<a href="report.php">
				<div class="alert button" id="reportButton" style="display: inline-block;">Report a crime</div>
			</a>
            <a href="api.php">
				<div class="alert button" id="reportButton" style="display: inline-block;">Use our API</div>
			</a>
		</div>

	</body>
	<!-- Import -->
	<script src="js/lib/what-input.js"></script>
	<script src="js/lib/jquery.js"></script>
	<script src="js/lib/foundation.min.js"></script>
	<script src="js/lib/moment.js"></script>
	<script src="js/lib/bootstrap-material-datetimepicker.js"></script>
	<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCUS5MdQUGiFzAQ5nz3qWgjnrYdHZXBFdw"></script>
	<script src="js/app.js"></script>
	<!-- Import -->
	<script type="text/javascript">
		var map;

		function initMap() {
			var myCenter = new google.maps.LatLng(-7.2574527, 112.7489953);
			var mapProp = {
				center: myCenter,
				zoom: 13,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};

			map = new google.maps.Map(document.getElementById("google_map"), mapProp);


			// loop db here
			<?php
		  $sql = "select * from reports INNER JOIN crimes ON (crimes.crime_id = reports.crime_id)";
		  $result = mysqli_query($conn, $sql);
		  if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		  	while($row = mysqli_fetch_assoc($result)) {
		  		echo "initMarker(" . $row['longitude'] . ", ". $row['latitude'] . ", '" . $row['crime_name'] . " pada " . $row['report_time'] . "');";
		  	}
		  } 
		  ?>

			// loop db here
		}

		function initMarker(latitude, longitude, mapMessage) {
			var myCenter = new google.maps.LatLng(latitude, longitude);

			var marker = new google.maps.Marker({
				position: myCenter,
			});

			marker.setMap(map);

			var myCity = new google.maps.Circle({
				center: myCenter,
				radius: 500,
				strokeColor: "#FA1616",
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: "#FA1616",
				fillOpacity: 0.4
			});

			myCity.setMap(map);

			var infowindow = new google.maps.InfoWindow({
				content: mapMessage
			});

			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map, marker);
			});
		}

		google.maps.event.addDomListener(window, 'load', initMap);
	</script>

	</html>