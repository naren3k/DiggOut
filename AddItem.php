<?php
/*
 * 
 * Actions Add Item , Edit Item
 * Naren K / 15 Dec 08
 */
	include 'Services/ItemServices.php';
	
	/* Internal Actions */
	$action = $_REQUEST['action'];
	if($action == "addNewClass"){
		$parentId = $_REQUEST['parentId'];
		$className = $_REQUEST['className'];
		addNewClassification($parentId,$className);
	}
	/* End - Internal Actions */
	$classStr = allClassifications();
	$attrStr = allAttributes();
 	echo "\n<SCRIPT language='javascript'>\nvar classStr=\"".$classStr ."\";\n";
 	echo "attrStr = \"".$attrStr." \";\n ";
 	echo "</SCRIPT>";
 	$rootClasses = rootClassifcations();
?>
<STYLE>
.block{
	
	border-color:#EEF1F9;  
	margin-left:4px;
	margin-right:4px;
	margin-top:4px;
	margin-bottom:4px; 
	border-style: solid; 
	border-width:thin;
	padding = 4px 4px 4px 4px;
	background-color = "#EEF1F9";
	font : Vardana;
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
	background-color = #C7DA8B;
	font : Vardana;
}
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
</style>

</STYLE>

  <script language="JavaScript" type="text/javascript" src="JS/JSUtils.js"></script>
<SCRIPT language = 'javascript'>

var allClasses = classStr.split(";");
var currentyOpenedClassLevels = 0;
var allAttrs = "";

/* CLASSIFICATIONS*/
function classificationTree(thisnode){
	var classDiv = document.getElementById("classifications");
	var thisID =  thisnode.id;
	var i = 0;
	// Remove the branches of this node first.
	if(thisnode.id == "rootClass"){
		 for(var j=1;j<=currentyOpenedClassLevels;j++){
		 	classDiv.removeChild(document.getElementById("branch_"+j));
		 }
		 currentyOpenedClassLevels = 0;
	}else{
		 var thisLevel = eval(thisnode.id.split("_")[1]);
		 var tmp = currentyOpenedClassLevels;
		 for(var j=thisLevel+1;j<=tmp;j++){
		 	classDiv.removeChild(document.getElementById("branch_"+j));
		 	currentyOpenedClassLevels--;
		 }
	}
	
	if(thisnode.value == "addNew"){
		showAddItem();
		return;
	}
	
	//alert("thisnode.id -> "+thisnode.id);
	//alert("currentyOpenedClassLevels "+currentyOpenedClassLevels);
	var thisValue = thisnode.value;
	var children = getChildrenForThis(thisValue);
}

function showAddItem(){
	
	var rootListObj  = document.getElementById("rootClass");
	//alert("=>"+rootListObj.options[rootListObj.selectedIndex].text);
	var htmlText  = "<img src='images/reply.png' style='cursor:hand;' onclick='showClassificationEdit();'/>";
	htmlText += rootListObj.options[rootListObj.selectedIndex].text+"&nbsp;<img src='images/arrow_next.png'/>";
	
	if(currentyOpenedClassLevels == 0){
		htmlText += "<input type='text' id='newClass' name='newClass'></input>";
	}else{
		for(var j=1;j<currentyOpenedClassLevels;j++){
			var branchObj = document.getElementById("branch_"+j);
			var className =  branchObj.options[branchObj.selectedIndex].text;
			htmlText += className +"&nbsp;<img src='images/arrow_next.png'/> &nbsp;";
		}
		htmlText += "<input type='text' id='newClass' name='newClass'></input>";
	}
	htmlText += " <img src='images/action_add.png'/> <a href='#' onclick = 'addNewClass();'>       AddClass</a>";
	hideClassificationEdit();
	document.getElementById("addClass").innerHTML = htmlText; 
	
	//alert("currentyOpenedClassLevels"+currentyOpenedClassLevels);
	
}

	
function hideClassificationEdit(){
	document.getElementById("classifications").style.display= "none";
	document.getElementById("addClass").style.display = "";
}	

function showClassificationEdit(){
	document.getElementById("classifications").style.display = "";
	document.getElementById("addClass").style.display = "none";
}	
	


function getChildrenForThis(parent){
	var classId;
	var className;
	var parentID;
	var j = 0;
	var i=0;
	var childClasses = new Array();
	for(i=0;i<allClasses.length;i++){
			if(allClasses[i].split("&")[2] == parent ){
				childClasses[j++] =allClasses[i]; 
			}
	}
	buildChildComp(childClasses,parent);
}

function buildChildComp(childClasses,parent){
	var i = 0;
	if(childClasses.length == null){
		return;
	}
	currentyOpenedClassLevels = currentyOpenedClassLevels + 1;
	var newDiv = document.createElement("div");
	newDiv.setAttribute("id","branch");
	var newSel = document.createElement("select");
	newSel.setAttribute("id","branch_"+currentyOpenedClassLevels);
	newSel.setAttribute("name","branch_"+currentyOpenedClassLevels);
	
	newSel.setAttribute("onchange","classificationTree(this)");
	newSel.onchange = new Function("classificationTree(this)");
	var opt;	
	newSel.options.add(new Option("Select here","nothing"),0);
	newSel.options.add(new Option("Add New","addNew"),1);
	newSel.options.add(new Option("------------","nothing"),2);
	for(i=0;i<childClasses.length;i++){
		opt = new Option(childClasses[i].split("&")[1],childClasses[i].split("&")[0]);
		newSel.options.add(opt,i+3);// +3 is bcoz of first 3 xtra options.
	}
	document.getElementById("classifications").appendChild(newSel);
}

