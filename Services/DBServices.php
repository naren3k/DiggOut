<?php
/*
 * All DB2 Operations, Connection Management are done here. I am worried about performace, not sure
 * if I have to go for Object Oriented Approch. (ASSUMPTION1)
 * Naren K / 2 Dec 08
 */


 
 function makeConnection(){
 	//echo "<br><b>CREATING NEW CONNECTION</B>";
 	$host = "localhost:3306";
 	$port = "3306";
 	$userName = "root";
 	$pw = "karanam";
 	$database = "myPro";
 	
 	$conn = mysql_connect($host, $userName, $pw) or die("DB Connection Error :".mysql_error()."<BR>Please <a href='#'>click here</a>");
 	mysql_select_db($database);
 	$_SESSION['connAlive'] = "alive";
 	
 	return conn;
 }
 
 function executeQuery($qry){
 	//session_start();
 	$conn = $_SESSION['connection'];
 	if($_SESSION['connAlive'] != "alive"){
 		$_SESSION['connection'] = makeConnection();
 	}else{
 		$conn = $_SESSION['connection'];
 		$_SESSION['connection'] = makeConnection();
 	}
 	//$conn = makeConnection();
	$result = mysql_query ($qry);
	if (!$result) {
    	$message  = 'Invalid query: ' . mysql_error() . "\n";
    	$message .= 'Whole query: ' ;
    	die($message);
	}
	return $result;
}

 function makeConnectionForSP(){
 	//echo "<br><b>CREATING NEW CONNECTION</B>";
 	$host = "localhost:3306";
 	$port = "3306";
 	$userName = "root";
 	$pw = "karanam";
 	$database = "myPro";
 	
 	$conn = mysql_connect($host, $userName, $pw,0, 65536) or die("StrProc DB Connection Error :".mysql_error()."<BR>Please <a href='#'>click here</a>");
 	// 0, 65536 are the special constants for SP Calls , Ref :http://www.artfulsoftware.com/infotree/tip.php?id=777 - Naren K
 	mysql_select_db($database);
 	
 	return conn;
 }
 
 
function executeSP($qry){
 	//session_start();
 	/*$conn = $_SESSION['connection'];
 	if($_SESSION['connAlive'] != "alive"){
 		$_SESSION['connection'] = makeConnection();
 	}else{
 		$conn = $_SESSION['connection'];
 		$_SESSION['connection'] = makeConnection();
 	}
 	//$conn = makeConnection();*/
 	makeConnectionForSP();
	$result = mysql_query ($qry);
	if (!$result) {
    	$message  = '<br>Invalid SP query: ' . mysql_error() . "\n";
    	$message .= '<br>Whole SP query: '.$qry ;
    	die($message);
	}
	return $result;
}



/* will not be used */
function getClassifications(){
		
		$allClasses = executeQuery("SELECT * FROM classification_base ");
		$classArray  = array();
		$i = 0;
		while ($row = mysql_fetch_assoc($allClasses)){
			//echo "<BR>i</BR><BR>ID-> ".$row['class_id']." NAME ->".$row['class_name']." PARENT -->".$row['parentclass_id']." ";
			$classArray[$i]["class_id"] = $row['class_id']; 
			$classArray[$i]["class_name"] = $row['class_name'];
			$classArray[$i]["parent_classid"] = $row['parent_classid'];
			$i++;
		}
		
		
		printClassTree($classArray,0);
		
}



/* will not be used */
function printClassTree($classArray ,$root){
	
	$toParse = array();
	$i=0;
	echo  "<BR><B>CHILDREN OF  ".$root."</B>";
	foreach($classArray as $class){
		
		if($class["parent_classid"] == $root){
			echo "<BR>&nbsp;--> ".$class["class_name"]."--".$class["class_id"];
			$toParse[$i++] = 	$class["class_id"];				
		}
	}
	foreach($toParse as $classId){
		printClassTree($classArray ,$classId);
	}	
		
}
?>