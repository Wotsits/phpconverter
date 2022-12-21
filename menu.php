<?php
  session_start();
?>  

<html lang="en">

    <head>
        <title>Converter</title>
        <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href='./style.css'/>
        <script src="https://kit.fontawesome.com/ae67d7c6f3.js" crossorigin="anonymous"></script>
    </head>
        
    <body>

        <?php
            //check if the user is already logged in.  If not, redirect to login...
            if($_SESSION["isLoggedIn"] === false) {
                header('Location: ./index.php');
            }
        ?>

        <nav class="header">
            <div>
                <!-- Intentionally empty.  No back button here -->
            </div>
            <div>
                <a href="logout.php">
                    <i tabindex=0 class="fa-solid fa-right-from-bracket fa-1xl"></i>
                </a>
            </div>
        </nav>

        <section class="container shadow">
            <!-- Heading -->
            <h1>Convert Everything</h1>
            <p>Welcome to the everything converter.  What would you like to convert?</p>

            <!-- Option select buttons -->
            <div class="card-container"> 
                <a class="card shadow" href="converter.php?converterSelected=temperature">Temperatures</a>
                <a class="card shadow" href="converter.php?converterSelected=distance">Distances</a>
                <a class="card shadow" href="converter.php?converterSelected=weight">Weights and Mesures</a>
            </div>
        </section>

    </body>

</html>