function addNewClass(){
	//alert("currentyOpenedClassLevels "+currentyOpenedClassLevels);
	var parentId;
	var className = document.getElementById("newClass").value;
	if(currentyOpenedClassLevels == 0){
		//alert("Adding as root");
		parentId = 0;
	}else if(currentyOpenedClassLevels == 1){
		parentId = document.getElementById("rootClass").value;
	}else{
		parentId = document.getElementById("branch_"+eval(currentyOpenedClassLevels-1)).value;
	}
	//alert("Adding to parent "+parentId);
	var addNewClassificationUrl = "AddItem.php?action=addNewClass&parentId="+parentId+"&className="+className;
	document.getElementById("itemForm").action = addNewClassificationUrl;
	document.getElementById("itemForm").submit();
}

/* CLASSIFICATIONS end */

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
	var newTR = "<Table width='100%' style=\"display=''; \" id='attrTab"+attrId+"'><TR>";
	newTR += "<TD><img style='cursor:hand;' onclick=\"removethisAttr('attrTab"+attrId+"');\" src='images/action_delete.png'></TD>";
	newTR += "<TD width='30%'>"+attrName+":</TD><TD width='60%'><input type='text' id='attr_"+attrId+"' name='attr_"+attrId+"'></TD>";
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


function addItem(){
	var form = document.getElementById("itemForm");
	var classDiv = document.getElementById("classifications");
	form.method = "post";
	form.action = "Services/ItemServices.php?action=addNewItem";
	// get set go :)
	
	//alert("Length "+classDiv.children.length);
	var classID;
	if(classDiv.children.length >= 2){
		var lastButOneSelectBox = classDiv.children[classDiv.children.length-2];
		classID = lastButOneSelectBox.options[lastButOneSelectBox.selectedIndex].value;
		
	}else{
		//var lastButOneSelectBox = classDiv.children[classDiv.children.length-2];
		//classID = lastButOneSelectBox.options[lastButOneSelectBox.selectedIndex].value;
		classID = document.getElementById("rootClass").value;
	}
	//alert("classID "+classID);
	document.getElementById("itemClassId").value = classID;
	//document.getElementById("allAttrs").value = allAttrs;
	form.submit();
}

function showImage(){
	var fil =  document.getElementById("imageFile").value;
	var itemImg = document.getElementById("itemImg").src = fil;
	//alert(document.getElementById('itemImg').src);
	//alert(fil);
	
} 


</SCRIPT>

<BODY onload="loadAttrs()">
<form enctype="multipart/form-data" id="itemForm" action="" method="post">
<div style="background-image:url(images/bg_bar.gif);height:30px; ">
<table width="100%"><tr><td class="bar" align="left">
C&nbsp;l&nbsp;a&nbsp;s&nbsp;s&nbsp;i&nbsp;f&nbsp;i&nbsp;c&nbsp;a&nbsp;t&nbsp;i&nbsp;o&nbsp;n&nbsp;</td>
<td class="text1" align="right"></td>
</tr></table></div>

<div class="block" id="classifications" style="display:'';" >Classify the Item:
<SELECT id="rootClass" name="rootClass" size="1" onchange="classificationTree(this)">
<?
	while ($row = mysql_fetch_assoc($rootClasses)){
		echo "<OPTION value=".$row['class_id']." >".$row['class_name']."</OPTION>";
	}
	echo "<OPTION   value=".'addNew'." >"."Add New"."</OPTION>";
?>
</SELECT>
</div>

<div class="block" id ="addClass" name="addClass" style="display:'none';" ></div>
<div id="ClassStatus" class="newAttrBlock" style="display:none"> <input type="hidden" id="itemClassId" name="itemClassId"/></div>
<div class="block">Item Name : <input type="text" id="itemName" name="itemName" /></div>
<div class="block" width="100%">Describe Item :
<table width="100%" border="1">
<tr><td width="450px"><textarea id="itemDesc" name="itemDesc" rows="20" cols="70"></textarea></td>
<td width="150px"><img width="150px" src="images/noImage.gif"/></td></tr>
<tr><td> <input id="imageFile" name="imageFile" type="file" onchange="showImage()" /> <img id="itemImg" src="images/arrow_top.png"/> <a onclick="" href="#">Choose Image</a></td></tr>
</table>
</div>
<div class="block" id="attrsDiv" name="attrsDiv">
Attributes of the item:</br>
<table id="attrTable" name="attrTable" width="100%">
<thead><th width="10%">Del</th><th align="right" width="40%">Attribute</th><th align="left" width="40%">Attribue Value</th></thead>

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
<button style="background-image:url(images/bg1.gif);" onclick="addItem()">Add Item</button>
</form>
</body>