<!-- Helen Lin (hl5ec), Jenny Yao (jy7eq), Selinie Wang (jw6qe)-->

<?php
  session_start();
  // include 'dbConnection.inc.php'
  include 'recipe_db.php';


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="authors" content="Jenny Yao, Selinie Wang, Helen Lin">
  <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="recipePage.css">

  <title>Main Entrees | Grilled Lemon Salmon</title>
  <script type="text/javascript">
    /* function addReview - when the button AddReview is clicked the text typed in textare will display in Review section*/
    function addReview() {
      var text = document.getElementById("textReview");
      var showarea = document.getElementById("newReview");
      showarea.innerHTML = text.value;
    }

    /* function change - when the save button is clicked the color of the box-shadow & the text of the save button will be changed*/
    function change() {
      var card = document.querySelector('.card');
      var saveButton = document.getElementById("saveBtn");
      console.log(card.style);
      if (saveBtn.value == "Save") {
        saveBtn.value = "Saved!";
        saveBtn.style.backgroundColor = "#c71a2e";
        card.style.boxShadow = "-1px 0px 0px 6px rgba(255,158,158,1)";

      } else {
        saveBtn.value = "Save";
        saveBtn.style.backgroundColor = "#FF4258";
        card.style.boxShadow = "10px 10px 25px -3px rgba(0,0,0,0.1)";
      }
    }

  </script>
</head>

<body>
    <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
        <a class="navbar-brand" href="homePage.php">LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="homePage.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>
          </ul>
        </div>
      </nav>
    <!-- NAVBAR end -->

  <div class="container">
  <!-- ASSUME FOR NOW USER CLICKS ON SALMON RECIPE -->
<?php
        // Get info from Recipes Table where the RecipeID is equal to the recipe clicked on in the Recipe Results page
        $sql = 'SELECT * FROM Recipes WHERE RecipeID='. $_GET['id'];
        $result = mysqli_query($conn, $sql);
        $queryResult = mysqli_num_rows($result);
        if ($queryResult > 0) {

          // FUNCTION -- star rating
          $sql_2='SELECT * FROM  RecipesReviews WHERE RecipeID=' . $_GET['id'];
          $result_2 = mysqli_query($conn, $sql_2);
          $sum = 0;
          while($row = mysqli_fetch_array($result_2)) {
            $ratingRow =  (int) $row['Rating'];
            $sum += $ratingRow;
          }
          if (mysqli_num_rows($result_2)>0) {
            $avgRating = round($sum/mysqli_num_rows($result_2));
          }
          else{
            $avgRating = 0;
          }


          // FUNCTION -- create an array of recipe's ingredients by parsing by ;
          $sql_4 = 'SELECT * FROM RecipesContent WHERE RecipeID='. $_GET['id'];
          $result_4 = mysqli_query($conn, $sql_4);
          while($row = mysqli_fetch_array($result_4)) {
            $stringIngr = $row['Ingredients'];
            $ingred_array = explode(";", $stringIngr);
          }
          // $ingred_array = explode(";", $result_4);

          // FUNCTION -- create an array of recipe's directions by parsing by ;
          $sql_5 = 'SELECT * FROM RecipesContent WHERE RecipeID='. $_GET['id'];
          $result_5 = mysqli_query($conn, $sql_5);
          while($row = mysqli_fetch_array($result_5)) {
            $stringDirec = $row['Directions'];
            $direc_array = explode(";", $stringDirec);
          }

          // FUNCTION -- Recipe Reviews. Make a array for each column of recipe reviews
          $sql_6 =
          'SELECT *
           FROM RecipesReviews
           JOIN Users
             ON RecipesReviews.UserID = Users.UserID
           WHERE RecipeID='. $_GET['id'];
          $result_6 = mysqli_query($conn, $sql_6);
          $userArr = array();
          $ratingArr = array();
          $reviewNameArr = array();
          $reviewDescripArr = array();
          $reviewTime = array();
          while($row = mysqli_fetch_array($result_6)) {
            array_push($userArr,$row['Username']);
            array_push($ratingArr,$row['Rating']);
            array_push($reviewNameArr,$row['ReviewName']);
            array_push($reviewDescripArr,$row['ReviewDescrip']);
            array_push($reviewTime,$row['timeStamp']);
            // echo "number of rows<br/>";
          }

          // FUNCTION -- Get the creator of the recipe
          $sql_7 =
          'SELECT Username
           FROM Recipes
            JOIN Users
              ON Recipes.UserID = Users.UserID
            WHERE RecipeID='. $_GET['id'];
          $result_7 = mysqli_query($conn, $sql_7);
          while ($row = mysqli_fetch_assoc($result_7)){
              $userName = $row['Username'];
          };

          // FUNCTION -- Save Button
          if(isset($_POST['id'])){
              if (isset($_SESSION['username'])){
                  saveRecipe($_SESSION['username'], $_POST['id']);
                  $is_saved = getSaved($_SESSION['username'], $_POST['id']);
              }else{
                  echo "Please login";
              }
          }

          while ($row=mysqli_fetch_assoc($result)){

            // FUNCTION -- Gets the difficulty of recipePage
            $sql_3 = 'SELECT difficulty FROM Recipes WHERE RecipeID='. $_GET['id'];
            $result_3 = mysqli_query($conn, $sql_3);




              echo "

              <button onClick='window.print()'type='button' class='btn btn-secondary'>Print this page</button>
              <!--Recipe Card-->
              <div class='card'>
                <div class='row'>
                  <div class='col-sm'>
                    <img class='card-img' src='".$row['imageLink']."' />
                  </div>
                  <div class='col-sm'>
                    <h3>".$row['RecipeName']."</h3>
                    <div><!--Print out number of stars-->";
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
                      };
                      echo "
                      ".$avgRating."/5   (".count($reviewNameArr)." reviews)
                    </div>
                    <small>
                      Recipe by ".$userName."
                    </small>
                    <p>Prep time: ".$row['prepTime']." hour</p>
                    <p>Level of difficulty: ".$row['difficulty']." </p>
                  </div>
                  <div class='col-sm'>
                    <div style='float: right; margin-right: 10px;''>
                      <form method='POST'>
                          <input name='save' type='submit' value='Save'</p>
                          <input type='hidden' name='id' value='".$_GET['id']."'></p>
                      </form>
                    </div>
                    <div style='float: right; margin-right: 10px;''>
                      <i>Dinner</i>
                    </div>
                  </div>
                </div>
              </div> <!--end of card -->

              <!-- Ingredients section -->
              <div class='ingredients'>
                <h4 class='subHead'>Ingredients</h4>
                <table style='width:100%''>";
                for ($i=0; $i < count($ingred_array); $i+=2) {
                  echo "<tr>
                    <td>".$ingred_array[$i]."</td>
                      <td>".$ingred_array[$i+1]."</td>
                  </tr>";
                }
                echo "</table>
              </div>  <!--end of ingredients -->

              <!-- Direction section -->
              <div class='directions'>
                <h4 class='subHead'>Directions</h4>
                <div class='grid-directions'>";
                for ($i=0; $i < count($direc_array); $i++) {
                  echo
                  "<div class='grid-item'><span class='number'>".($i+1)."</span></div>
                  <div class='grid-item'>".$direc_array[$i]."</div>";
                }
                echo "</div>
              </div> <!--end of directions -->
              <!--Review section start-->
              <div class='reviews'>
                <h4 style='display: inline; float: left; margin-right: 10px;' class='subHead'>Reviews</h4>
                <div style='display:inline; margin-right: 20px;'>";
                // Prints out number of avg stars
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
                ".$avgRating."/5
                (".count($reviewNameArr)." reviews)
                </div>";
              } // while loop
        } // if
