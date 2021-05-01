<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Web Application Development :: Assignment 2" />
    <meta name="keywords" content="Web,programming" />

    <link rel="stylesheet" href="style.css">

<title>Peoples Health Pharmacy - Inventory Manager</title>
</head>

<body>
    <div class="headerDiv">
        <h1>Add Stock</h1>
    </div>
    <div class="formContainer">
        <form action="add_stock_record.php" method="POST" >
                <table class="formTable">
                    <tr>
                        <td>Item ID: </td>
                        <td><input type="text" name="item_id"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Item Name: </td>
                        <td><input type="text" name="item_name"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Item Quantity: </td>
                        <td><input type="text" name="item_quantity"></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td><input type="submit" value="Add Stock" class="formSendButton"></td>
                        <td><input type="reset" value="Clear" class="formResetButton"> </td>
                    </tr>
                </table>  
            </form>
        <div class="buttonDiv">
            <button onClick="location.href='index.php'" class="navButton">Home page</button>
            <button onClick="location.href='stock_inventory.php'" class="navButton">Stock Inventory</button>
            <button onClick="location.href='logout.php'" class="navButton">Log Out</button>
        </div>
    </div>


    <?php 
        $dbConnect = @mysqli_connect("127.0.0.1", "root", "toor")

        or die ("The database server is currently unavailable.");

        @mysqli_select_db($dbConnect, "pharmacy_database")
            or die ("The database is not available.");




        if (   isset($_POST["item_id"])         && !empty($_POST["item_id"])                                // Check that all fields have been entered before processing
            && isset($_POST["item_name"])       && !empty($_POST["item_name"])
            && isset($_POST["item_quantity"])   && !empty($_POST["item_quantity"]) ) {

            $validatedStockName = FALSE;
            $validatedPassword = FALSE;



            $new_stock_ID = $_POST["item_id"];                                                               // store the entered stock id in a variable
            $new_stock_name = $_POST["item_name"];                                                           // store the entered stock name in a variable
            $new_stock_Qty = $_POST["item_quantity"];  

            $itemNameAllowedFormat = "/^[a-zA-Z]/";                                                         // Set the allowed stock name format 

            if ( !preg_match($itemNameAllowedFormat, $new_stock_name) ) {                           // Validate the profile name to be correct format
                echo "<p class='notifyAlert'>*Please enter stock name in the correct format.</p>";
            } else { $validatedStockName = TRUE; }                                                               // Set the validated name variable to true



            $duplicateItemCheckSQL = "SELECT item_id 
                                       FROM stock
                                       WHERE item_id = '$new_stock_ID'";                                      // SQL to check for duplicate emails

            $queryResult = mysqli_query($dbConnect, $duplicateItemCheckSQL);                                // Execute the query
            $resultArray = mysqli_fetch_array($queryResult, MYSQLI_NUM);

            
            
            if ($resultArray[0] == $new_stock_ID){                                                                       // Check for duplicate stock ID
                echo "<p class='notifyAlert'>*An item with the stock ID " . $new_stock_ID . " already exists.</p>";
            } else { $validatedStockID = TRUE; }                                                                          // Set the validated stock ID variable to true



           

            if (    $validatedStockName == TRUE 
                &&  $validatedStockID == TRUE ) {                                                              // If all validations were successful, make the new stock record
                
                $newStockAddSQL = "INSERT INTO stock (  item_id 
                                                                ,item_name
                                                                ,item_quantity
                                                                ,date_changed )
                    VALUES ('$new_stock_ID', '$new_stock_name', '$new_stock_Qty', CURRENT_TIMESTAMP())";
                
                if (mysqli_query($dbConnect, $newStockAddSQL)){                                          // If the creation was successful, forward to stock inventory page and set session variables

                    $_SESSION["loginStatus"] = TRUE;
                    
                    header("location:stock_inventory.php");   
                }
            }
        } else { echo "<p class='notifyAlert'>*All fields are required.</p>";}                                  // Indicate all fields must be filled out

        mysqli_close($dbConnect);                                                                               // Close database connection
    ?>
</body>
</html>