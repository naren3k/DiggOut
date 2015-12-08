<?php
/*
 * Created on 30-Jan-09
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 include 'DBServices.php';
 
 
 function loginUser(){
 	$userName = $_REQUEST["userid"];
 	$pwd = $_REQUEST["password"];
 	$qry = "select * from user_pass where userid = \"".$userName."\" and password = \"".$pwd."\";";
 	//echo "<br> Login QRy : ".$qry;
 	$userRows = executeQuery($qry);
 	$cnt = 0;
 	while ($row = mysql_fetch_assoc($userRows)){
		$userId = $row['userid'];
		$cnt++;
 	}
 	if($cnt == 0){
 		return "failed";
 	}
 	else{
 		$qry = "select * from user_base where userid = \"".$userName."\";";
 		//echo "<br> Login User info QRy : ".$qry;
 		$userRows = executeQuery($qry);
 		$usrName = "Naren";
 		while ($row = mysql_fetch_assoc($userRows)){
			$userBean = $row;
			
 		}
 		//session_start();
 		$_SESSION['userBean'] = $userBean;
 		return "logged";
	}
 
 }
?>
