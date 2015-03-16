
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Borrower Transactions</title>

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
<form action="borrower.php" method="post" class="bootstrap-frm">
	<h1>
    	<span>Search for Books:</span>
   	</h1>
   	
	<label>
		<span>Title:</span>
		<input type="text" name="title">
	</label>
	
	<label>
		<span>Author:</span>
		<input type="text" name="mainAuthor">
	</label>
	
	<label>
		<span>Subject: </span>
		<input type="text" name="subject">
	</label>
	
	<label>
		<span>&nbsp;</span>
		<input type="submit" value="Search Books" name="search">
	</label>
	
</form>

<form action="borrower.php" method="post" class="bootstrap-frm">
	<h1>
		<span>Check your account:</span>
	</h1>
	
	<label>
		<span>Borrower ID:</span>
		<input type="text" name="bid">
	</label>
	
	<label>
	<span>&nbsp;</span>
	<input type="submit" value="Check Account" name="checkAccount">
	</label>
	
</form>

<form action="borrower.php" method="post" class="bootstrap-frm">
	<h1>
		<span>Place a hold request</span>
	</h1>
	
	<label>
		<span>Borrower ID:</span>
		<input type="text" name="bid">
	</label>
	
	<label>
		<span>Hold Request ID:</span>
		<input type="text" name="hid">
	</label>
	
	<label>
		<span>Call Number:</span>
		<input type="text" name="callNumber">
	</label>
	
		<label>
		<span>Email:</span>
		<input type="text" name="email">
	</label>
	
	<label>
		<span>&nbsp;</span>
		<input type="submit" value="Place Hold" name="holdRequest">
	</label>
</form>


<form action="borrower.php" method="post" class="bootstrap-frm">
	<h1>
		<span>Pay a fine</span>
	</h1>
	
	<label>
		<span>Borrowing ID:</span>
		<input type="text" name="borid">
	</label>
	
	<label>
		<span>Amount:</span> 
		<input type="text" name="amount">
	</label>
	
	<label>
		<span>Fine ID:</span>
		<input type="text" name="fid"><br>
	</label>
	
	<label>
		<span>&nbsp;</span>
		<input type="submit" value="Pay Fine" name="payFine">
	</label>
</form>

 <?php

date_default_timezone_set('America/Vancouver');

if ($db_conn=OCILogon("ora_e8n8", "a14237119", "ug")) {
//  echo "Successfully connected to Oracle.\n";
} else {
  $err = OCIError();
  echo "Oracle Connect Error " . $err['message'];
}

function executePlainSQL($cmdstr) { 
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
	} else {

	}
	return $statement;
}

function printHoldRequest($result) {
	echo "Your Updated Current Hold Requests:";
	    echo "<table id='box-table-a'>";
 echo "<tr> <th>Hold ID</th> <th>Title</th> <th>Issued</th> </tr>";
 
while($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS))
   {
   echo "<tr>";
   echo "<td>" . $row['HID'] . "</td>";
   echo "<td>" . $row['TITLE'] . "</td>";
   echo "<td>" . $row['ISSUEDDATE'] . "</td>";
   echo "</tr>";
   }
 echo "</table>";	
}
 
function printBooks($result) {
	
  echo "<table id='box-table-a'>";
  echo "<tr> <th>Call Number</th> <th>ISBN</th> <th>Title</th> <th>Author</th> <th>Publisher</th> <th>Year</th> <th>Copy</th></tr>";
 
 while($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS))
   {
   echo "<tr>";
   echo "<td>" . $row['CALLNUMBER'] . "</td>";
   echo "<td>" . $row['ISBN'] . "</td>";
   echo "<td>" . $row['TITLE'] . "</td>";
   echo "<td>" . $row['MAINAUTHOR'] . "</td>";
   echo "<td>" . $row['PUBLISHER'] . "</td>";
   echo "<td>" . $row['YEAR'] . "</td>";
   echo "<td>" . $row['COPYNO'] . "</td>";
   echo "</tr>";
   }
 echo "</table>";	
}

function printFines($result) {
	echo "Your current fines:";
	    echo "<table id='box-table-a'>";
 echo "<tr> <th>Borrowing ID</th> <th>Fine ID</th> <th>Amount</th> <th>Issued</th> <th>Paid</th> </tr>";
 while($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS))
   {
   echo "<tr>";
   echo "<td>" . $row['BORID'] . "</td>";
   echo "<td>" . $row['FID'] . "</td>";
   echo "<td>" . $row['AMOUNT'] . "</td>";
   echo "<td>" . $row['ISSUEDDATE'] . "</td>";
   echo "<td>" . $row['PAIDDATE'] . "</td>";
   echo "</tr>";
   }
 echo "</table>";
}

function printAccountBorrow($result) {
	echo "Items currently borrowed:";
   echo "<table id='box-table-a'>";
  echo "<tr> <th>Title</th> <th>Borrowing ID</th> <th>In Day</th> </tr>";
 
 while($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS))
   {
   echo "<tr>";
   echo "<td>" . $row['TITLE'] . "</td>";
   echo "<td>" . $row['BORID'] . "</td>";
   echo "<td>" . $row['INDATE'] . "</td>";
   echo "</tr>";
   }
 echo "</table>";
}

