<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ah-crimereport";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

		$sql = "select * from reports INNER join mapmarkers ON (mapmarkers.map_marker_id = reports.marker_id) INNER JOIN crimes ON (crimes.crime_id = reports.crime_id)";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		        // echo"<option>" . $row['crime_name'] . "</option>";
		        echo "initMarker(" . $row['longitude'] . ", ". $row['latitude'] . ", '" . $row['crime_name'] . " pada " . $row['report_time'] . "');";
		    }
		} 

?>