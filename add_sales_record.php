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

<title>Peoples Health Pharmacy - Sales Manager</title>
</head>

<body>
    <div class="headerDiv">
        <h1>Add Sales Record</h1>
    </div>
    <div class="formContainer">
        <form action="add_sales_record.php" method="POST" >
                <table class="formTable">
                    <tr>
                        <td>Item Name: </td>
                        <td><input type="text" name="item_name"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Item Price: </td>
                        <td><input type="text" name="item_price"></td>
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
            <button onClick="location.href='sales_records.php'" class="navButton">Sales Records</button>
            <button onClick="location.href='logout.php'" class="navButton">Log Out</button>
        </div>
    </div>


    <?php 
        $dbConnect = @mysqli_connect("127.0.0.1", "root", "toor")

        or die ("The database server is currently unavailable.");

        @mysqli_select_db($dbConnect, "pharmacy_database")
            or die ("The database is not available.");




        if (   isset($_POST["item_name"])       && !empty($_POST["item_name"])
            && isset($_POST["item_price"])      && !empty($_POST["item_price"])                                // Check that all fields have been entered before processing 
            && isset($_POST["item_quantity"])   && !empty($_POST["item_quantity"]) ) {

    

            $new_sale_item_name = $_POST["item_name"];                                                           // store the entered stock name in a variable
            $new_sale_item_price = $_POST["item_price"]; 
            $new_sale_item_Qty = $_POST["item_quantity"];  

    



            $stockVerificationCheckSQL = "  SELECT item_quantity
                                            FROM stock
                                            WHERE item_name = '$new_sale_item_name'";                                      

            $queryResult = mysqli_query($dbConnect, $stockVerificationCheckSQL);                                        // Execute the query
            $resultArray = mysqli_fetch_array($queryResult, MYSQLI_NUM);

            
            
            if ($resultArray[0] < $new_sale_item_Qty){                                                                  // If existing stock is less than attempted sold stock
                echo "<p class='notifyAlert'>
                        *There is not enough stock for this sale. There are only " 
                            . $resultArray[0] 
                            . " " 
                            . $new_sale_item_name 
                            . " left.</p>";
            } else { $validatedStockQty = TRUE; }                                                                        // Set the validated stock Qty variable to true



           

            if ( $validatedStockQty == TRUE ) {                                                                           // If all validations were successful, make the new sales record

                
                $newSaleAddSQL = "INSERT INTO sales (        item_name
                                                            ,item_price
                                                            ,item_quantity
                                                            ,sale_date )
                    VALUES ('$new_sale_item_name', '$new_sale_item_price', '$new_sale_item_Qty', CURRENT_TIMESTAMP())";     // SQL to add sales record



                
                    $newSaleStockUpdateSQL = "  UPDATE stock 
                                                SET item_quantity = item_quantity - $new_sale_item_Qty  
                                                WHERE item_name = '$new_sale_item_name'";                                      // SQL to update product stock level
                





                                                                                   

                

                if (mysqli_query($dbConnect, $newSaleAddSQL)) {                    // Execute Add sales record query

                    
                    if (mysqli_query($dbConnect, $newSaleStockUpdateSQL)) {            // Execute update stock amount query
                        
                        $_SESSION["loginStatus"] = TRUE;                               // Set session variable
                        header("location:sales_records.php");                          // Redirect to sales_records.php 

                    } else { echo "<p>Failed to update stock level</p>"; }              // Display error if stock update fails
                    
                    
                } else { echo "<p>Failed to add sales record</p>"; }               // Display error if add sales record fails

            }




        } else { echo "<p class='notifyAlert'>*All fields are required.</p>";}                                  // Indicate all fields must be filled out

        mysqli_close($dbConnect);                                                                               // Close database connection
    ?>
</body>
</html>