<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Clerk Transactions</title>

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
<form action="clerk.php" method="post" class="bootstrap-frm">
	<h1>
    	<span>Add a borrower:</span>
   	</h1>
   	
	<label>
		<span>Borrower ID:</span>
		<input type="text" name="bid">
	</label>
	
	<label>
		<span>Password:</span>
		<input type="text" name="password">
	</label>
	
	<label>
		<span>Name: </span>
		<input type="text" name="name">
	</label>
	
		<label>
		<span>Address:</span>
		<input type="text" name="address">
	</label>
	
	<label>
		<span>Phone Number:</span>
		<input type="text" name="phone">
	</label>
	
	<label>
		<span>Email: </span>
		<input type="text" name="emailAddress">
	</label>
	
			<label>
		<span>SIN or St. Number:</span>
		<input type="text" name="sinOrStNo">
	</label>
	
	<label>
		<span>Expiry Date:</span>
		<input type="text" name="expiryDate">
	</label>
	
	<label>
		<span>Type:</span>
		<input type="text" name="type">
	</label>
	
	<label>
		<span>&nbsp;</span>
		<input type="submit" value="Add Borrower" name="addBorrower">
	</label>
	
</form>

<form action="clerk.php" method="post" class="bootstrap-frm">
	<h1>
    	<span>Check out books:</span>
   	</h1>
   	
	<label>
		<span>Borrower ID:</span>
		<input type="text" name="bid">
	</label>
	
	<label>
		<span>Call Numbers:</span>
		<input type="text" name="callNumbers">
	</label>
	
	<label>
		<span>Copy Number:</span>
		<input type="text" name="copyNumber">
	</label>
	
	<label>
		<span>&nbsp;</span>
		<input type="submit" value="Check out books" name="checkout">
	</label>
</form>

<form action="clerk.php" method="post" class="bootstrap-frm">
	<h1>
    	<span>Return Book:</span>
   	</h1>
   	
	<label>
		<span>Call Number:</span>
		<input type="text" name="callNumber">
	</label>
	
	<label>
		<span>&nbsp;</span>
		<input type="submit" value="Return Book" name="returnBook">
	</label>
</form>

<form action="clerk.php" method="post" class="bootstrap-frm">
	<h1>
    	<span>Check Overdue Items:</span>
   	</h1>
	
	<label>
		<span>&nbsp;</span>
		<input type="submit" value="Check Items" name="overdueItems">
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

function printOverdueItems($result) {
	echo "Items Overdue:";
	echo "<form action='sendEmail.php' method='post' target='_blank'>";
	echo "<table id='box-table-a'>";
	echo "<tr> <th>Call Number</th> <th>CopyNo</th> <th>Due Date</th> <th>BID</th> <th>Name</th><th>Address</th><th>Phone</th><th>Email</th>";
	echo "<th><input type='submit' value='Send Reminder Email' /></th>";
	echo "</tr>";
	
	while($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS))
	   {
	   echo "<tr>";
	   echo "<td>" . $row['CALLNUMBER'] . "</td>";
	   echo "<td>" . $row['COPYNO'] . "</td>";
	   echo "<td>" . $row['DUEDATE'] . "</td>";
	   echo "<td>" . $row['BID'] . "</td>";
	   echo "<td>" . $row['NAME'] . "</td>";
	   echo "<td>" . $row['ADDRESS'] . "</td>";
	   echo "<td>" . $row['PHONE'] . "</td>";
	   echo "<td>" . $row['EMAILADDRESS'] . "</td>";
	   echo "<td><input type='checkbox' name='mail_chk[]' value='" . $row['EMAILADDRESS'] ."'/></td>";
	   echo "</tr>";
	   }
	 echo "</table>";	
	 echo "</form>";
}

