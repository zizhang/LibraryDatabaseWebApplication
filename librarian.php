<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Librarian</title>

<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<ul>
<li><a href="librarian.php">Librarian</a></li>
<li><a href="clerk.php">Clerk</a></li>
<li><a href="borrower.php">Borrower</a></li>
<li><a href="test.php">Test</a></li>
</ul>
<br>
<br>
<!-- Librarian Transactions -->
<form method="POST" action="librarian.php" class="bootstrap-frm">
	<h1> 
		<span>Add New Book</span>
	</h1>

	<label>
		<span>Call Number: </span>
		<input type="text" name="callNumber" size="16">
	</label>

	<label>
		<span>ISBN: </span>
		<input type="text" name="isbn" size="16">
	</label>
	
	<label>
		<span>Title: </span>
		<input type="text" name="title" size="16">
	</label>
	
	<label>
		<span>Authors: </span>
		<input type="text" name="authors" size="16">
	</label>
	
	<label>
		<span>Publisher: </span>
		<input type="text" name="publisher" size="16">
	</label>
	
	<label>
		<span>Year: </span>
		<input type="text" name="year" size="16">
	</label>
	
	<label>
		<span>Subjects: </span>
		<input type="text" name="subjects" size="16">
	</label>
	
	<label>
        <span>&nbsp;</span> 
        <input type="submit" name="addBook" value="Add Book" /> 
    </label>  
</form>

<form method="POST" action="librarian.php" class="bootstrap-frm">
	<h1> 
		<span>Add New Copy Book</span>
	</h1>

	<label>
		<span>Call Number: </span>
		<input type="text" name="callNumber" size="16">
	</label>
	
	<label>
		<span>Copy Number: </span>
		<input type="text" name="copyNo" size="3">
	</label>
	
	<label>
        <span>&nbsp;</span> 
        <input type="submit" name="addBookCopy" value="Add Book" /> 
    </label>  
</form>

<form method="POST" action="librarian.php" class="bootstrap-frm">  
	<h1> 
		<span>Report Checked Out</span>
	</h1>
	<label>
		<span>Subject: </span>
		<input type="text" name="subject" size="16">
	</label>
	<label>
        <span>&nbsp;</span> 
        <input type="submit" name="displayCheckedOutBooks" value="Show All Checked Out Books" /> 
    </label>
</form>

<form method="POST" action="librarian.php" class="bootstrap-frm">  
	<h1> 
		<span>Report Most Popular</span>
	</h1>
	<label>
		<span>Year: </span>
		<input type="text" name="year" size="16">
	</label>
	<label>
		<span>Number: </span>
		<input type="text" name="number" size="16">
	</label>
	<label>
        <span>&nbsp;</span> 
        <input type="submit" name="displayMostPopularItems" value="Show Most Popular Items" /> 
    </label>
</form>

