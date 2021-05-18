<?php

	if (isset($_POST["export-true"])) {
		$dbConnect = @mysqli_connect("127.0.0.1", "root", "toor")										// Make connection to database server

		or die ("The database server is currently unavailable.");		
	
		@mysqli_select_db($dbConnect, "pharmacy_database")												// Select correct database
			or die ("The database is not available.");


		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachement; filename=sales-report.csv');							// Set filename for output

		$output = fopen("php://output", "w");															// Open connection to file with write permission
		fputcsv($output, array('sale_id', 'item_name', 'item_price', 'item_quantity', 'sale_date')); 	// Prefill file with correct headings

		$getSalesSQL = "SELECT * 												
						FROM sales 
						ORDER BY sale_date DESC";														// SQL to select all sales records, ordered by sale date

		$queryResult = mysqli_query($dbConnect, $getSalesSQL);											// Query the database for all sales data


		while($row = mysqli_fetch_assoc($queryResult)) {
			fputcsv($output, (array)$row);
		}																								// For each row in the result query, add it to the csv file

		fclose($output);																				// Close connection to file
	}
?>

