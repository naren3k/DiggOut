
<style type="text/css"> 
.rating{
	width:80px;
	height:16px;
	margin:0 0 20px 0;
	padding:0;
	list-style:none;
	clear:both;
	position:relative;
	background: url(images/star-matrix.gif) no-repeat 0 0;
}
/* add these classes to the ul to effect the change to the correct number of stars */
.0star {background-position:0 0}
.1star {background-position:0 -16px}
.2star {background-position:0 -32px}
.3star {background-position:0 -48px}
.4star {background-position:0 -64px}
.5star {background-position:0 -80px}
ul.rating li {
	cursor: pointer;
 /*ie5 mac doesn't like it if the list is floated\*/
	float:left;
	/* end hide*/
	text-indent:-999em;
}
ul.rating li a {
	position:absolute;
	left:0;
	top:0;
	width:16px;
	height:16px;
	text-decoration:none;
	z-index: 200;
}
ul.rating li.one a {left:0}
ul.rating li.two a {left:16px;}
ul.rating li.three a {left:32px;}
ul.rating li.four a {left:48px;}
ul.rating li.five a {left:64px;}
ul.rating li a:hover {
	z-index:2;
	width:80px;
	height:16px;
	overflow:hidden;
	left:0;	
	background: url(images/star-matrix.gif) no-repeat 0 0
}
ul.rating li.one a:hover {background-position:0 -96px;}
ul.rating li.two a:hover {background-position:0 -112px;}
ul.rating li.three a:hover {background-position:0 -128px}
ul.rating li.four a:hover {background-position:0 -144px}
ul.rating li.five a:hover {background-position:0 -160px}
/* end rating code */
h3{margin:0 0 2px 0;font-size:110%}
 
</style> 

