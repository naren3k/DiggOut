<style>
.questionblock{
	border-color:#C7DA8B;  
	margin-left:4px;
	margin-right:4px;
	margin-top:4px;
	margin-bottom:4px; 
	border-style: solid; 
	border-width:thin;
	padding = 4px 4px 4px 4px;
	background-color = "#C7DA8B";
	font-family:Verdana;
	color:#333366;
	font-size:12px;
}


.userblock{
	border-color:#AAAAFF;  
	margin-left:4px;
	margin-right:4px;
	margin-top:4px;
	margin-bottom:4px; 
	border-style: solid; 
	border-width:thin;
	padding = 4px 4px 4px 4px;
	background-color = "#AAAAFF";
	font-family:Verdana;
	color:#333366;
	font-size:12px;
}

.headerItem{
	font-family:Verdana;
	font-size:24px;
	color:#333366;
}

.headerClass{
	font-family:Verdana;
	font-size:21px;
	color:#333366;
}

</style>
<?php

/*
 * Created on 25-Jan-09
 * All Questions will be listed here for the revieved itemId
 */
 	include 'Services/ForumServices.php';
 
 	$itemId = $_REQUEST['item'];
 	$itemBasicDetails = getItemBasicDetails($itemId);
 	echo "<table><tr><td><img src='images/Disscussion.png'/></td><td><font class='headerItem'>".$itemBasicDetails['itemName']."&nbsp; discussion page</font></td></tr></table>";
 	echo "<font class='headerClass'>".$itemBasicDetails['className']."</font>";
 	
 	$action = $_REQUEST['action'];
 	if($action == "postQuestion"){
 		$questionText  = $_REQUEST["questionText"];
 		postQuestion($itemId,$questionText);
 	}
 	
 	
 	$allQues = getItemQuestions($itemId);
	while ($row = mysql_fetch_assoc($allQues)){
		//echo "<div class='questionblock'>";
		$quesId = $row['ques_id'];
		$quesItemId = $row['item_id']; // Mostly woul't hav any significance'
		$quesDesc = $row['ques_desc'];
		$quesPostedBy = $row['ques_posted_by'];
		$quesPostedOn = $row['ques_posted_on'];
		echo "<table width='100%'><tr><td class='userblock' width='100px'>";
		echo "<center><img src='imgs/users/Dummy_user_small.png'/><br><center><a href='#'>".$quesPostedBy."</a></center>";
		echo "</td><td class='questionblock'>";	
		echo "<font>".$quesDesc."</font>";
		echo "<br><p>&nbsp;on&nbsp;".$quesPostedOn."&nbsp;&nbsp;<img src='images/comments.png'/><a href='Foruma.php?qid=".$quesId."'> View Replies</a></p>";
		echo "</td></tr></table>";//</div>";								
	}
	
?>

<script language="javascript">
function postQuestion(){
	var form = document.getElementById("questionForm");
	form.action = "Forum.php?action=postQuestion";
	form.submit();
	
}
</script>
<form id="questionForm" method="post">
<input type="hidden" id="item" name="item" value="<? echo $itemId?>"/>
<font>Post a question on this item :</font>
<table><tr><td>
<textarea id="questionText" name="questionText" cols=70 rows=5></textarea>
</td><td>
<img src="images/post_button.gif" style="cursor:hand;" onclick="postQuestion()"/></td>
</tr></table>
</form>