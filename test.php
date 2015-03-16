<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Test Page</title>

<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<ul>
<li><a href="/librarian.php">Librarian</a></li>
<li><a href="/clerk.php">Clerk</a></li>
<li><a href="/borrower.php">Borrower</a></li>
<li><a href="/test.php">Test</a></li>
</ul>
<br>
<br>
<form method="POST" action="test.php">   
	<input type="submit" value="Display Borrower Table" name="displayBorrower">
</form>

<form method="POST" action="test.php">   
	<input type="submit" value="Display BorrowerType Table" name="displayBorrowerType">
</form>

<form method="POST" action="test.php">   
	<input type="submit" value="Display Book Table" name="displayBook">
</form>

<form method="POST" action="test.php">   
	<input type="submit" value="Display HasAuthor Table" name="displayHasAuthor">
</form>

<form method="POST" action="test.php">   
	<input type="submit" value="Display HasSubject Table" name="displayHasSubject">
</form>

<form method="POST" action="test.php">   
	<input type="submit" value="Display BookCopy Table" name="displayBookCopy">
</form>

<form method="POST" action="test.php">   
	<input type="submit" value="Display HoldRequest Table" name="displayHoldRequest">
</form>

<form method="POST" action="test.php">   
	<input type="submit" value="Display Borrowing Table" name="displayBorrowing">
</form>

<form method="POST" action="test.php">   
	<input type="submit" value="Display Fine Table" name="displayFine">
</form>

<?php

// Accessing oracle db and executing sql queries

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_b7d6", "a29178050", "ug");

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); 

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