function printAccountHold($result) {
 echo "Hold requests placed:";
 echo "<table id='box-table-a'>";
 echo "<tr> <th>Hold Request ID</th> <th>Title</th> <th>Issued</th> </tr>";
 while($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS))
   {
   echo "<tr>";
   echo "<td>" . $row['HID'] . "</td>";
   echo "<td>" . $row['TITLE'] . "</td>";
   echo "<td>" . $row['ISSUEDDATE'] . "</td>";
  }
 echo "</table>";
}

function printAccountFine($result) {
	 echo "Current Fines:";
 echo "<table id='box-table-a'>";
  echo "<tr> <th>Borrowing ID</th> <th>Fine ID</th> <th>Amount</th> <th>Issued</th> <th>Paid</th> </tr>";
 
 while($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS))
   {
   echo "<tr>";
   echo "<td>" . $row['BORID'] . "</td>";
   echo "<td>" . $row['FID'] . "</td>";
   echo "<td>" . $row['AMOUNT'] . "</td>";
   echo "<td>" . $row['ISSUEDDATE'] . "</td>";
   echo "<td>" . $row['PAIDDATE'] . "</td>";
   echo "</tr>";
   }
 echo "</table>";
}

if($db_conn) {
	
	if(array_key_exists('search', $_POST)) {
		 $title= $_POST["title"];
         $author= $_POST["mainAuthor"];
         $subject= $_POST["subject"];
         $query = "SELECT DISTINCT title,isbn,Book.callNumber,mainAuthor,publisher,year,copyNo FROM Book,HasSubject,BookCopy WHERE Book.callNumber=HasSubject.callNumber AND BookCopy.callNumber=Book.callNumber AND (title='" . $title . "' OR mainAuthor='" . $author . "' OR subject='" . $subject . "')";
         $result = executePlainSQL($query);
         
         OCICommit($db_conn);
		 printBooks($result);  
	}
	
	if(array_key_exists('checkAccount', $_POST)) {
		 $bid = $_POST["bid"];
   
         $query = "SELECT HoldRequest.hid, Book.title, HoldRequest.issuedDate, Borrowing.borid, Book.title, Borrowing.inDate, Fine.paidDate, Fine.fid, Fine.amount, Fine.issuedDate FROM HoldRequest INNER JOIN Book ON HoldRequest.callNumber=Book.callNumber INNER JOIN Borrowing ON Borrowing.callNumber=Book.callNumber INNER JOIN Fine ON Fine.borid=Borrowing.borid WHERE amount > 0.0 AND HoldRequest.bid='" . $bid . "' AND Book.callNumber=HoldRequest.callNumber AND Borrowing.bid='" . $bid . "'";
         $result1 = executePlainSQL($query);
         $result2 = executePlainSQL($query);
         $result3 = executePlainSQL($query);
         OCICommit($db_conn);
         printAccountBorrow($result1);
         printAccountFine($result2);
         printAccountHold($result3);
	}
	
	if(array_key_exists('payFine', $_POST)) {
		$fid = $_POST["fid"];
		$borid = $_POST["borid"];
        $paidAmount = $_POST["amount"];
        $temp = executePlainSQL("SELECT amount FROM Fine WHERE borid='" . $borid . "' AND fid='" . $fid . "'");
        $row = OCI_Fetch_Array($temp, OCI_RETURN_NULLS);
        $oldAmount = $row["AMOUNT"];
        $newAmount = $oldAmount - $_POST["amount"];
        $currentDate = date("Y-m-d");
   
        $update = "UPDATE Fine SET amount=" . $newAmount . ", paidDate='" . $currentDate . "'WHERE borid='" . $borid . "' AND fid='" . $fid . "'";
        executePlainSQL($update);
        $query = "SELECT * FROM Fine WHERE borid='" . $borid . "'";
        $result = executePlainSQL($query);
        OCICommit($db_conn);
        printFines($result);
	}
	
	if(array_key_exists('holdRequest', $_POST)) {
		$bid = $_POST["bid"];
        $hid = $_POST["hid"];
        $callNumber = $_POST["callNumber"];
   
        $insertquery = "INSERT INTO HoldRequest VALUES ('" . $hid . "', '" . $bid . "', '" . $callNumber . "', '2014-03-30')";
        executePlainSQL($insertquery);
        OCICOMMIT($db_conn);
        $query = "SELECT HoldRequest.hid, Book.title, HoldRequest.issuedDate FROM HoldRequest INNER JOIN Book ON HoldRequest.callNumber=Book.callNumber";
        $result = executePlainSQL($query);
        
        OCICommit($db_conn);
        printHoldRequest($result);
        ?>
   <script type="text/javascript"> 
        alert("The email address <?php echo $_POST["email"]; ?> is to be sent an email on return."); 
       // history.back(); 
  </script> 
  <?php
	}

	
    OCILogoff($db_conn);
    
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
 }
 ?>

</body>
</html>


