<?php
/*
 * Created on 02-Feb-09
 * Google page :)
 */
 include 'Services/DBServices.php';
 include 'Services/Google.php';
 $action  = $_REQUEST['action'];
 $searchText = $_REQUEST['searxhText'];
 $srchStr = "";

?>
<style>
.searchBarBlock{
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
.searchButtonBlock{
	border-color:#FF7F2A;  
	margin-left:0px;
	margin-right:0px;
	margin-top:0px;
	margin-bottom:0px; 
	border-style: thin; 
	border-width:thin;
	padding = 0px 0px 0px 0px;
	background-color = "#CD8BEF";
	font-family:Verdana;
	cursor:hand;
}

.resultBlock{
	
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
.resItem{
	font-family:Verdana;
	font-size:16px;
}
.resclass{
	font-family:Verdana;
	font-size:15px;
}
.resDesc{
	font-family:Verdana;
	font-size:13px;
}
</style>
<script language="javascript">
function doSearch(){
	var srchTxt = document.getElementById("searchText").value;
	var url = "Search.php?action=doSearch&searxhText="+srchTxt;
	var form = document.getElementById("searchForm");
	form.action = url;
	form.submit();
}
</script>
<form id="searchForm" name="searchForm" method="post">
<div class="searchBarBlock"> 
<center>
<table><tr><td>
<input type="text" id="searchText" name="searchText" value="<?echo $searchText;?>" style="width:400px;"/>
</td><td onclick="doSearch()" class="searchButtonBlock">d i G G</td></table>
</center>
</div>

<?php
 if($action == 'doSearch'){
 	$srchStr = $_REQUEST['searxhText'];
 	$resultItems = doSearch($srchStr);
 	$i = 0;
 	while ($row = mysql_fetch_assoc($resultItems)){
 		$i++;
 		$itemDets = getItemDet($row['val']);
 		while ($itemRow = mysql_fetch_assoc($itemDets)){
 			echo "<table style='background-image:url(images/res_bg.gif)' class='resultBlock' width=100%>";
 			echo "<tr><td width='50px'><img src='images/no_item_img.gif'/>";
 			echo "</td><td>";
  			echo "<div class='resItem'>".$itemRow['prod_name']."</div>";
 			echo "<div class='resClass'>".$itemRow['class_name']."</div>";
 			echo "<p class='resDesc'>".$itemRow['prod_desc']."</div>";
 			echo "<div>".$itemRow['rating']."</div>";
 			echo "</td></tr></table>";
 		}
 	}	
 }
?>
</form>	