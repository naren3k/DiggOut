
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
.newAttrBlock {
	border-color:#C7DA8B;  
	margin-left:2px;
	margin-right:2px;
	margin-top:2px;
	margin-bottom:2px; 
	border-style: solid; 
	border-width:thin;
	padding = 2px 2px 2px 2px;
	background-color = #F5BF9C;
	font-family:Verdana;
		font-size:12px;
}

</style>
<?
include 'Services/ItemServices.php';
$attrStr = allAttributes();
 	echo "\n<SCRIPT language='javascript'>\nvar classStr=\"".$classStr ."\";\n";
 	echo "attrStr = \"".$attrStr." \";\n ";
 	echo "</SCRIPT>";
 ?>
 
 <script>
 /* ATTRIBUTEs */
function loadAttrs(){
	var attributes = attrStr.split(";");
	var attrId;
	var attrName;
	var opt ;
	var attrSel =  document.getElementById("attrSel");
	attrSel.length = 0;
	for(var i=0;i<attributes.length;i++){
		attrId = attributes[i].split("&")[0];
		attrName = attributes[i].split("&")[1];
		opt = new Option(attrName,attrId);
		attrSel.options.add(opt,i);
	}
	opt = new Option("++ADD NEW ATTRIBUTE ++","addNewAttribute");
	attrSel.options.add(opt,i);
	
	
}


function addItemAttr()
{
	var attrSel = document.getElementById("attrSel");
	var attrName = attrSel.options[attrSel.selectedIndex].text;
	var attrId = attrSel.options[attrSel.selectedIndex].value;
	var attrDiv = document.getElementById("attrDiv");
	var attrPrevTab = document.getElementById("attrTab"+attrId);
	if(attrPrevTab != null ){
		return;
	}
	var newTR = "<Table width='100%' style=\"display=''; \" id='attrTab"+attrId+"'><TR class='attributes'>";
	newTR += "<TD width='30%' align='right'><img style='cursor:hand;' onclick=\"removethisAttr('attrTab"+attrId+"');\" src='images/action_delete.png'>";
	newTR += "&nbsp;"+attrName+":</TD><TD width='60%'><input type='text' id='attr_"+attrId+"' name='attr_"+attrId+"'></TD>";
	newTR += "</TR></table>";
	var temp = attrDiv.innerHTML + newTR;
	allAttrs = allAttrs + "&" + attrId;
	attrDiv.innerHTML = temp;
}


function removethisAttr(attrTabName){
	var attr = document.getElementById(attrTabName);
	attr.disabled = true;
	attr.style.display = "none";
}
function dummy(){
}

function showAddAttrDiv(val){
	if(val == "addNewAttribute"){
		document.getElementById("addNewAttrDiv").style.display = "";
	}else{
		document.getElementById("addNewAttrDiv").style.display = "none";
	}
}

function addNewAttribute(){
	
	var newAttribute = document.getElementById("newAttribute").value;
	var url = "Services/ItemServices.php?action=addNewAttr&addNewAttr="+newAttribute;
	//alert("AJAXING "+url);
	makeAjaxCall(url,"addAttrAjaxReturn","GET");
	document.getElementById("addNewAttrDiv").style.display = "none";
}
function addAttrAjaxReturn(){
	//alert(ajaxResopnseText);
	attrStr = ajaxResopnseText;
	loadAttrs(); 
	document.getElementById("addNewAttrMsg").style.display = "";
}

/* ATTRIBUTEs end*/
 
 </script>	
<script language="JavaScript" type="text/javascript" src="JS/JSUtils.js"></script>
<script language="javascript">
var allAttrs = "";
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
	
function updateItem(){
	var form = document.getElementById("editForm");
	form.method = "post";
	form.action = "Services/itemServices.php?action=updateItem";
	form.submit();
}

