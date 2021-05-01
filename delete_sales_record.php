<?php
    session_start();


    $dbConnect = @mysqli_connect("127.0.0.1", "root", "toor")

        or die ("The database server is currently unavailable.");

    @mysqli_select_db($dbConnect, "pharmacy_database")
        or die ("The database is not available.");



        
    if (isset($_POST["sale_id"])) {
        
        $removedSaleID = $_POST["sale_id"];                                     // retrieve ID of the removed stock



        $removeStockSQL = "DELETE 
                            FROM sales 
                            WHERE sale_id = '$removedSaleID'";                 // Delete the row containing the stock ID
        
        mysqli_query($dbConnect, $removeStockSQL);
        header("location:sales_records.php");                                 // Redirect to stock_inventory
    }

    mysqli_close($dbConnect);                                                   // Close database connection
?>
