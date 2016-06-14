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
		<!-- Import -->

		<style type="text/css">
			.row {
				padding: 10px 0;
			}
			
			.title-row {
				background-color: #6699ff;
				color: white;
				padding: 20px;
				text-align: center;
				max-width: 100%;
				margin: 0 0 20px 0;
			}
			
			.btn-flat {
				padding: 8px;
				margin: 0 5px;
				background-color: #6699ff;
				color: white;
				border-radius: 4px;
			}
			
			.material-icons {
				color: white;
			}
			
			.dtp-header {
				background-color: #6699ff !important;
			}
		</style>

		<title></title>
	</head>

	<body>
		<div class="row title-row">
			<div class="large-12 columns">
				<img src="img/crimemaplogofull.png" width="150px" />
			</div>
		</div>


		<?php
	$sql = "SELECT crime_id, crime_name FROM `crimes`";
	$result = mysqli_query($conn, $sql);

	$inputCrime = $_GET["inputCrime"];
	$inputTime = $_GET["inputTime"];
	$inputLat = $_GET["inputLat"];
	$inputLng = $_GET["inputLng"];

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "INSERT INTO `reports` (`crime_id`, `report_time`, `longitude`, `latitude`) VALUES ('". $inputCrime ."', '".$inputTime."','".$inputLat."', '".$inputLng."');";

	if ($conn->query($sql) === TRUE) {
		echo "Report Submitted!";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
	?>

			<div class="row" style="margin-top: 30px;">
				<div class="small-3 small-offset-9 large-1 large-centered columns">
					<a href="report.php" class="alert button">Back</a>
				</div>
			</div>

	</body>
	<!-- Import -->
	<script src="js/lib/what-input.js"></script>
	<script src="js/lib/jquery.js"></script>
	<script src="js/lib/foundation.min.js"></script>
	<script src="js/lib/moment.js"></script>
	<script src="js/lib/bootstrap-material-datetimepicker.js"></script>
	<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCUS5MdQUGiFzAQ5nz3qWgjnrYdHZXBFdw"></script>
	<script src="http://maps.googleapis.com/maps/api/js?libraries=places"></script>
	<script src="jquery.geocomplete.js"></script>
	<script src="js/app.js"></script>
	<!-- Import -->
	<script type="text/javascript">
	</script>

	</html>