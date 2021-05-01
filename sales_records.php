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
    <title>Peoples Health Pharmacy - Sales Records</title>
</head>
<body>
    <div class="headerDiv">
        
        <?php 
            $dbConnect = @mysqli_connect("127.0.0.1", "root", "toor")

            or die ("The database server is currently unavailable.");
        
            @mysqli_select_db($dbConnect, "pharmacy_database")
                or die ("The database is not available.");

            $loginName = $_SESSION["loginName"];


            $getUserInfoSQL = "SELECT *
                                FROM employees
                                WHERE employee_name = '$loginName'";

            
            $queryResult = mysqli_query($dbConnect, $getUserInfoSQL);
            $resultArray = mysqli_fetch_assoc($queryResult);

            $_SESSION["loggedInUserID"] = $resultArray["employee_id"];
            $loggedInUserName = $resultArray["employee_name"];
            
            mysqli_free_result($queryResult);

            echo "<h1>Logged in user: {$loggedInUserName}</h1>";
        ?>
    </div>
    <div class="formContainer">



        <?php
            $loggedInUserID = $_SESSION["loggedInUserID"];


            $stockSearchSQL = "SELECT * 
                                FROM sales
                                ORDER BY sale_date DESC
                                ";

            $queryResult = mysqli_query($dbConnect, $stockSearchSQL);

            $queryResultRow = mysqli_fetch_row($queryResult);

            
            echo "<table class='formTable'>";
            $numberofSalesRecords = 0;
            echo"
                <tr>
                    <td>
                        <h2>Name</h2>
                    </td>
                    <td>
                        <h2>Price</h2>
                    </td>
                    <td>
                        <h2>Quantity</h2>
                    </td>
                    <td>
                        <h2>Sale Date</h2>
                    </td>
                    <td>
                        <h2>Sale ID</h2>
                    </td>
                </tr>";

            while ($queryResultRow) {
                

                echo "  <tr>
                            <td>
                                <form method='POST' action='delete_sales_record.php'>
                                    {$queryResultRow[1]}
                                    <input type='hidden' name='item_name' value='{$queryResultRow[1]}'>
                                </form>
                            </td>
                            <td>
                                <form method='POST' action='delete_sales_record.php'>
                                    {$queryResultRow[2]}
                                    <input type='hidden' name='item_quantity' value='{$queryResultRow[2]}'>
                                </form>
                            </td>
                            <td>
                                <form method='POST' action='delete_sales_record.php'>
                                    {$queryResultRow[3]}
                                    <input type='hidden' name='date_changed' value='{$queryResultRow[3]}'>
                                </form>
                            </td>
                            <td>
                                <form method='POST' action='delete_sales_record.php'>
                                    {$queryResultRow[4]}
                                    <input type='hidden' name='item_id' value='{$queryResultRow[0]}'>
                                </form>
                            </td>
                            <td>
                                <form method='POST' action='delete_sales_record.php'>
                                    <input class='unfriendButton' type='submit' value='Delete Record'>
                                    {$queryResultRow[0]}
                                    <input type='hidden' name='sale_id' value='{$queryResultRow[0]}'>
                                </form>
                            </td>
                            
                        </tr>
                    ";
                
                $numberofSalesRecords++;
                $queryResultRow = mysqli_fetch_row($queryResult);
                
            }
            
            echo "</table>";
            echo "Total number of sales records is {$numberofSalesRecords}";

        
            mysqli_free_result($queryResult);

            mysqli_close($dbConnect);

        ?>



        <div class="buttonDiv"> <button onClick="location.href='add_sales_record.php'" class="navButton">Add Sales Record</button>
                                <button onClick="location.href='stock_inventory.php'" class="navButton">Stock Inventory</button>
                                <button onClick="location.href='logout.php'" class="navButton">Log Out</button></div>
    </div> 
</body>
</html>