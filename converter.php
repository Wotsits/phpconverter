<?php
    
    session_start();

    //check if the user is already logged in.  If not, redirect to login...
    if($_SESSION["isLoggedIn"] === false) {
        header('Location: ./index.php');
    }

    //check that the user has come to this page via the menu.  If not, redirect to the menu.
    if(!isset($_GET["converterSelected"])) {
        header('Location: ./menu.php');
    }

    //get the value of the requested converter from the url.
    $converterSelected = $_GET["converterSelected"];

    //REMOVE ME
    function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
        ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }
?>  

<html lang="en">
    <head>
        <?php
            if ($converterSelected == "temperature") echo "<title>Temperature</title>";
            if ($converterSelected == "distance") echo "<title>Distances</title>";
            if ($converterSelected == "weight") echo "<title>Weights & Measures</title>";
        ?>
        <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href='./style.css'/>
        <script src="https://kit.fontawesome.com/ae67d7c6f3.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="wrapper">

            <!-- nav bar -->
            <nav class="header">
                <div>
                    <a href="menu.php">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>
                <div>
                    <a href="logout.php">
                        <i tabindex=0 class="fa-solid fa-right-from-bracket fa-1xl"></i>
                    </a>
                </div>
            </nav>
    
            <section class="container shadow">
                <!-- Heading -->
                <?php
                    if ($converterSelected == "temperature") echo "<h1>Temperature</h1>";
                    else if ($converterSelected == "distance") echo "<h1>Distances</h1>";
                    else if ($converterSelected == "weight") echo "<h1>Weights & Measures</h1>";
                ?>
                <p class="instructions">Enter a value and select your conversion.</p>
                
                <!-- Form for input --> 
                <form action="converter.php" method="GET">
                    
                    <!-- this is a hidden field which forwards the converterSelected option as part of the conversion payload -->
                    <?php
                        echo '<input type="hidden" name="converterSelected" value="', $converterSelected, '" />';
                    ?>
                    
                    <!-- Value field -->
                    <div class="field"> 
                        <label for="value"> Value </label>
                        <input type="number" name="value" id="value" autofocus/>
                    </div>

                    <!-- Conversion select field --> 
                    <div class="field">
                        <label for="conversion">Conversion</label>
                        <select name="conversion" id="conversion">
                            <?php
                                if ($converterSelected == "temperature") echo '
                                    <option value="0" selected>Celsius to Farenheit</option>    
                                    <option value="1">Farenheit to Celsius</option>    
                                    <option value="2">Celsius to Kelvin</option>    
                                    <option value="3">Kelvin to Celsius</option>    
                                    <option value="4">Farenheit to Kelvin</option>    
                                    <option value="5">Kelvin to Farenheit</option> 
                                ';
                                else if ($converterSelected == "distance") echo '
                                    <option value="0" selected>Meters to Feet</option>    
                                    <option value="1">Inches to Centimeters</option>    
                                    <option value="2">Millimeters to Inches</option>    
                                    <option value="3">Inches to Feet</option>    
                                    <option value="4">Feet to Meters</option>    
                                    <option value="5">Centimeters to Inches</option>    
                                    <option value="6">Inches to Millimeters</option>    
                                    <option value="7">Feet to Inches</option> 
                                ';
                                else if ($converterSelected == "weight") echo '
                                    <option value="0" selected>Kilograms to Pounds</option>    
                                    <option value="1">Kilograms to Stones</option>    
                                    <option value="2">Ounces to Grams</option>    
                                    <option value="3">Ounces to Pounds</option>    
                                    <option value="4">Pounds to Kilograms</option>    
                                    <option value="5">Stones to Kilograms</option>    
                                    <option value="6">Grams to Ounces</option>    
                                    <option value="7">Pounds to Ounces</option> 
                                ';
                            ?>
                        </select>
                    </div>

                    <!-- Precision select buttons --> 
                    <div class="precision-options-container">
                        <div class="field">
                            <label>Precision</label>
                            <div class="precision-options">
                                <input id="dp0" checked hidden type="radio" name="precision" value="0">
                                    <label tabindex=0 class="precision-option selected" onclick=toggleSelected(event) onkeydown=toggleSelected(event) data-selected="true" for="dp0">
                                        0dp 
                                    </label>
                                </input>
                                <input  id="dp1" hidden type="radio" name="precision" value="1">
                                    <label tabindex=0 class="precision-option" onclick=toggleSelected(event) onkeydown=toggleSelected(event) data-selected="false" for="dp1">
                                        1dp
                                    </label>
                                </input>
                                <input id="dp2" hidden type="radio" name="precision" value="2">
                                    <label tabindex=0 class="precision-option" onclick=toggleSelected(event) onkeydown=toggleSelected(event) data-selected="false" for="dp2">
                                        2dp
                                    </label>
                                </input>
                                <input id="dp3" hidden type="radio" name="precision" value="3">
                                    <label tabindex=0 class="precision-option" onclick=toggleSelected(event) onkeydown=toggleSelected(event) data-selected="false" for="dp3">
                                        3dp
                                    </label>
                                </input>
                            </div>
                        </div>
                    </div>
                
                    <!-- Result presentation --> 
                    <div class="field">
                        <span>
                            
                            <?php 

                                //----------------
                                //Helpers

                                //A helper which converts the input depending on the selected conversion and conversionOption
                                function convert($number, $conversionOption, $temperatureDistanceWeight) {
                                    if ($temperatureDistanceWeight == "temperature") {
                                        switch ($conversionOption) {
                                            case "0": //celsius to farenheit
                                                return (($number * (9/5)) + 32);
                                                break;
                                            case "1": //farenheit to celsius
                                                return (($number - 32) * (5/9));
                                                break;
                                            case "2": //celsius to kelvin
                                                return ($number + 273.15);
                                                break;
                                            case "3": //kelvin to celsius
                                                return ($number - 273.15);
                                                break;
                                            case "4": //farenheit to kelvin
                                                return (($number + 459.67) * (5/9));  
                                                break;
                                            case "5": //kelvin to farenheit
                                                return (($number * (9/5)) - 459.67);                                   
                                                break;
                                            default:
                                                return "ERROR";
                                        }
                                    }
                                    else if ($temperatureDistanceWeight == "distance") {
                                        switch ($conversionOption) {
                                            case "0"://meters to feet
                                                return ($number * 3.281);
                                                break;
                                            case "1"://inches to cms
                                                return ($number * 2.54);
                                                break;
                                            case "2"://millimeters to inches
                                                return ($number / 25.4);
                                                break;
                                            case "3"://inches to feet
                                                return ($number * 12);
                                                break;
                                            case "4"://feet to meters
                                                return ($number / 3.281);  
                                                break;
                                            case "5"://centimeters to inches
                                                return ($number / 2.54);                                   
                                                break;
                                            case "6"://inches to millimeters
                                                return ($number * 25.4);  
                                                break;
                                            case "7"://feet to inches
                                                return ($number / 12);                                   
                                                break;
                                            default:
                                                return "ERROR";
                                        }
                                    }   
                                    else if ($temperatureDistanceWeight == "weight") {
                                        switch ($conversionOption) {
                                            case "0": //kgs to pounds
                                                return ($number * 2.2);
                                                break;
                                            case "1": //kg to stone
                                                return ($number / 6.35029318);
                                                break;
                                            case "2": //ounces to grams
                                                return ($number * 28.34952);
                                                break;
                                            case "3": //ounces to pounds
                                                return ($number * 16);
                                                break;
                                            case "4": //pounds to kgs
                                                return ($number / 2.2);  
                                                break;
                                            case "5": //stones to kgs
                                                return ($number * 6.35029318);                                   
                                                break;
                                            case "6": //grams to ounces
                                                return ($number / 28.34952);                                   
                                                break;
                                            case "7": //pounds to ounces
                                                return ($number / 16);                                   
                                                break;
                                            default: 
                                                return "ERROR";
                                        }
                                    }
                                    else return "ERROR";
                                }

                                //Object to hold the from/to combinations.
                                $convertToFrom = [
                                    
                                        temperature => [
                                            [
                                                from => "celsius",
                                                to => "farenheit"
                                            ],
                                            [
                                                from => "farenheit",
                                                to => "celsius"
                                            ],
                                            [
                                                from => "celsius",
                                                to => "kelvin"
                                            ],
                                            [
                                                from => "kelvin",
                                                to => "celsius"
                                            ],
                                            [
                                                from => "farenheit",
                                                to => "kelvin"
                                            ],
                                            [
                                                from => "kelvin",
                                                to => "farenheit"
                                            ]
                                        ],
                                    
                                    
                                        distance => [
                                            [
                                                from => "metres",
                                                to => "feet"
                                            ],
                                            [
                                                from => "inches",
                                                to => "centimeters"
                                            ],
                                            [
                                                from => "millimeters",
                                                to => "inches"
                                            ],
                                            [
                                                from => "inches",
                                                to => "feet"
                                            ],
                                            [
                                                from => "feet",
                                                to => "meters"
                                            ],
                                            [
                                                from => "centimeters",
                                                to => "inches"
                                            ],
                                            [
                                                from => "inches",
                                                to => "millimeters"
                                            ],
                                            [
                                                from => "feet",
                                                to => "inches"
                                            ],
                                        ],
                                    
                                    
                                        weight => [
                                            [
                                                from => "kilograms",
                                                to => "pounds"
                                            ],
                                            [
                                                from => "kilograms",
                                                to => "stones"
                                            ],
                                            [
                                                from => "ounces",
                                                to => "grams"
                                            ],
                                            [
                                                from => "ounces",
                                                to => "pounds"
                                            ],
                                            [
                                                from => "pounds",
                                                to => "kilograms"
                                            ],
                                            [
                                                from => "stones",
                                                to => "kilograms"
                                            ],
                                            [
                                                from => "grams",
                                                to => "ounces"
                                            ],
                                            [
                                                from => "pounds",
                                                to => "ounces"
                                            ],
                                        ]
                                    
                                    
                                ];

                                //----------------
                                
                                //if the value, conversion option and precision options are set by the form. 
                                if (isset($_GET["value"]) && isset($_GET["conversion"]) && isset($_GET["precision"])) {
                                    
                                    //if the value passed is not numeric, error...
                                    if (!is_numeric($_GET["value"])) 
                                    {
                                        echo "<div class='error-message'><h1>Processing Error</h1><p>You didn't enter a number.  Please try again.</p></div>";
                                    }

                                    //otherwise...
                                    else 
                                    {
        
                                        //get the value for convenience/readability.
                                        $valueAsString = $_GET["value"];
                                        //convert it from string to number.
                                        $valueAsNumber = number_format($valueAsString);          
                                        //get the conversion option for convenience/readability
                                        $conversionOption = $_GET["conversion"];
                                        //get the precision option for convenience/readability
                                        $precision = $_GET["precision"];

                                        //get the converted value using the helper
                                        $convertedValue = convert($valueAsNumber, $conversionOption, $converterSelected);
                                        //round to the desired precision.
                                        $convertedNumberToDp = number_format($convertedValue, $precision);

                                        //catch error and return message. 
                                        if ($convertedValue == "ERROR")
                                        {
                                            echo "<div class='error-message'><h1>Processing Error</h1><p>There's been an error - please try again.</p></div>" ;
                                        }
                                        //otherwise, return the result. 
                                        else 
                                        {
                                            if ($converterSelected == "temperature") {
                                                echo "<p class='result'>" . $valueAsString . " degrees " . $convertToFrom[$converterSelected][$conversionOption]["from"] . " is " . $convertedNumberToDp . " degrees " . $convertToFrom[$converterSelected][$conversionOption]["to"] . "</p>" ;
                                            }
                                            else {
                                                echo "<p class='result'>" . $valueAsString . " " . $convertToFrom[$converterSelected][$conversionOption]["from"] . " is " . $convertedNumberToDp . " " . $convertToFrom[$converterSelected][$conversionOption]["to"] . "</p>" ;
                                            }
                                        } 
        
                                    }

                                }
                                
                            ?>

                        </span>
                    </div>
                    <div class="button-container">
                        <input class="submit-button" type="submit" name="convert"/>
                    </div>
                </form>
            </section>
        
        <!-- bring in helper JS for precision toggle -->
        <script src="helpers.js"></script>
        
        </div>
    
    </body>

</html>