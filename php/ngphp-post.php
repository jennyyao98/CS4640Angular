
<?php
// session_start();

// header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');


// get the size of incoming data
// $content_length = (int) $_SERVER['CONTENT_LENGTH'];

// retrieve data from the request
$postdata = file_get_contents("php://input");

// Process data
// (this example simply extracts the data and restructures them back)

// Extract json format to PHP array
$request = json_decode($postdata);
// $data = [];
// $data[0]['length'] = $content_length;
// foreach ($request as $k => $v)
// {
//   $data[0]['post_'.$k] = $v;
// }

// Send response (in json format) back the front end
// echo $request;
$server = "localhost";
$username = "root";
$password = "";
$dbname = "Reciplz";

$conn = mysqli_connect($server, $username, $password, $dbname);

// echo json_encode(['content'=>$request]);

// try{
// $query = "INSERT INTO posts(postId, webRating) VALUES ('2',' . $request . ')";
$query = "INSERT INTO posts (webRating) VALUES ('. $request[0] .')";

// $conn->query($query);
// echo "hi";
// add SQL statement into the database
if ($conn->query($query) === TRUE) {
// if (1==1) {
  // code...
  // echo json_encode(['content'=>"success"]);
  echo json_encode(['content'=>$request]);
  // echo ;
} else {
  // echo json_encode(['content'=>"failed"]);
  echo json_encode(['content'=>$request]);
}

// $data = [];
// $data[0]['length'] = $content_length;
// foreach ($request as $k => $v)
// {
//   $data[0]['post_'.$k] = $v;
// }
// sql statements here
// Send response (in json format) back the front end

// do we still need to send the info back through this echo statement or can we just do the click function on .ts file?
// echo json_encode(['content'=>$data]);
//echo s retrieve sql code
?>
