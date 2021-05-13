<?php
    session_start();


    $dbConnect = @mysqli_connect("127.0.0.1", "root", "toor")

        or die ("The database server is currently unavailable.");

    @mysqli_select_db($dbConnect, "pharmacy_database")
        or die ("The database is not available.");



        
    if (isset($_POST["sale_id"])) {
        


        if (isset($_POST["edit_item_name"])) {                                    // If new name was entered

            $editSaleName = $_POST["item_name"]; 
            
            $editSaleNewName = $_POST["edit_item_name"];                           // Retrieve new sale name
            
            $editSaleNameSQL = "UPDATE sales 
                                SET item_name = '$editSaleNewName'
                                WHERE sale_id = '{$_POST["sale_id"]}'";                // Update the row containing the item sale name

            mysqli_query($dbConnect, $editSaleNameSQL);                          // Execute update query
            
        }

        if (isset($_POST["edit_item_price"])) {                                    // If new price was entered

            $editSalePrice = $_POST["item_price"]; 
            
            $editSaleNewPrice = $_POST["edit_item_price"];                           // Retrieve new sale price
            
            $editSalePriceSQL = "UPDATE sales 
                                SET item_price = '$editSaleNewPrice'
                                WHERE sale_id = '{$_POST["sale_id"]}'";                // Update the row containing the item sale price

            mysqli_query($dbConnect, $editSalePriceSQL);                          // Execute update query
            
        }




        if (isset($_POST["edit_item_quantity"])) {                                    // If new quantity was entered

            $editSaleQuantity = $_POST["item_quantity"]; 
            
            $editSaleNewQuantity = $_POST["edit_item_quantity"];                           // Retrieve new Sale quantity
            
            $editSaleQuantitySQL = "UPDATE sales 
                                    SET item_quantity = '$editSaleNewQuantity'
                                    WHERE sale_id = '{$_POST["sale_id"]}'";                // Update the row containing the Sale quantity

            mysqli_query($dbConnect, $editSaleQuantitySQL);                          // Execute update query
            
        }

        if (isset($_POST["edit_sale_date"])) {                                    // If new date was entered

            $editSaleDate = $_POST["sale_date"]; 
            
            $editSaleNewDate = $_POST["edit_sale_date"];                           // Retrieve new Sale date
            
            $editSaleDateSQL = "UPDATE sales 
                                SET sale_date = '$editSaleNewDate'
                                WHERE sale_id = '{$_POST["sale_id"]}'";                // Update the row containing the sale date

            mysqli_query($dbConnect, $editSaleDateSQL);                          // Execute update query
            
        }
        
    }

    header("location:sales_records.php");                                 // Redirect to sales_record list
    mysqli_close($dbConnect);                                               // Close database connection
                                                    
    
?>
