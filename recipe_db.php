<!-- Helen Lin (hl5ec), Jenny Yao (jy7eq), Selinie Wang (jw6qe)-->
<?php 
$server = "localhost";
$username = "root";
$password = "";
$dbname = "Reciplz";

$conn = mysqli_connect($server, $username, $password, $dbname);

function getAverageRating($id)
{
   global $conn;
   $sql="SELECT * FROM  RecipesReviews WHERE RecipeID = '$id'";
   $result = mysqli_query($conn, $sql);
   $sum = 0;
    while($row = mysqli_fetch_array($result)) {
        $ratingRow =  (int) $row['Rating'];
        $sum += $ratingRow;
    }
    if(mysqli_num_rows($result) > 0){
        $avgRating = round($sum/mysqli_num_rows($result));
    }else{
        $avgRating = 0;
    }
   return $avgRating;
}

function saveRecipe($username, $recipe)
{
   global $conn;
   if(getSaved($username, $recipe)){
      $query = "INSERT INTO favorites(RecipeId, username) VALUES ('$recipe', '$username')";
   } else {
      $query = "DELETE FROM favorites WHERE favorites.username = '$username' AND favorites.RecipeId = '$recipe'";
   }
   $statement = $conn->prepare($query); 
   $statement->execute();
   // closes the cursor and frees the connection to the server so other SQL statements may be issued 
   $statement->conn = null;
}

// returns True or False if theres a row for user id and recipe id
function getSaved($username, $recipe)
{
   global $conn;
   $sql = "SELECT * FROM favorites WHERE username = '$username' AND RecipeId = '$recipe'";
   $result = mysqli_query($conn, $sql);
   if (mysqli_num_rows($result) == 0){
      return True;
   } else{
      return False;
   }

}
?>