<style>
.bar{
	font-family:Verdana;
	font-size:15px;
	color:#333366;
	/*font-weight:bold;
	font-stretch:extra-expanded;*/
}
.text1{
	font-family:Verdana;
	font-size:15px;
	color:#333366;

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

.attributes{
	border-color:#C7DA8B;  
	margin-left:0px;
	margin-right:0px;
	margin-top:4px;
	margin-bottom:4px; 
	border-style: solid; 
	border-width:thin;
	/*padding = 4px 4px 4px 4px;*/
	background-color = "#C7DA8B";
	font-family:Verdana;
	color:#333366;
	font-size:12px;
}
.errorMsgBlock{
	border-color:#F5BF9C;  
	margin-left:4px;
	margin-right:4px;
	margin-top:4px;
	margin-bottom:4px; 
	border-style: solid; 
	border-width:thin;
	padding = 4px 4px 4px 4px;
	background-color = "#FF6067";
	font-family:Verdana;
	font-size:12px;
}
</style>

<script language="JavaScript" type="text/javascript" src="JS/JSUtils.js"></script>
<script language="javascript">
var itemID = "<?echo $_REQUEST["item"]; ?>"
var userRating = "";
function addRating(rateValue){
	userRating = rateValue;
	var url = "Services/RatingServices.php?action=addRating&itemId="+itemID+"&rating="+rateValue;
	makeAjaxCall(url,"ratingAjaxReturn","GET");
}
	
function ratingAjaxReturn(){
	if( ajaxResopnseText == "rated"){
		var userRatingElement = document.getElementById("userRating");
		userRatingElement.className = "rating "+userRating+"star";
	}
}
	


</script>
<?php
/*
 * Created on 24-Jan-09
 * ShowItem..Item Page . FACE OF MY APPLICATION :) Naren k
 */
	include 'Services/ItemServices.php';
	//include 'Services/RatingServices.php';
	$itemDesc = "";
	$itemClass = "";
	$itemName = "";
	$itemID = $_REQUEST["item"];
	if($itemID == null){
		echo "<div class='errorMsgBlock'/>Invalid URL. Please click here to go to home page.</div>";
		exit;
	}
	$editUrl = "editItem.php?item=".$itemID;
	$avgRating = getItemAvgRating($itemID);
	$itemRecs = getItemDetails($itemID);
	while ($row = mysql_fetch_assoc($itemRecs)){
 		$itemName = $row['prod_name'];	
 		$itemClass = $row['class_name'];
 		$itemDesc = $row['prod_desc']; 		
 	}
?>
<table width="100%"><tr><td class="bar" align="left">
<td class="headeritem"><?echo $itemName;?></td>
<td class="text1" align="right"><img src="images/Gift_box.gif">wishlist&nbsp;<img src="images/heart_32.png">favorite&nbsp;<img src="images/book_mark1.gif">bookmark&nbsp;<img src="images/reply.png">edit</td>
</tr></table>


<div class="headerClass">&nbsp;<?echo $itemClass;?></div>

<div style="background-image:url(images/bg_bar.gif);height:30px; ">
<table width="100%"><tr><td class="bar" align="left">
D&nbsp;e&nbsp;s&nbsp;c&nbsp;r&nbsp;i&nbsp;p&nbsp;t&nbsp;i&nbsp;o&nbsp;n&nbsp;
</td>
<td class="text1" align="right"><img src="images/reply.png"><a href="<? echo $editUrl;?>">edit</a></td>
</tr></table></div>

<p class="text1"><?echo $itemDesc;?></p>

<div style="background-image:url(images/bg_bar.gif);height:30px; ">
<table width="100%"><tr><td class="bar" align="left">
S&nbsp;p&nbsp;e&nbsp;c&nbsp;i&nbsp;f&nbsp;i&nbsp;c&nbsp;a&nbsp;t&nbsp;i&nbsp;o&nbsp;n&nbsp;s&nbsp;</td>
<td class="text1" align="right"><img src="images/action_add.png"><a href="<? echo $editUrl;?>">add some more</a>&nbsp;<img src="images/reply.png"><a href="<? echo $editUrl;?>">edit</a></td>
</tr></table></div>
<table width="100%">
<?
	
	$itemAttrRows = getItemAttDetails($itemID);
	while ($row = mysql_fetch_assoc($itemAttrRows)){
		echo "<tr class='attributes'>";
		$attrName = $row[attrname];
		$attrId = $row[attr_id];
		$attrValue = $row[attr_value];
		echo "<td width='30%' align='right'>$attrName:</td><td align='left'>$attrValue</td>";
		echo "</tr>";
				
	}
?>



<table width="100%"><tr><td class="text1">
<tr><td classs="text1">
Your rating:

<ul id="userRating" class="rating 0star"> 
	<li class="one"><a href="#" onclick="addRating(1);" title="1 Star">1</a></li> 
	<li class="two"><a href="#" onclick="addRating(2);" title="2 Stars">2</a></li> 
	<li class="three"><a href="#" onclick="addRating(3);" title="3 Stars">3</a></li> 
	<li class="four"><a href="#" onclick="addRating(4);" title="4 Stars">4</a></li> 
	<li class="five"><a href="#" onclick="addRating(5);" title="5 Stars">5</a></li> 
</ul> 
</td><td class="text1">
Overall Rating:
<ul class="rating <?echo $avgRating?>star"> 
	<li class="one"><a href="#" title="1 Star">1</a></li> 
	<li class="two"><a href="#" title="2 Stars">2</a></li> 
	<li class="three"><a href="#" title="3 Stars">3</a></li> 
	<li class="four"><a href="#" title="4 Stars">4</a></li> 
	<li class="five"><a href="#" title="5 Stars">5</a></li> 
</ul> 
</td></tr></table>
<br><br>
<div style="background-image:url(images/bg_bar.gif);height:30px; ">
<table width="100%"><tr><td class="bar" align="left">
C&nbsp;o&nbsp;m&nbsp;m&nbsp;e&nbsp;n&nbsp;t&nbsp;s&nbsp;</td>
<td class="text1" align="right">:) </td>
</tr></table></div>
<table width="100%">
