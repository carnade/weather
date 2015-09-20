<html>
 <head>
  <title>weather data collection</title>
 </head>
 <body>
<?php 

//$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postdata = json_decode(file_get_contents("php://input"));
    $loc = $postdata->{"loc"};
    $device = $postdata->{"device"};
    $type = $postdata->{"type"};
    $value = $postdata->{"value"};
    $time = $postdata->{"time"};
//fwrite($myfile, $loc . $type . $device . $value . $time);



    $conn = get_db_connection();

    $value*=10;
    $sql = "INSERT into data (location, device, type, value, time)
	    VALUES ('$loc', '$device', '$type', $value, '$time')";

    if ($conn->query($sql) === TRUE) {
    } else {
	die("Could not execute SQL replace!");
 }

    $sql = "REPLACE into data_latest (location, device, type, value, time)
	    VALUES ('$loc', '$device', '$type', $value, '$time')";

    if ($conn->query($sql) === TRUE) {
    } else {
	die("Could not execute SQL replace!");
 }
    $conn->close();

} else {
	die("Not a webpage!");
}
//fclose($myfile);
?>


 </body>
</html>
