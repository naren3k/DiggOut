<?php
/*
 * Created on 07-Dec-08 Naren
 * All Services related to items (products) 
 */
 include 'DBServices.php';
 
 allClassifications();
  $action = $_REQUEST['action'];
  
  /* Ajax services */
  if($action == "addNewAttr"){
  	$newAttr = $_REQUEST['addNewAttr'];
  	$qry = "insert into attributes values (null,\"".$newAttr."\");";
  	//echo "QRY ".$qry;
  	$res = executeQuery($qry);
  	//echo "DONE";
  	echo  allAttributes();
  }
  
  /* Ajax services end*/
  
  /* Submission, action and URL redirection */
 	$action = $_REQUEST["action"];
 	if($action == "addNewItem"){
 		var_dump($_REQUEST);
 		addNewItem();
 	}

 	if($action == "updateItem"){
 		var_dump($_REQUEST);
 		updateItem();
 	}
 	
  /* Submission, action and URL redirection - end*/
  
 function allClassifications(){
	$allClasses = executeQuery("SELECT * FROM classification_base ");
		$classArray  = array();
		$i = 0;
		$classStr = "";
		while ($row = mysql_fetch_assoc($allClasses)){
			$classStr = $classStr.$row['class_id']."&".$row['class_name']."&".$row['parent_classid'].";";
//			echo "<br>CLASS ID ".$row['class_id'];
//			echo "<br>CLASS NAME ".$row['class_name'];
//			echo "<br>CLASS PARENT ID ".$row['parent_classid'];
		}
		return $classStr;
 }
 


 function allAttributes(){
	$allAttrs = executeQuery("SELECT * FROM attributes ");
		$attrsArray  = array();
		$i = 0;
		$attrsStr = "";
		$row =null;
		while ($row = mysql_fetch_assoc($allAttrs)){
			$attrsStr = $attrsStr.$row['attrid']."&".$row['attrname'].";";
//			echo "<br>ATTR ID ".$row['attrid'];
//			echo "<br>ATTR Value ".$row['attrname']; 
		}
		//var_dump($attrsStr);
		return $attrsStr;
 }



 
 function rootClassifcations(){
 	$allClasses = executeQuery("SELECT * FROM classification_base where parent_classid = 0 ");
 	$classArray  = array();
 	$i = 0;
	$classStr = "";
	return $allClasses;  	
 }
 
 function addNewClassification($parentId,$className){
 	$qry = "insert into classification_base values(null,\"".$className."\",\"".$parentId."\");";	
 	//echo $qry;
 	executeQuery($qry);
 }
 
 function addNewItem(){
 	$itemName = $_REQUEST["itemName"];
 	$itemDesc = $_REQUEST["itemDesc"];
 	$classId = $_REQUEST["itemClassId"];
 	$user = "naren2talk";
 	$qry = "insert into product_base VALUES (null,\"".$itemName."\",\"".$itemDesc."\",\"".$user."\",NOW(),".$classId.");";
 	//echo "<br>New item addition query : ".$qry;
 	executeQuery($qry);
 	
 	$qry ="SELECT prod_id  FROM product_base where prod_name=\"".$itemName."\" and prod_desc=\"".$itemDesc."\" and prod_created_by=\"".$user."\";";
 	//echo "<BR> Query for newly generated class id ".$qry;
 	$justAdded = executeQuery($qry);
 	while ($row = mysql_fetch_assoc($justAdded)){
 		$justAddedItemID = $row['prod_id'];	
 	}
 	echo "<br> Generated Item ID ".$justAddedItemID;
 	
 	// Now adding attributes for the newly added item :) 
 	$keys = array_keys($_REQUEST);
 	$itemAttributes =  array();
 	foreach ($keys as &$key){
 		if(preg_match("/attr_/",$key)){
 			echo "<BR>match found for".$key;
 			//$attrKey = strstr($key, '_');
 			$attrKey = substr($key, 5,strlen($key));
 			$itemAttributes[$attrKey] = $_REQUEST[$key]; 
 		}
 	}
 	var_dump($itemAttributes);
 	// May be i have to find a better way than looping and execiting query one by one..
 	$attrIds = array_keys($itemAttributes);
 	foreach ($attrIds as $attr){
 		$attrValue = $_REQUEST["attr_".$attr];
 		$qry = "INSERT into prod_specs values(".$justAddedItemID.",".$attr.",\"".$attrValue."\");";
 		echo "-->".$qry;
 		executeQuery($qry);
 	}
 	
 	
 	
	echo "<BR>Image SIZE ".$_FILES["imageFile"]["size"];
	if ((($_FILES["imageFile"]["type"] == "image/gif") ||($_FILES["imageFile"]["type"] == "image/jpg") ||($_FILES["imageFile"]["type"] == "image/jpeg") || ($_FILES["imageFile"]["type"] == "image/pjpg")||($_FILES["imageFile"]["type"] == "image/pjpeg")) 
			&& ($_FILES["imageFile"]["size"] < 20000)) {
		if ($_FILES["imageFile"]["error"] > 0) {
			echo "Return Code: " . $_FILES["imageFile"]["error"] . "<br />";
		} else {
			/*echo "Upload: " . $_FILES["imageFile"]["name"] . "<br />";
			echo "Type: " . $_FILES["imageFile"]["type"] . "<br />";
			echo "Size: " . ($_FILES["imageFile"]["size"] / 1024) . " Kb<br />";
			echo "Temp file: " . $_FILES["imageFile"]["tmp_name"] . "<br />";*/
			if (file_exists("..imgs/items/" . $_FILES["imageFile"]["name"])) {
				//echo $_FILES["imageFile"]["name"] . " already exists. ";
			} else {
				move_uploaded_file($_FILES["imageFile"]["tmp_name"], "../imgs/items/" . $_FILES["imageFile"]["name"]);
				//echo "Stored in: " . "imgs/items/" . $_FILES["imageFile"]["name"];
			}
		}
	} else {
		echo "Invalid file";
	}
 	
 	
 }// end of addNewItem
 
 
 
 function updateItem(){
 	
 	$itemName = $_REQUEST["itemName"];
 	$itemDesc = $_REQUEST["itemDesc"];
 	$classId = $_REQUEST["itemClassId"];
 	$itemId = $_REQUEST["itemId"];
 	
 	//var_dump($_REQUEST);
 	$user = "naren2talk";
 	$qry = "update  product_base set prod_name = \"".$itemName."\", prod_desc = \"".$itemDesc."\" where prod_id = '".$itemId."';";
 	//echo "<br>New item addition query : ".$qry;
 	executeQuery($qry);

 	// Now Updating the existing attributes for this item :) 
 	$keys = array_keys($_REQUEST);
 	$itemAttributes =  array();
 	foreach ($keys as &$key){
 		if(preg_match("/existingAttr_/",$key)){
 			echo "<BR>match found for".$key;
 			//$attrKey = strstr($key, '_');
 			$attrKey = substr($key, 13,strlen($key));
 			$itemAttributes[$attrKey] = $_REQUEST[$key]; 
 		}
 	}
 	var_dump($itemAttributes);
 	// May be i have to find a better way than looping and execiting query one by one..
 	$attrIds = array_keys($itemAttributes);
 	foreach ($attrIds as $attr){
 		$attrValue = $_REQUEST["existingAttr_".$attr];
 		$qry = "UPDATE  prod_specs set attr_value =\"".$attrValue."\"  where attr_id='".$attr."' and product_id = '".$itemId."';";
 		echo "<BR> Updating existing attrs qry : -->".$qry;
 		executeQuery($qry);
 	}
 	

 	// Now adding new  attributes for this item :) 
 	$keys = array_keys($_REQUEST);
 	$itemAttributes =  array();
 	foreach ($keys as &$key){
 		if(preg_match("/attr_/",$key)){
 			echo "<BR>match found for".$key;
 			//$attrKey = strstr($key, '_');
 			$attrKey = substr($key, 5,strlen($key));
 			$itemAttributes[$attrKey] = $_REQUEST[$key]; 
 		}
 	}
 	var_dump($itemAttributes);
 	// May be i have to find a better way than looping and execiting query one by one..
 	$attrIds = array_keys($itemAttributes);
 	foreach ($attrIds as $attr){
 		$attrValue = $_REQUEST["attr_".$attr];
 		$qry = "INSERT into prod_specs values(".$itemId.",".$attr.",\"".$attrValue."\");";
 		echo "-->".$qry;
 		executeQuery($qry);
 	}

	header('Location: ../item.php?item='.$itemId);
	exit;
 	
 	
	echo "<BR>Image SIZE ".$_FILES["imageFile"]["size"];
	if ((($_FILES["imageFile"]["type"] == "image/gif") ||($_FILES["imageFile"]["type"] == "image/jpg") ||($_FILES["imageFile"]["type"] == "image/jpeg") || ($_FILES["imageFile"]["type"] == "image/pjpg")||($_FILES["imageFile"]["type"] == "image/pjpeg")) 
			&& ($_FILES["imageFile"]["size"] < 20000)) {
		if ($_FILES["imageFile"]["error"] > 0) {
			echo "Return Code: " . $_FILES["imageFile"]["error"] . "<br />";
		} else {
			/*echo "Upload: " . $_FILES["imageFile"]["name"] . "<br />";
			echo "Type: " . $_FILES["imageFile"]["type"] . "<br />";
			echo "Size: " . ($_FILES["imageFile"]["size"] / 1024) . " Kb<br />";
			echo "Temp file: " . $_FILES["imageFile"]["tmp_name"] . "<br />";*/
			if (file_exists("..imgs/items/" . $_FILES["imageFile"]["name"])) {
				//echo $_FILES["imageFile"]["name"] . " already exists. ";
			} else {
				move_uploaded_file($_FILES["imageFile"]["tmp_name"], "../imgs/items/" . $_FILES["imageFile"]["name"]);
				//echo "Stored in: " . "imgs/items/" . $_FILES["imageFile"]["name"];
			}
		}
	} else {
		echo "Invalid file";
	}
}// END OF UPDATE ITEM
 
 
 
 function getItemDetails($itemId){
 	//$qry = "select * from product_base where prod_id = ".$itemId.";"; i know this s not gud 
 	$qry = "select p.prod_id,p.prod_name,p.prod_desc,p.prod_created_by,p.prod_created_on,p.prod_subclass_id,c.class_name from product_base p join classification_base c on (c.class_id = p.prod_subclass_id) where p.prod_id =". $itemId.";";
 	//echo "<br> Executed this query for getting items basic info : ".$qry;   
 	$itemRow = executeQuery($qry);
 	return $itemRow;
 }
 
function getItemAttDetails($itemId){
	$qry = "select s.attr_id,s.attr_value,a.attrname from prod_specs s join attributes a on (a.attrid = s.attr_id) where s.product_id = ".$itemId.";";
 	//echo "<br> Executed this query for getting items ATTRIBUTES info : ".$qry;
 	$itemAttrRows = executeQuery($qry);
 	return  $itemAttrRows;	
} 


/* RATING STUFF */
  function getItemAvgRating($itemID){
  	$qry = "select round(avg(rating),0) 'rating' from prod_ratings where prod_id = ".$itemID." group by (prod_id);";
  	//echo "<br> executed for overall rating.. : ".$qry;
  	
  	$ratingrows = executeQuery($qry);
  	$avgRating = "0";
  	while ($row = mysql_fetch_assoc($ratingrows)){
  		$avgRating = $row['rating'];
  	}
  	return $avgRating;
  }
  


?>
