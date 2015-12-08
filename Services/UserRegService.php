<?php
/*
 * Created on 28-Nov-08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
*/
include 'ImageServices.php';

	$action = $_REQUEST['action'];
	if($action == "regUser"){
		$user_id = $_REQUEST['userId'];
 		$user_name = $_REQUEST['userName'];;
 		$user_lst_name = $_REQUEST['userLstName'];;
 		$password = $_REQUEST['Password'];;
 		$user_dob = $_REQUEST['userdob']; ;//= new date("F j, Y, g:i a");
 		$user_addr1 = $_REQUEST['useraddr1'];;
 		$user_addr2 = $_REQUEST['useraddr2'];;
 		$user_city_id = $_REQUEST['city'];;
 		$user_country_id = $_REQUEST['country'];;
		//var $user_langugage_id;
		$user_email = $_REQUEST['useremail'];;
		$user_email2 = $_REQUEST['useremail1'];;
		$user_company = $_REQUEST['user'];
		
	}
	function checkUserId($userId){
		$id = trim($userId);
		$qry = "select * from user_base where userid =\"".$id."\";";
		//echo "<br> Executing query for Checking user id ".$qry;
		$userRows = executeQuery($qry);
		$cnt = 0;
		while ($row = mysql_fetch_assoc($userRows)){
			$cnt++;
		}
		echo $cnt;
		return $cnt;
		/*if(cnt > 1){ // duplicate exists
			return 0;
		}else { // no duplicate
			return 1;
		}*/
	}
	
	function addUser(){
		$user_id = $_REQUEST['userId'];
 		$user_name = $_REQUEST['userName'];;
 		$user_lst_name = $_REQUEST['userLstName'];;
 		$password = $_REQUEST['Password'];;
 		$user_dob = $_REQUEST['userdob']; ;//= new date("F j, Y, g:i a");
 		$user_addr1 = $_REQUEST['useraddr1'];;
 		$user_addr2 = $_REQUEST['useraddr2'];;
 		$user_city_id = $_REQUEST['city'];;
 		$user_country_id = $_REQUEST['country'];;
		//var $user_langugage_id;
		$user_email = $_REQUEST['useremail'];;
		$user_email2 = $_REQUEST['useremail1'];;
		$user_company = $_REQUEST['user'];
		$qry = "insert into user_base values (\"$user_id\",\"$user_name\",\"$user_lst_name\",\"$user_addr1\",\"$user_email\",\"$user_city_id\",date('$user_dob'),1,\"0004\",now());";
		//echo "<br> Query for adding user ".$qry;
		//executeQuery($qry);
		$qry = "insert into user_pass values (\"$user_id\",\"$password\",now(),now())";
		//executeQuery($qry);
		upload_userImage($user_id);
	}
	
	function upload_userImage($user_id){
		echo "Adding user images.";
      	$image = new ImageServices();
      	if (!((($_FILES["userimageFile"]["type"] == "image/gif") ||($_FILES["userimageFile"]["type"] == "image/jpg") ||($_FILES["userimageFile"]["type"] == "image/jpeg") || ($_FILES["userimageFile"]["type"] == "image/pjpg")||($_FILES["userimageFile"]["type"] == "image/pjpeg")) 
			&& ($_FILES["userimageFile"]["size"] < 20000))) {
				echo "<div class='errormsg'>The image you have choosed in either exceeds 20000KB or invalid format. Please click here.</div>";
				//return;
		}      	
		var_dump($_FILES);
		var_dump($_FILES['userimageFile']);
		echo "<br> Selected Image details ".$_FILES['userimageFile']["name"];
      	$image->load($_FILES['userimageFile']['tmp_name']);
      	$image->resizeToWidth(150);
      	$path = "../imgs/users/normal/$user_id.jpg";
      	$image->save($path);
      	echo "<div class='errormsg'>The image successfully uploaded.</div>";
	}
	
?>