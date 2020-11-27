<?php
session_start();

require_once "pdo.php";
require_once "bootstrap.php";



if ( isset($_POST['delete']) && isset($_POST['autos_id']) ) {
    // $_SESSION['name'] = $_POST['email'];
    $sql = "DELETE FROM autos WHERE autos_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['autos_id']));
    $_SESSION['message'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

// $_SESSION['name'] = $_POST['email'];
$stmt = $pdo->prepare("SELECT autos_id FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
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

<p>Confirm: Deleting <?= htmlentities($row['autos_id']) ?></p>

<form method="post">
<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="index.php">Cancel</a>
</form>

</div>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
</body>
</html>