<!-- Selinie Wang (jw6qe), Helen Lin (hl5ec), Jenny Yao (jy7eq) -->
<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$dbname = "Reciplz";

$conn = mysqli_connect($server, $username, $password, $dbname);

// Display description from Users table
$sql = 'SELECT * FROM Users WHERE UserID =  '.$_SESSION['id'].'';
$result = $conn->query($sql);

while($row = mysqli_fetch_array($result)) {
    $descr =  $row['Description'];
}

// Join two tables to display the RecipeID after it is saved
$sql2 = 'SELECT * FROM Users JOIN favorites ON Users.Username = favorites.username
           WHERE UserID = '. $_SESSION['id'];
$result2 = $conn->query($sql2);
$userarr1 = array();
while($row = mysqli_fetch_array($result2)) {
    array_push($userarr1, $row['RecipeId']);
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link href="style.css" rel="stylesheet">
    <script type="text/javascript" src="jquery-3.3.1.js"></script>
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/fa27627a5d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<body>
    </head>

    <body>
        <!-- Navigation bar code -->
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
            <img class="navbar-brand" height="30px" href="#" src="https://i.imgur.com/9wVzybw.jpg">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost:4200">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Profile Code -->
        <div align="center">
            <div align="left" class="profilebox"
                style="margin-top: 30px; width: 1000px; padding: 20px; flex-direction: row; display: flex; justify-content: space-between;">
                <div align="center" style="background-color: white; width: 300px;">
                <a href="reset-password.php" style="background-color: lightgray; margin-bottom: 20px;
                    border: none" class="btn btn-warning">Reset Password</a>
                    <img class="profile-pic" width="250"
                        src="https://vignette.wikia.nocookie.net/caramella-girls/images/9/99/Blankpfp.png/revision/latest?cb=20190122015011">
                    <div align="center" style="padding: 35px;">
                        <input class="file-upload" type="file" accept="image/*" />
                        <!--
                        <div align="center"
                            style="display: flex; flex-direction: row; font-size: 12px; margin-top: 20px; justify-content: space-around;">
                            <img src="https://image.flaticon.com/icons/svg/61/61183.svg" width="20" height="20"
                                onclick="follow_user();" />
                            <div id="followuser" style="color: #fd455c;">
                                <p>Currently not following this user.</p>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
                <div style="background-color: white; width: 640px; padding-left: 35px; padding-right: 35px;">
                    <b>
                        <p style="font-size: 20px;"><?php echo 'Welcome, ' . $_SESSION['username'] . '.'; ?></p>
                    </b>
                    <div style="font-size: 12px;">
                        <p style="color:gray; text-align: justify;"><?php echo $descr; ?></p>
                        <a href="update-description.php"><img align="right" style="width:13px"
                            src="https://image.flaticon.com/icons/svg/61/61112.svg"/></a>
                        <b>
                            <p style="margin-top: 50px; color: #fd455c;">Saved Recipes:</p>
                        </b>
                        <div style="padding-left: 15px;">
                            <p><?php
                            for ($i=0; $i < count($userarr1); $i++) {
                                echo "$userarr1[$i]<br>";
                            }
                            ?></p>
                        </div>
                    </div>
                </div>
    </div>

        <script>
            // Had help using GeekforGeeks
            // Function to upload profile picture
            $(document).ready(function () {
                var readURL = function (input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('.profile-pic').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $(".file-upload").on('change', function () {
                    readURL(this);
                });
                $(".upload-button").on('click', function () {
                    $(".file-upload").click();
                });
            });

            // Function to follow and unfollow user
            function follow_user() {
                var x = document.getElementById("followuser");
                if (x.innerHTML === "Currently not following this user.") {
                    x.innerHTML = "Currently following this user.";
                } else {
                    x.innerHTML = "Currently not following this user.";
                }
            }
        </script>

    </body>

</html>
