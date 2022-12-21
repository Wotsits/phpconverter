<?php
  session_start();
?>  

<html lang="en">

    <head>
        <title>Login to Converter</title>
        <link rel="stylesheet" href='./style.css'/>
        <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    </head>

    <body>
        <div class="container shadow">
            <h1>Login to Convert Everything</h1>

            <?php

                //check if the user is already logged in and if so, redirect to converter...
                if($_SESSION["isLoggedIn"] === true) {
                    header('Location: ./menu.php');
                }

                //----------------
                //CONFIG VARIABLES

                //the login form's html
                $loginForm = "
                    <form method='POST' action='index.php'>
                        <div class='field'>
                            <label for='username'>Email Address</label>
                            <input type='email' name='username' id='username' placeholder='example@example.com' autofocus/>
                        </div>
                        <div class='field'>
                            <label for='password'>Password</label>
                            <input type='password' name='password' id='password' />
                        </div>
                        <div class='button-container'>
                            <button class='submit-button' type='submit' name='submit' >Submit</button>
                        </div>
                    </form>
                ";
                
                //the message to be displayed on unsuccessful login.
                $loginUnsuccessfulMessage = "Oh no! It looks like your login failed. Please check your username and password and try again.";

                //password credentials - simulating data from backend db
                $loginCreds = [
                    [
                        username => "teachers@gllm.ac.uk",
                        password => "SimonDeservesAnA"
                    ],
                    [
                        username => "admin@converter.com",
                        password => "adminPassword"
                    ],
                ];

                //----------------
                
                //check if a username and password have been submitted
                if (isset($_POST["username"]) && isset($_POST["password"])) {
                
                    //assign the username and password to a var
                    $submittedUsername = $_POST["username"];
                    $submittedPassword = $_POST["password"];
                    //set initial state of login success
                    $isLoggedIn = false;

                    //iterate through the loginCreds...
                    foreach ($loginCreds as $kvPair) {
                        
                        //check if the username matches...
                        if ($kvPair["username"] === $submittedUsername) {
                            //check if the password matches...
                            if ($kvPair["password"] === $submittedPassword) {
                                //if both pass, set loggedIn and break out of loop. 
                                $isLoggedIn = true;
                                break;
                            }
                        }
                    }

                    //if the user has logged in successfully.
                    if ($isLoggedIn === true) {
                        //set session data.
                        $_SESSION["isLoggedIn"] = true;
                        $_SESSION["username"] = $submittedUsername;
                        //redirect to menu.php
                        header('Location: ./menu.php');
                    }
                    //if the user logged in unsuccessfully.
                    else {
                        echo $loginForm, "<div class='error-message'><h1>Login Error</h1><p>", $loginUnsuccessfulMessage, "</p></div>";
                    }

                }
                //if no login details were submitted
                else {
                    echo $loginForm;
                }
            ?>
           
        </div>
    </body>
    
</html>