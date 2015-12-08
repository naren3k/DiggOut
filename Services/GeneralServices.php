<?php
/*
 * Created on 29-Nov-08
 * General Services.
 */
 
 $action = $_REQUEST['action'];
 
 /**
  * Called By Ajax to build States list.
  */
 if($action == 'getStates'){
 	$country = $_REQUEST['country'];
    $allStates = getStates($country);
    $string = "";
    foreach($allStates as &$state){
    	$string = $string."-".$state; 	
    }
    echo $string;
 }
 
 
 /**
  * 
  */
 function getCountries(){
 	
 	return array("India","USA","UK");
 }
 
 function getStates($cntry){
 	if($cntry == "India"){
 		return array("AP","Tamil Nadu","Karnataka","Kerala");
 	}else if($cntry == "USA"){
 		return array("California","Sanfransisco","Dollas");
 	}else if($cntry == "UK"){
 		return array("Scotland","Englanf","Whales");
 	
 	}
 	
 }
 
?>
