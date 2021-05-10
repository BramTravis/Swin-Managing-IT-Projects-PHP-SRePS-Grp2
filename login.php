<?php
    session_start();
    $_SESSION["loginEmail"] = "";
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
        <h1>People's Health Pharmacy - Sales & Inventory Manager</h1>
        <h1>Log in Page</h1>
    </div>
    <div class="formContainer">
        <form action="login.php" method="POST" >
                <table class="formTable">
                    <tr>
                        <td>Name: </td>
                        <td><input type="text" name="loginName" 
                        value="<?php if(isset($_POST["loginName"])){echo $_POST["loginName"];}?>"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type="text" name="loginPassword"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Log in" class="formSendButton"></td>
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



        if (isset($_POST["loginName"])     && !empty($_POST["loginName"]) &&
            isset($_POST["loginPassword"])  && !empty($_POST["loginPassword"]) ) {                          // If login fields are set, attempt login

                $loginName = $_POST["loginName"];
                $loginPassword = $_POST["loginPassword"];

            $loginCredentialCheckSQL = "SELECT * 
                                        FROM employees 
                                        WHERE employee_name = '$loginName'
                                        AND employee_password = '$loginPassword'";                           // SQL for checking login credentials  
            
            $queryResult = mysqli_query($dbConnect, $loginCredentialCheckSQL);                              // Execute query
            
            $resultArray = mysqli_fetch_assoc($queryResult);



            if ($resultArray["employee_name"] == $loginName && $resultArray["employee_password"] == $loginPassword ) {   // Verify details are correct
                
                
                $_SESSION["loginStatus"] = TRUE;                                                                        // Set login session variables
                $_SESSION["loginName"] = $loginName;
                    
                header("location:stock_inventory.php");                                                                      // Redirect to friends list

            } else { echo "<p class='notifyAlert'>*The name or password you entered was incorrect.</p>";}
        } else { echo "<p class='notifyAlert'>*Please enter both your login name and password.</p>";}

        mysqli_close($dbConnect);                                                                                        // Close database
    ?>


</body>
</html>