</script>
<?php
/*
 * Created on 28-Jan-09
 * Edit mode of the selected Item .Naren k
 */
	//include 'Services/ItemServices.php';
	//include 'Services/RatingServices.php';
	$itemDesc = "";
	$itemClass = "";
	$itemName = "";
	$itemID = $_REQUEST["item"];
	$avgRating = getItemAvgRating($itemID);
	$itemRecs = getItemDetails($itemID);
	while ($row = mysql_fetch_assoc($itemRecs)){
 		$itemName = $row['prod_name'];	
 		$itemClass = $row['class_name'];
 		$itemDesc = $row['prod_desc']; 		
 	}
?>
<BODY onload="loadAttrs()">
<form id="editForm" name="editForm">
<input type="hidden" id="itemId" name="itemId" value="<?echo $_REQUEST["item"];?>" />
<table width="100%"><tr><td class="bar" align="left">
<td class="headeritem"><input type="text" class="headeritem" id="itemName" name="itemName" value="<?echo $itemName;?>" /></td>
<td class="text1" align="right"></td>
</tr></table>

<font class="text1"> &nbsp;Classification</font>:
<div class="headerClass">&nbsp;<?echo $itemClass;?></div>

<div style="background-image:url(images/bg_bar.gif);height:30px; ">
<table width="100%"><tr><td class="bar" align="left">
D&nbsp;e&nbsp;s&nbsp;c&nbsp;r&nbsp;i&nbsp;p&nbsp;t&nbsp;i&nbsp;o&nbsp;n&nbsp;
</td>
<td class="text1" align="right"><img src="images/reply.png">edit</td>
</tr></table></div>

<textarea class="text1" cols="80" id="itemDesc" name="itemDesc" rows="5"><?echo $itemDesc;?></textarea>

<div style="background-image:url(images/bg_bar.gif);height:30px; ">
<table width="100%"><tr><td class="bar" align="left">
S&nbsp;p&nbsp;e&nbsp;c&nbsp;i&nbsp;f&nbsp;i&nbsp;c&nbsp;a&nbsp;t&nbsp;i&nbsp;o&nbsp;n&nbsp;s&nbsp;</td>
<td class="text1" align="right"></td>
</tr></table></div>
<table width="100%">
<?
	
	$itemAttrRows = getItemAttDetails($itemID);
	while ($row = mysql_fetch_assoc($itemAttrRows)){
		echo "<tr class='attributes'>";
		$attrName = $row[attrname];
		$attrId = $row[attr_id];
		$attrValue = $row[attr_value];
		echo "<td  width='30%' align='right'>$attrName:</td><td align='left'><input type='text' id='existingAttr_".$attrId."'  name='existingAttr_".$attrId."'  value='".$attrValue."' /><input type='hidden' id='attrTab".$attrId."' /> </td>";
		echo "</tr>";
				
	}
?>
</table>
<div class="block" id="attrsDiv" name="attrsDiv">


<div class="block" id="attrsDiv" name="attrsDiv">
<table id="attrTable" name="attrTable" width="100%">
<thead><th width="10%"></th><th align="right" width="40%"></th><th align="left" width="40%"></th></thead>

</table>
<div id="attrDiv">
<table></table>
</div>
<select id="attrSel" name="attrSel" onchange="showAddAttrDiv(this.value);" style="width:350px;"></select><img onclick="addItemAttr();" style="cursor:hand;" src="images/action_add.png"/><a onclick="addItemAttr();" href="#">Add another</a>
<br>
<div class="newAttrBlock" id="addNewAttrDiv" style="display:none;">New Attribute:<input id="newAttribute" name="newAttribute" maxlength="20" type="text" style="width:250px;"/><img onclick="addItemAttr();" style="cursor:hand;" src="images/action_add.png"/><a href="#" onclick="addNewAttribute()">Add new attribute</a></div>
<div class="newAttrBlock" id="addNewAttrMsg" style="display:none;">Thanks for uploading the new attribute :) <img src="images/action_delete.png" onclick="document.getElementById('addNewAttrMsg').style.display='none';"  /></div> 
</div>
</div>
<br><a href="#" onclick="updateItem();">Update</a>
</form>
</BODY>