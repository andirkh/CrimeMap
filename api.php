<link rel="shortcut icon" type="image/png" href="img/favicon.ico"/>
<title>CrimeMap API JSON</title>
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

		$sql = "select reports.report_id, crimes.crime_name, reports.report_time, reports.longitude, reports.latitude from reports JOIN crimes ON (reports.crime_id = crimes.crime_id)";
		$result = mysqli_query($conn, $sql);
//		if (mysqli_num_rows($result) > 0) {
//		    // output data of each row
//		    while($row = mysqli_fetch_assoc($result)) {
//		        // echo"<option>" . $row['crime_name'] . "</option>";
//		        echo "initMarker(" . $row['longitude'] . ", ". $row['latitude'] . ", '" . $row['crime_name'] . " pada " . $row['report_time'] . "');";
//		    }
//		} 


$return_arr = Array();

while ($row = mysqli_fetch_assoc($result)) {
    array_push($return_arr,$row);
}

echo json_encode($return_arr);

?>