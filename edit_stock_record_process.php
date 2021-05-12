<?php
    session_start();


    $dbConnect = @mysqli_connect("127.0.0.1", "root", "toor")

        or die ("The database server is currently unavailable.");

    @mysqli_select_db($dbConnect, "pharmacy_database")
        or die ("The database is not available.");



        
    if (isset($_POST["item_id"])) {
        
        if (isset($_POST["edit_item_id"])) {                                    // If new ID was entered

            $editStockID = $_POST["item_id"];                                       // retrieve ID of the stock to edit
            
            $editStockNewID = $_POST["edit_item_id"];                           // Retrieve new stock ID
            
            $editStockIDSQL = "UPDATE stock 
                                SET item_id = '$editStockNewID'
                                WHERE item_id = '$editStockID'";                // Update the row containing the stock ID

            mysqli_query($dbConnect, $editStockIDSQL);                          // Execute update query
            
        }

        if (isset($_POST["edit_item_name"])) {                                    // If new name was entered

            $editStockName = $_POST["item_name"]; 
            
            $editStockNewName = $_POST["edit_item_name"];                           // Retrieve new stock name
            
            $editStockNameSQL = "UPDATE stock 
                                SET item_name = '$editStockNewName'
                                WHERE item_name = '$editStockName'";                // Update the row containing the stock name

            mysqli_query($dbConnect, $editStockNameSQL);                          // Execute update query
            
        }

        if (isset($_POST["edit_item_quantity"])) {                                    // If new quantity was entered

            $editStockQuantity = $_POST["item_quantity"]; 
            
            $editStockNewQuantity = $_POST["edit_item_quantity"];                           // Retrieve new stock quantity
            
            $editStockQuantitySQL = "UPDATE stock 
                                SET item_quantity = '$editStockNewQuantity'
                                WHERE item_quantity = '$editStockQuantity'";                // Update the row containing the stock quantity

            mysqli_query($dbConnect, $editStockQuantitySQL);                          // Execute update query
            
        }

        if (isset($_POST["edit_item_date"])) {                                    // If new date was entered

            $editStockDate = $_POST["item_date"]; 
            
            $editStockNewDate = $_POST["edit_item_date"];                           // Retrieve new stock date
            
            $editStockDateSQL = "UPDATE stock 
                                SET date_changed = '$editStockNewDate'
                                WHERE date_changed = '$editStockDate'";                // Update the row containing the stock date

            mysqli_query($dbConnect, $editStockDateSQL);                          // Execute update query
            
        }



    }


    mysqli_close($dbConnect);                                               // Close database connection
                                                    
    header("location:stock_inventory.php");                                 // Redirect to stock_inventory
?>
