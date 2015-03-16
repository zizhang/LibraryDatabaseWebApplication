<?php
if(isset($_POST['mail_chk'])){
$_Chk_box_value = $_POST['mail_chk'];
$to = implode(',',$_Chk_box_value);
echo 'Pass this to mail() funtion Recipients : '.$to;
}
?>