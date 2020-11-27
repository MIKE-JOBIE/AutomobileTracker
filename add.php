<?php
session_start();

require_once "bootstrap.php"; 
require_once "pdo.php";


if ( ! isset($_SESSION['name']) ) {
    die('Access Denied');
  }



if ( isset($_POST['logout']) ) {
    session_start();
    session_destroy();
    header('Location: index.php');
    return;
}

$failure = false;
$message = false;

// $name = htmlentities($_SESSION['name']);





if ( isset($_POST['make']) &&  isset($_POST['model']) &&  isset($_POST['year']) &&  isset($_POST['mileage'])) {

    if ( strlen($_POST['make']) < 1 && strlen($_POST['model']) < 1 && strlen($_POST['year']) < 1 && strlen($_POST['mileage']) < 1) {
        $_SESSION['failure'] = "All fields are required";
        header("Location: add.php");
        return;
            } else if (!is_numeric($_POST['year'])) {
                $_SESSION['failure'] = "Year must be an integer";
                header("Location: add.php");
                return;
            } else if (!is_numeric($_POST['mileage'])) {
                $_SESSION['failure'] = "Mileage must be an integer";
                header("Location: add.php");
                return;
            } else {
                // $check = hash('md5', $salt.$_POST['pass']);
                $sql = "INSERT INTO autos (make, year, mileage) VALUES (:mk, :yr, :mi)";

                $stmt = $pdo->prepare('INSERT INTO autos
                (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
                $stmt->execute(array(
                ':mk' => $_POST['make'],
                ':md' => $_POST['model'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage']) );

                $_SESSION['message'] = "Record added";
                header("Location: index.php");
                return; 
            }


}

?>












<!DOCTYPE html>
<html>
<head>
<title>Michael Jobie Musa</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">

<?php
if ( isset($_SESSION['name']) ) {
    echo "<h1>Tracking Autos for: ";
    echo htmlentities($_SESSION['name']);
    echo "</h1>\n";                                                 


    if ( isset($_SESSION['failure']) ) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['failure'])."</p>\n");
        unset($_SESSION['failure']);
    }
    
    
}
?>

<!-- echo('<p style="color: green;">'."Record Inserted"."</p>\n"); -->
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Model:
<input type="text" name="model" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Cancel">
</form>


</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>