<?php
	$success = True; //keep track of errors so it redirects the page only if there are no errors
	$db_conn = OCILogon("ora_b7d6", "a29178050", "ug");
	
	function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
		//echo "<br>running ".$cmdstr."<br>";
		global $db_conn, $success;
		$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

		if (!$statement) {
			echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($db_conn); // For OCIParse errors pass the       
			// connection handle
			echo htmlentities($e['message']);
			$success = False;
		}

		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
			echo htmlentities($e['message']);
			$success = False;
		} 
		
		return $statement;

	}
	
	function displayBook($result) { //prints results from a select statement
		echo "<h1>Book Table:</h1>";
		echo "<table id='box-table-a'>";
		echo "<tr><th>Call Number</th><th>ISBN</th><th>Title</th><th>Author</th><th>Publisher</th><th>Year</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
			echo "<tr><td>" . $row["CALLNUMBER"] . "</td><td>" . $row["ISBN"] . "</td><td>" . $row["TITLE"] . "</td><td>" . $row["MAINAUTHOR"] . "</td><td>" . $row["PUBLISHER"] . "</td><td>" . $row["YEAR"] . "</td></tr>"; //or just use "echo $row[0]" 
		}
		echo "</table>";
	}
	
	function displayBookCopy($result) { //prints results from a select statement
		echo "<h1>BookCopy Table:</h1>";
		echo "<table id='box-table-a'>";
		echo "<tr><th>Call Number</th><th>CopyNo</th><th>status</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
			echo "<tr><td>" . $row["CALLNUMBER"] . "</td><td>" . $row["COPYNO"] . "</td><td>" . $row["STATUS"] . "</td></tr>"; //or just use "echo $row[0]" 
		}
		echo "</table>";
	}
	
	function displayCheckedOut($result) { 
		echo "<h1>Checked Out Books:</h1>";
		echo "<table id='box-table-a'>";
		echo "<tr><th>Call Number</th><th>Check Out Date</th><th>Due Date</th></tr>";
		
		date_default_timezone_set('America/Vancouver');
		$currentDate = date('y-m-d');
		
		$time1 = strtotime($currentDate);

		while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
			$time2 = strtotime($row["DUEDATE"]);
			$due = $time2-$time1;
			if($due < 0 && $row["INDATE"] == null) {
				echo "<tr><td>" . $row["CALLNUMBER"] . "</td><td>" . $row["OUTDATE"] . "</td><td>" . $row["DUEDATE"] . "</td><td>*****OVERDUE*****</td></tr>";
			} else {
				echo "<tr><td>" . $row["CALLNUMBER"] . "</td><td>" . $row["OUTDATE"] . "</td><td>" . $row["DUEDATE"] . "</td></tr>";
			}
		}
		echo "</table>";
	}
	
	function displayMostPopularItems($result) { 
		echo "<h1>Most Popular Items:</h1>";
		echo "<table id='box-table-a'>";
		echo "<tr><th>Call Number</th><th>Number of Times Checked Out</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
			echo "<tr><td>" . $row["CALLNUMBER"] . "</td><td>" . $row["OCCURENCES"] . "</td></tr>";
		}
		echo "</table>";
	}
	
	function bookExists($result) {
		$row = OCI_Fetch_Array($result, OCI_RETURN_NULLS);
		
		if(!$row) {
			return False;
		}
		
		return True;
	}


	// Connect Oracle...
	if ($db_conn) {

		if (array_key_exists('addBook', $_POST)) {
				//Getting the values from user and insert data into the table
				
				/*$tuple = array (
					":bind1" => $_POST['f_destination'],
					":bind2" => $_POST['price']

				);
				$alltuples = array (
					$tuple
				);*/
				
				$callNumber = $_POST['callNumber'];
				$isbn = $_POST['isbn'];
				$title = $_POST['title'];
				$authorsString = $_POST['authors'];
				$publisher = $_POST['publisher'];
				$year = $_POST['year'];
				$subjectsString = $_POST['subjects'];
				
				$authors = explode(", ", $authorsString);
				$subjects = explode(", ", $subjectsString);
				
				
				$sqlinsert = "INSERT INTO Book VALUES ('" .$callNumber. "' , '" .$isbn. "' , '" .$title. "' , '" .$authors[0]. "','" .$publisher. "',".$year. ")";
				executePlainSQL($sqlinsert);
				
				$length = count($authors);
				for ($i = 0; $i < $length; $i++) {
					$sqlinsert = "INSERT INTO HasAuthor VALUES ('" .$callNumber. "' , '" .$authors[$i]. "')";
					executePlainSQL($sqlinsert);
				}
				
				$length = count($subjects);
				for ($i = 0; $i < $length; $i++) {
					$sqlinsert = "INSERT INTO HasSubject VALUES ('" .$callNumber. "' , '" .$subjects[$i]. "')";
					executePlainSQL($sqlinsert);
				}
				
				OCICommit($db_conn);
				
				$sqlquery = "SELECT * FROM Book"; 
				$result = executePlainSQL($sqlquery);
				displayBook($result);
		} else if (array_key_exists('addBookCopy', $_POST)) {
				
				$callNumber = $_POST['callNumber'];
				$copyNo = $_POST['copyNo'];
				
				$sqlquery = "SELECT * FROM Book WHERE callNumber='" . $callNumber . "'"; 
				$result = executePlainSQL($sqlquery);
				$exists = bookExists($result);
				
				if($exists) {
					$sqlinsert = "INSERT INTO BookCopy VALUES ('" .$callNumber. "' ," .$copyNo. ", 'in'" . ")";
					executePlainSQL($sqlinsert);
					
					OCICommit($db_conn);
					
					$sqlquery = "SELECT * FROM BookCopy"; 
					$result = executePlainSQL($sqlquery);
					displayBookCopy($result);
				} else {
					echo "Book with callNumber " . $callNumber . " does not exist.";
					$sqlquery = "SELECT * FROM Book"; 
					$result = executePlainSQL($sqlquery);
					displayBook($result);
				}
		} else if (array_key_exists('displayCheckedOutBooks', $_POST)) {
				$subject = $_POST['subject'];
				
				if(empty($subject)) {
					$sqlquery = "SELECT Borrowing.callNumber, inDate, outDate, dueDate " . 
					"FROM Borrowing JOIN BookCopy ON Borrowing.callNumber = BookCopy.callNumber WHERE status='out' ORDER BY Borrowing.callNumber DESC"; 
					$result = executePlainSQL($sqlquery);
					displayCheckedOut($result);
				} else {
					$sqlquery = "SELECT Borrowing.callNumber, inDate, outDate, dueDate " . 
						"FROM Borrowing JOIN BookCopy ON Borrowing.callNumber = BookCopy.callNumber JOIN HasSubject ON Borrowing.callNumber = HasSubject.callNumber" . 
						" WHERE status='out' AND subject='" . $subject . "' ORDER BY Borrowing.callNumber DESC"; 
					$result = executePlainSQL($sqlquery);
					displayCheckedOut($result);
				}
		} else if (array_key_exists('displayMostPopularItems', $_POST)) {
					$year = $_POST['year'];
					$number = $_POST['number'];
					
					$sqlquery = "SELECT * FROM ( SELECT callNumber, COUNT(callNumber), " . 
						"COUNT(callNumber) AS occurences FROM Borrowing WHERE(outDate >= '" . $year . 
						"-01-01' AND outDate <= '" . $year . "-12-31') GROUP BY callNumber ORDER BY " . 
						"occurences DESC) WHERE ROWNUM <= " . $number; 
					$result = executePlainSQL($sqlquery);
					displayMostPopularItems($result);
		}
		OCICommit($db_conn);
		OCILogoff($db_conn);
	} else {
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
	}
?>

</body>
</html>
