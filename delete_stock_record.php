<?php
    session_start();


    $dbConnect = @mysqli_connect("127.0.0.1", "root", "toor")

        or die ("The database server is currently unavailable.");

    @mysqli_select_db($dbConnect, "pharmacy_database")
        or die ("The database is not available.");



        
    if (isset($_POST["item_id"])) {
        
        $removedStockID = $_POST["item_id"];                                     // retrieve ID of the removed stock



        $removeStockSQL = "DELETE 
                            FROM stock 
                            WHERE item_id = '$removedStockID'";                 // Delete the row containing the stock ID
        
        mysqli_query($dbConnect, $removeStockSQL);
        header("location:stock_inventory.php");                                 // Redirect to stock_inventory
    }

    mysqli_close($dbConnect);                                                   // Close database connection
?>
