<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Managing IT Projects :: - Pharmacy Project" />
    <meta name="keywords" content="Web,programming" />

    <link rel="stylesheet" href="style.css">

<title>Peoples Health Pharmacy - Inventory Manager</title>
</head>

<body>
    <?php 


        $dbConnect = @mysqli_connect("127.0.0.1", "root", "toor")      // Database connection

        or die ("The database server is currently unavailable. Contact your IT administrator.");
    
        @mysqli_select_db($dbConnect, "pharmacy_database")
            or die ("The database is not available. Contact your IT administrator.");


        $tableExistanceCheckSQL = "SELECT * FROM stock";                                      // Quick search to see if the table already exists
        

        if (!mysqli_query($dbConnect, $tableExistanceCheckSQL)){                                // If the table search fails, make a new table
            $createTableQuery = "CREATE TABLE IF NOT EXISTS stock (
                item_id           INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                item_name         varchar(50) NOT NULL,
                item_quantity     INT NOT NULL,
                date_changed      DATE NOT NULL
                
            );";

            mysqli_query($dbConnect, $createTableQuery);

            $populateStockTableSQL = "INSERT INTO stock (  item_id 
                                                    ,item_name
                                                    ,item_quantity 
                                                    ,date_changed
                                                    )
            VALUES ('10',     'Panadol',            '300',  CURRENT_TIMESTAMP())  
                    ,('20',   'Bandaids',           '100',  CURRENT_TIMESTAMP())
                    ,('30',   'Rubbing Alcohol',    '50',   CURRENT_TIMESTAMP())
                    ,('40',   'Sutures',            '150',  CURRENT_TIMESTAMP())
                    ,('50',   'Asthma Inhaler',     '75',   CURRENT_TIMESTAMP())
                    ,('60',   'Cough Drops',        '500',  CURRENT_TIMESTAMP())
                    ,('70',   'Antibiotics',        '250',  CURRENT_TIMESTAMP());";         // populate the table with stock

            mysqli_query($dbConnect, $populateStockTableSQL)
                or die ("Error: " . mysqli_error($dbConnect));                                                  // Execute the query
        }




        $tableExistanceCheckSQL = "SELECT * FROM sales";                                                    // Check if the sales table exists
        
        if (!mysqli_query($dbConnect, $tableExistanceCheckSQL)){                                                // If the table doesnt exist make it

            $createTableQuery = "CREATE TABLE IF NOT EXISTS sales (
                sale_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                item_name varchar(50) NOT NULL,
                item_price varchar(50) NOT NULL,
                item_quantity INT NOT NULL, 
                sale_date      DATE NOT NULL
            );";

            mysqli_query($dbConnect, $createTableQuery)
                or die ("Error: " . mysqli_error($dbConnect));
                $populateSalesTableSQL = "INSERT INTO sales (  item_name
                                                                      ,item_price
                                                                      ,item_quantity
                                                                      ,sale_date
                                                                    )
                VALUES ('Panadol', '$15', '2', CURRENT_TIMESTAMP());";                                       // Populate the sales table with a sale

            mysqli_query($dbConnect, $populateSalesTableSQL)                                                // Execute the query
                or die ("Error: " . mysqli_error($dbConnect)); 
        }


        $tableExistanceCheckSQL = "SELECT * FROM employees";                                                    // Check if the Employees table exists
        
        if (!mysqli_query($dbConnect, $tableExistanceCheckSQL)){                                                // If the table doesnt exist make it

            $createTableQuery = "CREATE TABLE IF NOT EXISTS employees (
                employee_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                employee_name varchar(50) NOT NULL,
                employee_password varchar(50) NOT NULL
            );";

            mysqli_query($dbConnect, $createTableQuery)
                or die ("Error: " . mysqli_error($dbConnect));
                $populateEmployeesTableSQL = "INSERT INTO employees ( employee_name
                                                                      ,employee_password
                                                                    )
                VALUES ('Bram', 'password1');";                                                                 // Populate the Employees table with an employee

            mysqli_query($dbConnect, $populateEmployeesTableSQL)                                                // Execute the query
                or die ("Error: " . mysqli_error($dbConnect)); 
        }
            



         

        mysqli_close($dbConnect);                                                                               // Close database connection
    ?>


    <div class="headerDiv">
        <h1>People's Health Pharmacy - Sales & Inventory Manager</h1>
    </div>

    <div id="homePageDiv">
        <p>Name: Bram Travis</p>
        <p>Student ID: 102129842</p>
        <p>Email: 102129842@student.swin.edu.au</p>

        <button onClick="location.href='login.php'" class="navButton">Log in</button>
        
    </div>
</body>
</html>