?>
            <!-- Adding a review -->
                <p> Add a Review </p>
                <form class='' action=" <?php $_SERVER['PHP_SELF']?>" method='POST'>
                  <div class='form-group'>
                    <input class='form-control' id='textReview' name='Rating' placeholder='Number of Stars out of 5'></input>
                    <input class='form-control' id='textReview' name='ReviewsName' placeholder='Review Summary'></input>
                    <textarea class='form-control' id='textReview' name='ReviewDescrip' rows='3' placeholder='Go in detail...'></textarea>
                    <input type='submit' class='btn btn-primary btn-sm' value='+ Add Review' name='addReview' id='buttonReview' />

                  </div>
                </form>
<?php
                if(isset($_POST['addReview'])){
                  // try{
                    $query = 'INSERT INTO RecipesReviews(RecipeID, UserID, Rating, ReviewName, ReviewDescrip) VALUES (' .$_GET['id']. ',' .$_SESSION['id']. ',' .$_POST['Rating']. ', "' .$_POST['ReviewsName']. '", "' .$_POST['ReviewDescrip'].'")';
                    // add SQL statement into the database
                    if ($conn->query($query) === TRUE) {
                      // header("Refresh:0");
                      echo "New record created successfully. Refresh to page to view your submitted review";
                    } else {
                      echo "Please type an integer for the Rating and try again";
                    }

              } // end IF statement
                echo "<div class='review-list'>
                   <div id='newReview'>  <!--this div is where the new addedReview will be inserted -->


                  </div>
                  ";
                  // Print out all of the reviews
                  if(count($reviewNameArr)!=0){
                    for ($i=0; $i < count($reviewNameArr); $i++) {
                      $indRating =$ratingArr[$i];
                      $indName =$userArr[$i];
                      $indReviewName =$reviewNameArr[$i];
                      $indReviewDescrip =$reviewDescripArr[$i];
                      $indReviewTime =$reviewTime[$i];


                      echo "<div class='review-item' style='margin-bottom: 20px;'>
                      <strong>".$indName."</strong><br/>";

                      if ($indRating == 5){
                        for ($j=0; $j < $indRating ; $j++) {
                          echo "<span class='fa fa-star checked'></span>";
                        };
                      }
                      else if ($indRating < 5){
                          for ($j=0; $j < $indRating ; $j++) {
                            echo "<span class='fa fa-star checked'></span>";
                          };
                          for ($j=0; $j < 5-$indRating ; $j++) {
                            echo "<span class='fa fa-star'></span>";
                          };
                      }
                      echo "
                      ".$indReviewName."<br/>
                      <i>".$indReviewTime."</i><br/>

                      ".$indReviewDescrip."
                      </div>"; // end of review item

                    }// end of FOR loop
                  }// end of IF loop
                  else{
                    echo "No Reviews right now. Be the first to add one.";
                  }
                  echo"
                </div>  <!--end of reviews list -->
              </div>  <!--end of reviews section -->
              ";
?>
  </div> <!--end of reviews section -->
</body>
</html>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
