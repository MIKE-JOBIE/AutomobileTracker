<?php 
session_start();

require_once "bootstrap.php"; 
require_once "pdo.php";

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

$failure = false;  // If we have no POST data

if ( isset($_SESSION['failure']) ) {
    $failure = $_SESSION['failure'];
    unset($_SESSION['failure']);
}


// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
        unset($_SESSION['name']);
        $_SESSION['name'] = $_POST['email'];
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['failure'] = "Email and password are required";
        header("Location: login.php");
        return;
    } else {
        $email = htmlentities($_POST['email']);
        $pass = htmlentities($_POST['pass']);

        if(strpos($_POST['email'], '@') !== false) {        
            $check = hash('md5', $salt.$pass);
            if ( $check == $stored_hash ) {

            // Redirect the browser to view.php

                $_SESSION['name'] = $email;
                header("Location: index.php");
                error_log("Login success ".$email);
                return;
            } else {
                $_SESSION['failure'] = "Incorrect password";
                error_log("Login fail ".$email." $check");
                header("Location: login.php");
                return;
            }             
        }
        else
        {
            $_SESSION['failure'] = "Email must have an at-sign @";
            header("Location: login.php");
            return;
        }

    }
}

// Fall through into the View
?>


<!DOCTYPE html>
<html>
<head>
<title>Michael Jobie Musa</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>Please log in</h1>
<?php

        //  DISPLAY ERROR OR SUCCESS MESSAGE

if ( $failure !== false ) {
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}

// if ( isset($_SESSION['message']) ) {
//         echo('<p style="color: green;">'.htmlentities($message)."</p>\n"); 
//             unset($_SESSION['message']);
// }
   
?>
<form method="POST">
<label for="email">Email</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the three character name of this programming language (all lower case) followed by 123. -->
</p>
</div>
</body>
</html>