function displayBorrowerType($result) { //prints results from a select statement
	echo "<br>BorrowerType Table:<br>";
	echo "<table id='box-table-a'>";
	echo "<tr><th>Type</th><th>Book Time Limit (Weeks)</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
		echo "<tr><td>" . $row["TYPE"] . "</td><td>" . $row["BOOKTIMELIMIT"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function displayBorrower($result) { //prints results from a select statement
	echo "<br>Borrower Table:<br>";
	echo "<table id='box-table-a'>";
	echo "<tr><th>Bid</th><th>Password</th><th>Name</th><th>Address</th><th>Phone</th><th>Email</th><th>Sin/Student#</th><th>Expiry Date</th><th>Type</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
		echo "<tr><td>" . $row["BID"] . "</td><td>" . $row["PASSWORD"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["ADDRESS"] . "</td><td>" . $row["PHONE"] . "</td><td>" . $row["EMAILADDRESS"] . "</td><td>" . $row["SINORSTNO"] . "</td><td>" . $row["EXPIRYDATE"] . "</td><td>" . $row["TYPE"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function displayBook($result) { //prints results from a select statement
	echo "<br>Book Table:<br>";
	echo "<table id='box-table-a'>";
	echo "<tr><th>Call Number</th><th>ISBN</th><th>Title</th><th>Author</th><th>Publisher</th><th>Year</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
		echo "<tr><td>" . $row["CALLNUMBER"] . "</td><td>" . $row["ISBN"] . "</td><td>" . $row["TITLE"] . "</td><td>" . $row["MAINAUTHOR"] . "</td><td>" . $row["PUBLISHER"] . "</td><td>" . $row["YEAR"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function displayHasAuthor($result) { //prints results from a select statement
	echo "<br>HasAuthor Table:<br>";
	echo "<table id='box-table-a'>";
	echo "<tr><th>Call Number</th><th>Name</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
		echo "<tr><td>" . $row["CALLNUMBER"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function displayHasSubject($result) { //prints results from a select statement
	echo "<br>HasSubject Table:<br>";
	echo "<table id='box-table-a'>";
	echo "<tr><th>Call Number</th><th>Subject</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
		echo "<tr><td>" . $row["CALLNUMBER"] . "</td><td>" . $row["SUBJECT"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function displayBookCopy($result) { //prints results from a select statement
	echo "<br>BookCopy Table:<br>";
	echo "<table id='box-table-a'>";
	echo "<tr><th>Call Number</th><th>CopyNo</th><th>status</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
		echo "<tr><td>" . $row["CALLNUMBER"] . "</td><td>" . $row["COPYNO"] . "</td><td>" . $row["STATUS"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function displayHoldRequest($result) { //prints results from a select statement
	echo "<br>HoldRequest Table:<br>";
	echo "<table id='box-table-a'>";
	echo "<tr><th>Hid</th><th>Bid</th><th>Call Number</th><th>Issued Date</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
		echo "<tr><td>" . $row["HID"] . "</td><td>" . $row["BID"] . "</td><td>" . $row["CALLNUMBER"] . "</td><td>" . $row["ISSUEDDATE"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function displayBorrowing($result) { //prints results from a select statement
	echo "<br>Borrowing Table:<br>";
	echo "<table id='box-table-a'>";
	echo "<tr><th>Borid</th><th>Bid</th><th>Call Number</th><th>CopyNo</th><th>outDate</th><th>inDate</th><th>dueDate</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
		echo "<tr><td>" . $row["BORID"] . "</td><td>" . $row["BID"] . "</td><td>" . $row["CALLNUMBER"] . "</td><td>" . $row["COPYNO"] . "</td><td>" . $row["OUTDATE"] . "</td><td>" . $row["INDATE"] . "</td><td>" . $row["DUEDATE"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

function displayFine($result) { //prints results from a select statement
	echo "<br>Fine Table:<br>";
	echo "<table id='box-table-a'>";
	echo "<tr><th>Fid</th><th>Amount</th><th>Issued Date</th><th>Paid Date</th><th>Borid</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS)) {
		echo "<tr><td>" . $row["FID"] . "</td><td>" . $row["AMOUNT"] . "</td><td>" . $row["ISSUEDDATE"] . "</td><td>" . $row["PAIDDATE"] . "</td><td>" . $row["BORID"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";
}

// Connect Oracle...
if ($db_conn) {

	if (array_key_exists('displayBook', $_POST)) {
		// Display Book Table
		$sqlquery = "SELECT * FROM Book";
		$books = executePlainSQL($sqlquery);
		displayBook($books);
	} else if (array_key_exists('displayBookCopy', $_POST)) {
		// Display BookCopy Table
		$sqlquery = "SELECT * FROM BookCopy";
		$booksCopy = executePlainSQL($sqlquery);
		displayBookCopy($booksCopy);
	} else if (array_key_exists('displayBorrowerType', $_POST)) {
		// Display BorrowerType Table
		$sqlquery = "SELECT * FROM BorrowerType";
		$borrowerType = executePlainSQL($sqlquery);
		displayBorrowerType($borrowerType);
	} else if (array_key_exists('displayBorrower', $_POST)) {
		// Display Borrower Table
		$sqlquery = "SELECT * FROM Borrower";
		$borrower = executePlainSQL($sqlquery);
		displayBorrower($borrower);
	} else if (array_key_exists('displayHasAuthor', $_POST)) {
		// Display HasAuthor Table
		$sqlquery = "SELECT * FROM HasAuthor";
		$hasAuthor = executePlainSQL($sqlquery);
		displayHasAuthor($hasAuthor);
	} else if (array_key_exists('displayHasSubject', $_POST)) {
		// Display HasSubject Table
		$sqlquery = "SELECT * FROM HasSubject";
		$hasSubject = executePlainSQL($sqlquery);
		displayHasSubject($hasSubject);
	} else if (array_key_exists('displayHoldRequest', $_POST)) {
		// Display HoldRequest Table
		$sqlquery = "SELECT * FROM HoldRequest";
		$holdRequest = executePlainSQL($sqlquery);
		displayHoldRequest($holdRequest);
	} else if (array_key_exists('displayBorrowing', $_POST)) {
		// Display Borrowing Table
		$sqlquery = "SELECT * FROM Borrowing";
		$borrowing = executePlainSQL($sqlquery);
		displayBorrowing($borrowing);
	} else if (array_key_exists('displayFine', $_POST)) {
		// Display Fine Table
		$sqlquery = "SELECT * FROM Fine";
		$fine = executePlainSQL($sqlquery);
		displayFine($fine);
	}
	
	OCICommit($db_conn);
	
	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}
?>

</body>
</html>

