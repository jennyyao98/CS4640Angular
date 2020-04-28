
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');



// retrieve data from the request
$postdata = file_get_contents("php://input");

// Extract json format to PHP array and convert json string to array
$request = json_decode($postdata);
$rating = (int)$request->{'name'};// $data = [];



// Connect to Db
$server = "localhost";
$username = "root";
$password = "";
$dbname = "Reciplz";

$conn = mysqli_connect($server, $username, $password, $dbname);


// Insert rating in to database
$query = "INSERT INTO posts (webRating) VALUES ('$rating')";
if ($conn->query($query) == TRUE) {
  echo json_encode(['content'=>'success']);
} else {
  echo json_encode(['content'=>'failed']);
}

?>