function printBorrower($result) {
	echo "New Borrower Added:";
	    echo "<table id='box-table-a'>";
 echo "<tr> <th>Borrower ID</th> <th>Password</th> <th>Name</th> <th>Address</th> <th>Phone Number</th> <th>Email</th> <th>SIN or St. Number</th> <th>Expiray Date</th> <th>Type</th> </tr>";
 
while($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS))
   {
   echo "<tr>";
   echo "<td>" . $row['BID'] . "</td>";
   echo "<td>" . $row['PASSWORD'] . "</td>";
   echo "<td>" . $row['NAME'] . "</td>";
   echo "<td>" . $row['ADDRESS'] . "</td>";
   echo "<td>" . $row['PHONE'] . "</td>";
   echo "<td>" . $row['EMAILADDRESS'] . "</td>";
   echo "<td>" . $row['SINORSTNO'] . "</td>";
   echo "<td>" . $row['EXPIRYDATE'] . "</td>";
   echo "<td>" . $row['TYPE'] . "</td>";
   echo "</tr>";
   }
 echo "</table>";	
}

function printItems($result) {
	echo "Items Checked Out:";
	    echo "<table id='box-table-a'>";
 echo "<tr> <th>Title</th> <th>Author</th> <th>Call Number</th> <th>Due Date</th> </tr>";
 
while($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS))
   {
   echo "<tr>";
   echo "<td>" . $row['TITLE'] . "</td>";
   echo "<td>" . $row['MAINAUTHOR'] . "</td>";
   echo "<td>" . $row['CALLNUMBER'] . "</td>";
   echo "<td>" . $row['DUEDATE'] . "</td>";
   echo "</tr>";
   }
 echo "</table>";	
}

function printReturn($result) {
	echo "Item Returned:";
	echo "<table id='box-table-a'>";
	echo "<tr> <th>Title</th> <th>Call Number</th> <th>Return Date</th>";
	echo "</tr>";
 
	while($row = OCI_Fetch_Array($result, OCI_RETURN_NULLS))
	   {
	   echo "<tr>";
	   echo "<td>" . $row['TITLE'] . "</td>";
	   echo "<td>" . $row['CALLNUMBER'] . "</td>";
	   echo "<td>" . $row['INDATE'] . "</td>";
	   echo "</tr>";
	   }
	 echo "</table>";	
}

function holdExists($result) {
	$row = OCI_Fetch_Array($result, OCI_RETURN_NULLS);	
	if(!$row) {
		return True;
	}	
	return False;
}

