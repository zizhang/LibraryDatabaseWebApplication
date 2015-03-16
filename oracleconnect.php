
<html>
<?php
//param1=ora_(cs username), param2=a(studentnumber), param3=ug
if ($c=OCILogon("ora_b7d6", "a29178050", "ug")) {
  echo "Successfully connected to Oracle.\n";
  OCILogoff($c);
} else {
  $err = OCIError();
  echo "Oracle Connect Error " . $err['message'];
}

?>
</html>