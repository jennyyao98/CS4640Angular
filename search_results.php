<!-- Helen Lin (hl5ec), Jenny Yao (jy7eq), Selinie Wang (jw6qe)-->
<?php 
//   require('dbconnection.inc.php');
require('recipe_db.php');
$server = "localhost";
$username = "root";
$password = "";
$dbname = "Reciplz";

$conn = mysqli_connect($server, $username, $password, $dbname);
session_start();
?>

<!DOCTYPE html>

<html>
<head>
    <title>Search Results</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="recipePage.css">
    <script type="text/javascript" src="jquery-3.3.1.js"></script>
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/fa27627a5d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-transparent">
        <a class="navbar-brand" href="#">LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="homePage.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
          </ul>
        </div>
    </nav>
      <div class="container">
      <!-- Search and filter form-->
      <form class="form-inline justify-content-center" id="searchform" method = "GET" action = "search_results.php" >
        <div class="input-wrapper">
            <input class="form-control mr-sm-5 search" id="query" name="search" value = "" type="text" placeholder= "Search for Cheese Cake" size="80">
        </div>
        <div class="filter" id="form1">
        <div class="form-row filter-form">
          <div class="form-group col-md-3">
            <label for="inputState">Prep Time</label>
            <div class="selectWrapper">
                <select class="selectBox" name="prepTime">
                <option value = "" selected>All</option>
                <option value = "1">&lt; 1 hour</option>
                <option value = "2">&lt; 2 hour</option>
                <option value = "3">&lt; 3 hour</option>
              </select>
            </div>
          </div>
          <div class="form-group col-md-3">
            <label for="inputState">Difficulty</label>
            <div class="selectWrapper">
                <select class="selectBox" name="difficulty">
                <option value = "" selected >All</option>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
              </select>
            </div>
          </div>
          <input class = "filterbutton" type="submit" name="submit" value="search">
        </div>
        </div>
        </form>
        <?php
        if (isset($_GET['submit'])){
            // --------- FILTER ----------
            $filterClause = array();
            if (! empty($_GET['prepTime'])) $filterClause[] ="prepTime<=".mysqli_real_escape_string($conn, $_GET['prepTime'])."";
            if (! empty($_GET['difficulty'])) $filterClause[] ="difficulty='".mysqli_real_escape_string($conn, $_GET['difficulty'])."'"; 
            $filter = ''; 
            if (count($filterClause) > 0) { $filter = "AND ".implode(' AND ',$filterClause); } 
            $search = mysqli_real_escape_string($conn, $_GET['search']);
            $sql = "SELECT * FROM Recipes WHERE RecipeName LIKE '%$search%' " .$filter." ";
            $result = mysqli_query($conn, $sql);
            $queryResult = mysqli_num_rows($result);
            if ($queryResult > 0){
                if(isset($_POST['id'])){
                    if (isset($_SESSION['username'])){
                        saveRecipe($_SESSION['username'], $_POST['id']);
                        //$is_saved = getSaved($_SESSION['username'], $_POST['id']);
                    }else{
                        echo "Please login";
                    }
                }
                while ($row=mysqli_fetch_assoc($result)){
                    $recipe_id = $row['RecipeId'];    //variable that stores recipe id
                    $avgRating = getAverageRating($recipe_id); // call function to get average
                    echo "
                    <div class='card'>
                        <div class='row'>
                            <div class='col-sm'>
                                <img class='card-img' src='".$row['imageLink']."' />
                            </div>
                            <div class='col-sm'>
                                <a href='recipePage.php?id=$recipe_id' name='recipe' class='recipe-link'><h3>".$row['RecipeName']."</h3></a>
                                <div>";
                                if ($avgRating == 5){
                                    for ($i=0; $i < $avgRating ; $i++) {
                                        echo "<span class='fa fa-star checked'></span>";
                                    };
                                } else {
                                    for ($i=0; $i < $avgRating ; $i++) {
                                        echo "<span class='fa fa-star checked'></span>";
                                    };
                                    for ($i=0; $i < 5-$avgRating ; $i++) {
                                        echo "<span class='fa fa-star'></span>";
                                    };
                                }
                                echo "
                                </div>
                                <small>Recipe by Selinie Wang</small>
                                <p>Prep time: ".$row['prepTime']." hour</p>
                                <p>Level of difficulty: ".$row['difficulty']." </p>
                            </div>
                            <div class='col-sm'>
                                <div style='float: right; margin-right: 10px;''>";
                                
                                echo "
                                <form method='POST'>
                                    <input name='save' type='submit' value=";
                                     echo getSaved($_SESSION['username'], $recipe_id) ? 'Save' : 'Saved';
                                     echo "
                                     <p><input type='hidden' name='id' value='$recipe_id'></p>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
                
            }else{
                echo "Oops, there are no recipes matching that search";
            }
        }
    ?>
      <br>
      <p id="displayResults"></p>
  </div>
</body>
</html>

 <!-- Arrow function to display number of search results -->
<script>
    var numResults;
    numResults = () =>{
        var x = document.getElementsByName("recipe");
        return "Showing " + x.length + " result(s)";
    }
    document.getElementById("displayResults").innerHTML = numResults();
</script>