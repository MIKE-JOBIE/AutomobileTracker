<?php
	session_start();

	require_once "pdo.php";

	$stmt = $pdo->query("SELECT autos_id, make, model, year, mileage FROM autos");
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Michael Jobie Musa</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<h1>Automobiles Database</h1>
		<?php
			if ( isset($_SESSION['message']) ) {
				echo('<p style="color: green;">' . htmlentities($_SESSION['message']) . "</p>\n");
				unset($_SESSION['message']);
			}
		?>
		<?php 
			if ( isset($_SESSION['name']) ) {
				if ( sizeof($rows) > 0 ) {
					echo('<table border="1">'."\n");
					echo("<thead><th>");
					echo("Make");
					echo("</th><th>");
					echo("Model");
					echo("</th><th>");
					echo("Year");
					echo("</th><th>");
					echo("Mileage");
					echo("</th><th>");
					echo("Action");
					echo("</th>");
					echo("</thead>\n");

                    foreach ($rows as $row) {
						echo("<tr><td>");
						echo(htmlentities($row['make']));
						echo("</td><td>");
						echo(htmlentities($row['model']));
						echo("</td><td>");
						echo(htmlentities($row['year']));
						echo("</td><td>");
						echo(htmlentities($row['mileage']));
						echo("</td><td>");
						echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
						echo(" or ");
						echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
						echo("</td></tr>\n");
                    }
                    echo("</table>");
				} else {
					echo("No rows found");
				}
				echo('<p><a href="add.php">Add New Entry</a></p>');
				echo('<p><a href="logout.php">Logout</a></p>');
			} else {	
				echo("<p><a href='login.php'>Please log in</a></p>");
				echo("<p>Attempt to <a href='add.php'>add data</a> without logging in</p>");
			}
		?>
	</div>
</body>
</html>