if($db_conn) {
	
	if(array_key_exists('addBorrower', $_POST)) {
		 $bid= $_POST["bid"];
         $password= $_POST["password"];
         $name= $_POST["name"];
         $address= $_POST["address"];
         $phone= $_POST["phone"];
         $email= $_POST["emailAddress"];
         $sinOrStNo= $_POST["sinOrStNo"];
         $expiryDate= $_POST["expiryDate"];
         $type= $_POST["type"];
         
         $insert = "INSERT INTO Borrower VALUES ('" . $bid . "', '" . $password . "', '" . $name . "','" . $address . "','" . $phone . "','" . $email . "', '" . $sinOrStNo . "', '" . $expiryDate . "','" . $type . "')";
         executePlainSQL($insert);
         $query = "SELECT * FROM Borrower WHERE bid='" . $bid . "'";
         $result = executePlainSQL($query);
         
         OCICommit($db_conn);
		 printBorrower($result);  
	} else if(array_key_exists('checkout', $_POST)) {
		$bid = $_POST["bid"];
		$copyNumber = $_POST["copyNumber"];
		$callNumbersString = $_POST["callNumbers"];
		$tempType = executePlainSQL("SELECT type FROM Borrower WHERE bid='" . $bid . "'");
        $row = OCI_Fetch_Array($tempType, OCI_RETURN_NULLS);
        $type = $row["TYPE"];
        $tempLimit = executePlainSQL("SELECT bookTimeLimit FROM BorrowerType WHERE type='" . $type . "'");
        $row = OCI_Fetch_Array($tempLimit, OCI_RETURN_NULLS);
        $weeks = $row["BOOKTIMELIMIT"];
        $days = $weeks * 7;
        $timestamp = mktime(0,0,0,date("m"),date("d")+days,date("Y"));
        $dueDate = date("Y-m-d", $timestamp);
        $currentDate = date("Y-m-d");

		$callNumbers = explode(", ", $callNumbersString);
		$length = count($callNumbers);
		for ($i=0; $i < $length; $i++) {
			$borid = rand(1,1000);
			$tempStatus = executePlainSQL("SELECT status, outDate FROM BookCopy, Borrowing WHERE BookCopy.callNumber=Borrowing.callNumber AND BookCopy.copyNo=Borrowing.copyNo AND BookCopy.callNumber='" . $callNumbers[$i] . "'");
            $row = OCI_Fetch_Array($tempStatus, OCI_RETURN_NULLS);
            $outDate = $row["OUTDATE"];
            $status = $row["STATUS"];
            if ($status != "out" && $currentDate != $outDate) {
  				$insert = "INSERT INTO Borrowing VALUES ('" . $borid . "', '" . $bid . "', '" . $callNumbers[$i] . "', " . $copyNumber . ", '" . $currentDate . "', null, '" . $dueDate . "')";
 				executePlainSQL($insert);
				$update = "UPDATE BookCopy SET status='out' WHERE callNumber='" . $callNumber[$i] . "'";
				executePlainSQL($update);
		    }
		}
		OCICOMMIT($db_conn);
		$query = "SELECT * FROM Borrowing JOIN Book ON Borrowing.callNumber=Book.callNumber WHERE bid='" . $bid . "' AND outDate='" . $currentDate ."'";
		$result = executePlainSQL($query);
		printItems($result);
		OCICOMMIT($db_conn);
 	}
 	
	if(array_key_exists('overdueItems', $_POST)) {
		date_default_timezone_set('America/Vancouver');
		$currentDate = date('Y-m-d');
        $query = "SELECT Borrowing.callNumber, copyNo, dueDate, Borrowing.bid, name, address, phone, emailAddress FROM Borrowing JOIN Borrower ON Borrowing.bid = Borrower.bid WHERE inDate IS null AND dueDate < '" . $currentDate . "'";
        $result = executePlainSQL($query);
		echo "Current Date: " . $currentDate . "<br>";
		printOverdueItems($result);
		
	}
	
	if(array_key_exists('returnBook', $_POST)) {
		date_default_timezone_set('America/Vancouver');
		$fid = rand(1,1000);
		$callNumber = $_POST["callNumber"];
		$tempBorrow = executePlainSQL("SELECT Borrower.bid,dueDate,emailAddress FROM Borrowing,Borrower WHERE Borrowing.bid=Borrower.bid AND callNumber='" . $callNumber . "'");
        $row = OCI_Fetch_Array($tempBorrow, OCI_RETURN_NULLS);
        $bid = $row["BID"];
        $dueDate = $row["DUEDATE"];
        $email = $row["EMAILADDRESS"];
        
        $checkHold = executePlainSQL("SELECT bid FROM Borrowing WHERE callNumber='" . $callNumber . "'");
        $holdExists = holdExists($checkHold);

        $date = date('Y-m-d');
        if(date_diff($date,$dueDate) < 0) {
	        executePlainSQL("INSERT INTO Fine VALUES ('" . $fid . "',2.0,'" . $date . "',null,'" . $bid . "')");
	        OCICOMMIT($db_conn);
	        	        ?>
			<script type="text/javascript"> 
       			 alert("Fine added to account"); 
 		    </script> 
 		    <?php
        }
        else if($holdExists) {
	        executePlainSQL("UPDATE BookCopy SET status='on-hold' WHERE callNumber='" . $callNumber . "'");
	        
	        ?>
			<script type="text/javascript"> 
       			 alert("Send email to: <?php echo $email; ?> to notify them the book on hold is in."); 
 		    </script> 
 		    <?php
        }
		else{
			executePlainSQL("UPDATE BookCopy SET status='in' WHERE callNumber='" . $callNumber . "'");
			OCICOMMIT($db_conn);
		}
		executePlainSQL("UPDATE Borrowing SET inDate='" . $date . "' WHERE callNumber='" . $callNumber . "'");
		$query = "SELECT DISTINCT title, Book.callNumber, inDate FROM Borrowing JOIN Borrower ON Borrowing.callNumber=Borrowing.callNumber JOIN Book ON Book.callNumber=Borrowing.callNumber WHERE Borrowing.callNumber='" . $callNumber . "'";
		$result = executePlainSQL($query);
		printReturn($result);
		OCICOMMIT($db_conn);
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
