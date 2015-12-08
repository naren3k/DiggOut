<?php
/*
 * Created on 28-Jan-09
 * All rating related stuff will be handled here ***** :)
 */
 
  include 'DBServices.php';
  $action = $_REQUEST['action'];
  
  /* Ajax services */
  if($action == "addRating"){
  	$rating = $_REQUEST['rating'];
  	$itemId = $_REQUEST['itemId'];
  	$user = "naren2talk";
  	$qry = "insert into prod_ratings VALUES (".$itemId.",".$rating.",\"".$user."\",NOW());";
  	//echo "<BR> Executed this query for posting rating : ".$qry;
  	executeQuery($qry);
  	echo "rated";
  }
  
  /* Ajax services */
  
?>
