<?php
require 'connectBD.php';

if(isset($_POST['editStatus'])) { 
	$editStatus = preg_replace("#.+\((.+)\)#", "$1", $_POST['editStatus']);
	$userLogin = preg_replace("#(.+)\(.+\)#", "$1", $_POST['editStatus']);
	if($editStatus == "10") {
		$editStatus2 = 1;
	}
	elseif($editStatus == "1") {
		$editStatus2 = 10;
	}

	$edit = "UPDATE users SET status='$editStatus2' WHERE login='$userLogin'";
	mysqli_query(hostopen(), $edit);
}
?>