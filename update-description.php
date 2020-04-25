<!-- Selinie Wang (jw6qe), Helen Lin (hl5ec), Jenny Yao (jy7eq) -->

<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
require "dbConnection.inc.php";
 
$new_update = "";
$new_update_err = "";

// Validate form data
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Update description in SQL
    $sql = "UPDATE Users SET Description = '".$_POST['new_update']."' WHERE UserID = '". $_SESSION['id']."'";
    $result = $conn->query($sql);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Description</title>
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
    <div align="center" class="loginbar">
        <div style="width: 400px; margin-top: 30px">
            <img width="400px" src="https://media.giphy.com/media/jtj1ESIdlNDzzccTIV/giphy.gif">
            <p></p>
            <div style="width: 360px; letter-spacing: 0.7px">
                <a href="./profile.php">
                    <p align="right" style="font-size: 12px; color: #fd455c; margin-left: 100;">
                        Go back to user profile.</p></a>
                <div align="left">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($new_update_err)) ? 'has-error' : ''; ?>">
                            <b><label>Update Description:</label></b>
                            <input type="text" name="new_update" size="44" style="height: 150px" placeholder="     Enter new description"
                                value="<?php echo $new_update; ?>">
                            <span class="help-block"><?php echo $new_update_err; ?></span>
                        </div>
                        <div align="center" style="margin-top: 30px;">
                                <input type="submit" id="subbutton" style="width: 150px"
                                    value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>