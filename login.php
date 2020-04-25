<!-- Selinie Wang (jw6qe), Helen Lin (hl5ec), Jenny Yao (jy7eq) -->

<?php
session_start();
 
// Check if user has already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: profile.php");
    exit;
}
 
require_once "dbConnection.inc.php";
 
$username = $password = $description = "";
$username_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT UserID, Username, Password FROM Users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                           
                            
                            header("location: profile.php");
                        } else{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<title>Login</title>
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
</head>

<body>
    <!-- Login form code -->
    <div align="center" class="loginbar">
        <div style="width: 400px; margin-top: 30px">
        <img width="400px" src="https://media.giphy.com/media/jtj1ESIdlNDzzccTIV/giphy.gif">
        <a href="./register.php">
            <div align="center" style="width: 360px; letter-spacing: 0.7px">
            <p></p>
            <p align="right" style="font-size: 12px; color: #fd455c; margin-left: 100">Don't have
                an account? Register.</p>
        </a>
        <form align="left" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <b><label>Username:</label></b>
                <input type="text" name="username" id="username" placeholder="     Enter username" size="44"
                    value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <p></p>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <b><label>Password:</label></b>
                <input type="password" placeholder="     Enter valid password" id="passtext" name="password"
                    required maxlength="18" minlength="8" size="44"
                    value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <p></p>
            <input type="checkbox" onclick="showPassword()" id="showpass" style="font-size: 5px"> show password
            <p></p>
            <div align="center">
                <input type="submit" id="subbutton" style="width: 200px" value="Log In">
            </div>
        </form>
        </div>
        <div style="margin-top: 25px">
        <img width="400px" src="https://i.imgur.com/XmV4zDV.jpg">
        </div>
    </div>

    <!-- Function to show password -->
    <script>
      function showPassword() {
        var x = document.getElementById("passtext");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
    </script>
</body>
</html>