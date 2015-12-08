<?php
/*
 * Created on 25-Jan-09
 *
 *	Helps FORUM pages . Naren K
 *	My Second module of application :) :)
 */
  include 'DBServices.php';

  
  function getItemQuestions($itemId){
 	$qry = "select * from forum_questions where item_id = ".$itemId;
 	$questionRows = executeQuery($qry);
 	return $questionRows ;
  }

  function postQuestion($itemId,$questionText){
  	$user = "naren2talk";
 	$qry = "insert into forum_questions values (null,".$itemId.",\"".$questionText."\",\"".$user."\",NOW());";
 	executeQuery($qry);
  }

  function getAnswers($qId){
 	$qry = "select * from forum_answers where ques_id = ".$qId;
 	$answerRows = executeQuery($qry);
 	return $answerRows;
  }

  function postAnswer($qId,$answerText){
  	$user = "naren2talk";
 	$qry = "insert into forum_answers values (null,".$qId.",\"".$answerText."\",NOW(),\"".$user."\");";
 	//echo "<br> Executed this for posting answer : ".$qry;
 	executeQuery($qry);
  }



 /* may be itemservice */
 function getItemBasicDetails($itemId){
 	$qry = "select p.prod_name,p.prod_id,c.class_id,c.class_name from product_base p join classification_base c on (p.prod_subclass_id = c.class_id) where p.prod_id = ".$itemId.";";
 	$allRows = executeQuery($qry);
 	$itemDetails= array("itemId" => "","itemName" => "","classId" => "","className" => "");
 	while ($row = mysql_fetch_assoc($allRows)){
 		$itemDetails['itemId'] = $row['prod_id'];
 		$itemDetails['itemName'] = $row['prod_name']; 			
 		$itemDetails['classId'] = $row['class_id'];
 		$itemDetails['className'] = $row['class_name'];
 	}
 	//var_dump($itemDetails);
	return $itemDetails;
 }
 
 function getQuestionBasicDetails($qestionId){
 	$qry = "select q.ques_desc,q.ques_id,q.item_id,q.ques_posted_on,q.ques_posted_by,p.prod_name,p.prod_subclass_id,c.class_name from forum_questions q join product_base p on(q.item_id = p.prod_id) join classification_base c on (c.class_id = p.prod_subclass_id) where q.ques_id = ".$qestionId.";";
 	$qDetails = array ("qId"=>"","qText"=>"","itemId"=>"","itemName"=>"","classId"=>"","className"=>"");
 	$allRows = executeQuery($qry);
 	while ($row = mysql_fetch_assoc($allRows)){
 		$qDetails['qId'] = $row['ques_id'];
 		$qDetails['qText'] = $row['ques_desc'];
 		$qDetails['itemId'] = $row['item_id'];
 		$qDetails['itemName'] = $row['prod_name'];
 		$qDetails['classId'] = $row['prod_subclass_id'];
 		$qDetails['className'] = $row['class_name'];
 		$qDetails['qPostedOn'] = $row['ques_posted_on'];
 		$qDetails['qPostedBy'] = $row['ques_posted_by'];
 	}
 	return $qDetails;
  }
 
 
?>
