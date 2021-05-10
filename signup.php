<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Managing IT Projects - Pharmacy Project" />
    <meta name="keywords" content="Web,programming" />

    <link rel="stylesheet" href="style.css">

<title>Peoples Health Pharmacy - Inventory Manager</title>
</head>

<body>
    <div class="headerDiv">
        <h1>Peoples Health Pharmacy</h1>
        <h1>Registration Page</h1>
    </div>
    <div class="formContainer">
        <form action="signup.php" method="POST" >
                <table class="formTable">
                    <tr>
                        <td>Email: </td>
                        <td><input type="text" name="registerEmail" 
                        value="<?php if(isset($_POST["registerEmail"])){echo $_POST["registerEmail"];}?>"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Profile Name: </td>
                        <td><input type="text" name="registerProfileName" 
                        value="<?php if(isset($_POST["registerProfileName"])){echo $_POST["registerProfileName"];}?>"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type="text" name="registerPassword1"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Confirm password: </td>
                        <td><input type="text" name="registerPassword2"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Register" class="formSendButton"></td>
                        <td><input type="reset" value="Clear" class="formResetButton"> </td>
                    </tr>
                </table>  
            </form>
        <div class="buttonDiv"><button onClick="location.href='index.php'" class="navButton">Home page</button></div>
    </div>


    <?php 
        $dbConnect = @mysqli_connect("127.0.0.1", "root", "toor")

        or die ("The database server is currently unavailable.");

        @mysqli_select_db($dbConnect, "pharmacy_database")
            or die ("The database is not available.");


        if (   isset($_POST["registerEmail"])       && !empty($_POST["registerEmail"])              // Check that all fields have been entered before processing
            && isset($_POST["registerProfileName"]) && !empty($_POST["registerProfileName"])
            && isset($_POST["registerPassword1"])   && !empty($_POST["registerPassword1"])
            && isset($_POST["registerPassword2"])   && !empty($_POST["registerPassword2"]) ) {

            $validatedName = FALSE;
            $validatedEmail = FALSE;
            $validatedPassword = FALSE;



            $registerProfileName = $_POST["registerProfileName"];

            $profileNameAllowedFormat = "/^[a-zA-Z]/";                                            // Set the allowed profile name format 

            if ( !preg_match($profileNameAllowedFormat, $registerProfileName) ) {                             // Validate the profile name to be correct format
                echo "<p class='notifyAlert'>*Please enter a profile name in the correct format.</p>";
            } else { $validatedName = TRUE; }                                                                   // Set the validated name variable to true



            $registerEmail = $_POST["registerEmail"];                                                           // store the users entered email in a variable
            
            if (!filter_var($registerEmail, FILTER_VALIDATE_EMAIL)) {                                           // validate email
                echo "<p class='notifyAlert'>*Please enter a valid email address.</p>";
            }

            $duplicateEmailCheckSQL = "SELECT friend_email 
                                       FROM friends 
                                       WHERE friend_email = '$registerEmail'";                                  // SQL to check for duplicate emails

            $queryResult = mysqli_query($dbConnect, $duplicateEmailCheckSQL);                                   // Execute the query
            $resultArray = mysqli_fetch_array($queryResult, MYSQLI_NUM);

            
            
            if ($resultArray[0] == $registerEmail){                                                             // Check for duplicate email
                echo "<p class='notifyAlert'>*An account with the email " . $registerEmail . " already exists.</p>";
            } else { $validatedEmail = TRUE; }                                                                  // Set the validated email variable to true



            $registerPassword1 = $_POST["registerPassword1"];                                                   // store password from field 1
            $registerPassword2 = $_POST["registerPassword2"];                                                   // store password from field 2

            if (!ctype_alnum($registerPassword1)) {                                                             // Validate the password to be correct format
                echo "<p class='notifyAlert'>*Please enter a password consisting of only letters and numbers.</p>";
            }

            
            if ($registerPassword1 != $registerPassword2) {                                                     // Check to see if passwords match
                echo "<p class='notifyAlert'>*Passwords do not match.</p>";
            } else { $validatedPassword = TRUE; }                                                               // Set validated password variable to true

            if (    $validatedName == TRUE 
                &&  $validatedEmail == TRUE
                &&  $validatedPassword == TRUE ) {                                                              // If all validations were successful, make the new account
                
                $newAccountRegisterSQL = "INSERT INTO friends (  friend_email 
                                                                ,account_password 
                                                                ,profile_name 
                                                                ,date_created
                                                                ,number_of_friends )
                    VALUES ('$registerEmail', '$registerPassword1', '$registerProfileName', CURRENT_TIMESTAMP(), '0')";
                
                if (mysqli_query($dbConnect, $newAccountRegisterSQL)){                                          // If the creation was successful, forward to friendadd page and set session variables

                    $_SESSION["loginStatus"] = TRUE;
                    $_SESSION["loginEmail"] = $registerEmail;
                    
                    header("location:friendadd.php");   
                }
            }
        } else { echo "<p class='notifyAlert'>*All fields are required.</p>";}                                  // Indicate all fields must be filled out

        mysqli_close($dbConnect);                                                                               // Close database connection
    ?>
</body>
</html>