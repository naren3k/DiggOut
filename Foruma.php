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
}

.answerblock{
	border-color:#F5BF9C;  
	margin-left:4px;
	margin-right:4px;
	margin-top:4px;
	margin-bottom:4px; 
	border-style: solid; 
	border-width:thin;
	padding = 4px 4px 4px 4px;
	background-color = "#F5BF9C";
	font-family:Verdana;
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

.text{
	font-family:Verdana;
	font-size:13px;
	color:#333366;
}
</style>

<?php
/*
 * Created on 25-Jan-09
 * Foruma stands for Forum- Answers
 *
 */
 	include 'Services/ForumServices.php';
 
 	$qId = $_REQUEST['qid'];
 	
 	$action = $_REQUEST['action'];
 	if($action == "postAnswer"){
 		$answerText  = $_REQUEST["answerText"];
 		postAnswer($qId,$answerText);
 	}
 	
 	
 	$qDetails = getQuestionBasicDetails($qId);
 	echo "<table><tr><td><img src='images/Disscussion.png'/></td><td><font class='headerItem'>".$qDetails['itemName']."&nbsp; discussion page</font></td></tr></table>";
 	echo "<font class='headerClass'>".$qDetails['className']."</font>";
 	//echo "<h1><img src='images/Disscussion.png'/>".$qDetails['itemName']."</h1>";
 	//echo "<h2>".$qDetails['className']."</h2>";
 	echo "<table width='100%'><tr><td class='userblock' width='100px'>";
	echo "<center><img src='imgs/users/Dummy_user_small.png'/><br><center><a class='text' href='#'>".$qDetails['qPostedBy']."</a></center>";
	echo "</td><td class='questionblock'>";
	echo "<b class='text'>".$qDetails['qText']."</b>";
	echo "<br><p class='text'>&nbsp;Asked on&nbsp;&nbsp;".$qDetails['qPostedOn']."&nbsp;&nbsp;</p>";
	echo "</td></tr></table>";
	
		
 	echo "<BR>";
 	$allAns = getAnswers($qId);
	while ($row = mysql_fetch_assoc($allAns)){
		$ansId = $row['ans_id'];
		$ansQesId = $row['qus_id']; // Mostly woul't hav any significance'
		$ansDesc = $row['ans_desc'];
		$ansPostedBy = $row['ans_posted_by'];
		$ansPostedOn = $row['ans_posted_on'];
		echo "<table width='100%'><tr><td class='userblock' width='100px'>";
		echo "<center><img src='imgs/users/Dummy_user_small.png'/><br><center><a class='text' href='#'>".$ansPostedBy."</a></center>";
		echo "</td><td class='answerblock'>";
		echo "<b class='text'>".$ansDesc."</b>";
		echo "<br><p class='text'>&nbsp;Posted on&nbsp;&nbsp;".$ansPostedOn."&nbsp;&nbsp;</p>";
		echo "</td></tr></table>";
		
		
		//echo "<h3>".$ansDesc."</h3>";
		//echo "<p>Posted By:&nbsp;".$ansPostedBy."&nbsp;on&nbsp;".$ansPostedOn."</p>";								
	}
	
?>

<script language="javascript">
function postAnswer(){
	var form = document.getElementById("answerForm");
	form.action = "Foruma.php?action=postAnswer";
	form.submit();
	
}
</script>
<form id="answerForm" method="post">
<input type="hidden" id="qid" name="qid" value="<? echo $qId?>"/>
Write down your reply here:
<table><tr><td>
<textarea id="answerText" name="answerText" cols=70 rows=5></textarea>
</td><td>
<img src="images/post_button.gif" style="cursor:hand;" onclick="postAnswer()"/></td>
</tr></table>
</form>
 
 
