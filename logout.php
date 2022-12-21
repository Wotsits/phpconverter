<?php
  session_start();

    //check if the user is already logged in and if so, redirect to converter...
    if($_SESSION["isLoggedIn"] === true) {
        session_destroy();
        header('Location: ./index.php');
    }
    else {
        header('Location: ./index.php');
    }

?>