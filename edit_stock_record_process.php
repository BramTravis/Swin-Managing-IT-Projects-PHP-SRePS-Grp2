<?php
    session_start();


    $dbConnect = @mysqli_connect("127.0.0.1", "root", "toor")

        or die ("The database server is currently unavailable.");

    @mysqli_select_db($dbConnect, "pharmacy_database")
        or die ("The database is not available.");



        
    if (isset($_POST["item_id"])) {
        
        $editStockID = $_POST["item_id"];                                       // retrieve ID of the stock to edit
        
        
        if (isset($_POST["edit_item_id"])) {                                    // If new ID was entered
            
            $editStockNewID = $_POST["edit_item_id"];                           // Retrieve new stock ID
            
            $editStockIDSQL = "UPDATE stock 
                                SET item_id = '$editStockNewID'
                                WHERE item_id = '$editStockID'";                    // Update the row containing the stock ID

            mysqli_query($dbConnect, $editStockIDSQL);                                // Execute update query
            

        }
    }


    mysqli_close($dbConnect);                                               // Close database connection
                                                    
    header("location:stock_inventory.php");                                 // Redirect to stock_inventory
?>
