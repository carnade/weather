<html>
<head>
  <title>weather data collection</title>
</head>
<body>
    <?php 
    require 'database.php';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postdata = json_decode(file_get_contents("php://input"));
        if (($loc = $postdata->{"loc"}) == null) die("Missing location");
        if (($device = $postdata->{"device"}) == null) die("Missing location");
        if (($type = $postdata->{"type"}) == null) die("Missing location") ;
        if (($value = $postdata->{"value"}) == null) die("Missing location") ;
        if (($time = $postdata->{"time"}) == null) die("Missing location") ;

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
