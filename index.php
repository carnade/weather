<?php

/////////////////////////////////////////////////////////////////////
// This is the only portion of the code you may need to change.
// Indicate the location of your images 
$root = '';
// use if specifying path from root
//$root = $_SERVER['DOCUMENT_ROOT'];

$path = 'img/';

// End of user modified section 
/////////////////////////////////////////////////////////////////////
 
function getImagesFromDir($path) {
    $images = array();
    if ( $img_dir = @opendir($path) ) {
        while ( false !== ($img_file = readdir($img_dir)) ) {
            // checks for gif, jpg, png
            if ( preg_match("/(\.gif|\.jpg|\.png)$/", $img_file) ) {
                $images[] = $img_file;
            }
        }
        closedir($img_dir);
    }
    return $images;
}

function getRandomFromArray($ar) {
    mt_srand( (double)microtime() * 1000000 ); // php 4.2+ not needed
    $num = array_rand($ar);
    return $ar[$num];
}


// Obtain list of images from directory 
$imgList = getImagesFromDir($root . $path);

$img = getRandomFromArray($imgList);
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Väderdata</title>
<style type="text/css">
body { font: 14px/1.3 verdana, arial, helvetica, sans-serif; }
h1 { font-size:1.3em; }
h2 { font-size:1.2em; }
a:link { color:#33c; } 
a:visited { color:#339; }
p { max-width: 60em; }
td { padding: 1px;width: 50px}

/* so linked image won't have border */
a img { border:none; }
img {
   
 height: auto;
 max-width: 50%;
} 

    table.table-style-three {
        font-family: verdana, arial, sans-serif;
        font-size: 11px;
        color: #333333;
        border-width: 1px;
        border-color: #3A3A3A;
        border-collapse: collapse;
    }
    table.table-style-three th {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #FFA6A6;
        background-color: #D56A6A;
        color: #ffffff;
    }
    table.table-style-three tr:hover td {
        cursor: pointer;
    }
    table.table-style-three tr:nth-child(even) td{
        background-color: #F7CFCF;
    }
    table.table-style-three td {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #FFA6A6;
        background-color: #ffffff;
    }

</style>
</head>
<body>

<h1>Hej test!</h1>

<p><?php 

$servername = "localhost";
$username = "root";
$password = "oFdsvdf!111";
$dbname = "Weather";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * from data_latest order by type desc";
    $result = ($conn->query($sql));

    echo "<table><tr><td>";
    echo "<table class=\"table-style-three\"><thead><tr><th>Typ</th><th>Just nu</th><th>Tidpunkt</th></tr></thead><tbody>";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $loc = $row["type"]=="temp" ? "Temp" : "Fukt";
	    echo "<tr>";
            echo "<td>$loc</td><td>" . $row["value"]/10 . "</td><td>" . $row["time"].  "</td><br>";
	    echo "</tr>";
        }
    } else {
       echo "0 results";
    }
    echo "</tbody></table>";
    echo "</td><td>";
    $sql2 = "SELECT d1.type, d1.min1,d1.avg1,d1.max1, d7.min7,d7.avg7,d7.max7, d30.min30, d30.avg30, d30.max30 \n"
	        . "FROM data1 d1, `data7` d7, data30 d30 WHERE d7.type=d30.type and d7.type = d1.type order by type desc";


    $result2 = ($conn->query($sql2));

	    echo "<table class=\"table-style-three\"><thead><tr><th>Typ</th><th>Min1</th><th>Avg1</th><th>Max1</th><th>Min7</th><th>Avg7</th><th>Max7</th><th>Min30</th><th>Avg30</th><th>Max30</th></tr></thead><tbody>";
    if ($result2->num_rows > 0) {
        while($row = $result2->fetch_assoc()) {
            $loc = $row["type"]=="temp" ? "Temp" : "Fukt";
	    echo "<tr>";
            echo "<td>$loc</td><td> " . round($row["min1"],2) . "</td><td>" . round($row["avg1"] ,2) . "</td><td> " . round($row["max1"],2) ."</td><td> " . round($row["min7"],2) . "</td><td> " . round($row["avg7"] ,2) . "</td><td> " . round($row["max7"] ,2). "</td><td> "  . round($row["min30"],2) . "</td><td> " . round($row["avg30"],2) . "</td><td> " . round($row["max30"],2). "</td><br>";

            //echo "<td>$loc</td> - min7: " . round($row["min7"],2) . " avg7: " . round($row["avg7"] ,2) . " max7: " . round($row["max7"] ,2). " min30: "  . round($row["min30"],2) . " avg30: " . round($row["avg30"],2) . " max30: " . round($row["max30"],2). "<br>";
	    echo "</tr>";
        }
    } else {
       echo "0 results";
    }
    echo "</tbody></table>";
    echo "</td></tr></table>";
?>
</p>

<!-- image displays here -->
<div><img src="<?php echo $path . $img ?>" alt="" /></div>


<p>&nbsp;</p>


</body>
</html>
