<?php
session_start();

if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
}

require_once "pdo.php";

if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {
	if( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {
		$_SESSION['failure'] = "All fields are required";
		header("Location: edit.php");
		return;
	} else if( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ) {
			$_SESSION['failure'] = "Mileage and year must be integers";
			header("Location: edit.php");
			return;
	} else {
		$stmt = $pdo->prepare('UPDATE autos SET make = :make, model = :model, year = :year, mileage=:mileage
									WHERE autos_id = :autos_id');
		$stmt->execute(array(
			':make' => $_POST['make'],
			':model' => $_POST['model'],
			':year' => $_POST['year'],
			':mileage' => $_POST['mileage'],
			':autos_id' => $_GET['autos_id']));
		$_SESSION['message'] = "Record updated";
		header("Location: index.php");
        return;
	}
}

if ( ! isset($_GET['autos_id']) ) {
	$_SESSION['error'] = "Missing autos_id";
	header('Location: index.php');
	return;
}

$stmt = $pdo->prepare('SELECT * FROM autos where autos_id = :xyz');
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<h1>Editing Auto</h1>
		<?php
		if ( isset($_SESSION['error']) ) {
			echo('<p style="color: red;">'.htmlentities($_SESSION['failure'])."</p>\n");
			unset($_SESSION['error']);
		}
		?>
		<form method="post">
			<p>Make:
				<input type="text" name="make" size="50" value="<?php echo $row['make'] ?>"/>
			</p>
			<p>Model:
				<input type="text" name="model" size="50" value="<?php echo $row['model'] ?>"/>
			</p>
			<p>Year:
				<input type="text" name="year" value="<?php echo $row['year'] ?>"/>
			</p>
			<p>Mileage:
				<input type="text" name="mileage" value="<?php echo $row['mileage'] ?>"/>
			</p>
			<input type="hidden" name="autos_id" value="0">
			<input type="submit" value="Save"/>
			<input type="submit" name="cancel" value="Cancel">
		</form>
	</div>
</body>
</html>