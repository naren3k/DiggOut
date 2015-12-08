<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	   

<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<!--
 * Created on 28-Nov-08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
-->
<?php
	include 'Services/DBServices.php';
	include 'Services/GeneralServices.php';
	include 'Services/UserRegService.php';
	 
	$allCountries = getCountries();
	$action = $_REQUEST['action'];
	$status = "";
	if($action == "regUser"){
		$user_id = $_REQUEST['userId'];
 		$user_name = $_REQUEST['userName'];;
 		$user_lstname = $_REQUEST['userLstName'];;
 		$password = $_REQUEST['Password'];;
 		$user_dob = $_REQUEST['userdob']; ;//= new date("F j, Y, g:i a");
 		$user_addr1 = $_REQUEST['useraddr1'];;
 		$user_addr2 = $_REQUEST['useraddr2'];;
 		$user_city_id = $_REQUEST['city'];;
 		$user_country_id = $_REQUEST['country'];;
		//var $user_langugage_id;
		$user_email = $_REQUEST['useremail'];;
		$user_email2 = $_REQUEST['useremail1'];;
		$user_company = $_REQUEST['user'];
		if(1==0||checkUserId($user_id) >= 1  ){
			echo checkUserId($user_id);
			$status = "dupUserId";
		}else{
			addUser();
		}
		
	}
	
	
	
	
?>
 <head>
 <style>
 .userFormBlock{
	border-color:#F5BF9C;  
	margin-left:4px;
	margin-right:4px;
	margin-top:4px;
	margin-bottom:4px; 
	border-style: solid; 
	border-width:thin;
	padding = 4px 4px 4px 4px;
	/*background-color = "#F5BF9C";*/
	font-family:Verdana;
	font-size : 14px;
}
 .userFormBlock1{
	border-color:#C7DA8B;  
	margin-left:4px;
	margin-right:4px;
	margin-top:4px;
	margin-bottom:4px; 
	border-style: solid; 
	border-width:thin;
	padding = 4px 4px 4px 4px;
	/*background-color = "#F5BF9C";*/
	font-family:Verdana;
	font-size : 14px;
}
.userRegHeader{
	font-family:Verdana;
	font-size:24px;
	color:#333366;
}
 </style>
  <title> </title>
  <script language="JavaScript" type="text/javascript" src="JS/JSUtils.js"></script>
  <script LANGUAGE="javascript">
  
  
  var xmlHttpReq;
  
	function countryChange(){
		var country = document.getElementById("country").value;
		var url = "Services/GeneralServices.php?action=getStates&country="+country;
  		
  		makeAjaxCall(url,"buildStates","GET");
  		
  		/*var country = document.getElementById("country").value;
  		
		xmlHttpReq = new ActiveXObject("Msxml2.XMLHTTP");
		if(xmlHttpReq != null){
    		var url = "Services/GeneralServices.php?action=getStates&country="+country;
 			xmlHttpReq.onreadystatechange = processResponse;
			xmlHttpReq.open("GET",url,true);
			xmlHttpReq.send(null);
		}*/
  	}
  
  
  function buildStates(){
  	alert(ajaxResopnseText);
  	
  }
  
	function processResponse(){
		if(xmlHttpReq.readystate == 4){
  	 		responseText = xmlHttpReq.responseText;
  	 		alert(responseText);
  	 		document.getElementById("state").disabled="";
  	 		addToList("state",responseText);
		}	
	}
	
	function addToList(comp,values){
		var allStates = values.split('-');
		var i;
		var listObj = document.getElementById(comp);
		while (listObj.options.length) {
			listObj.options.remove(0);
		}
		for(i=1;i<allStates.length;i++){
			newOpt = document.createElement("OPTION");
			newOpt.text = allStates[i];
			newOpt.value = allStates[i];
			listObj.options[i-1].value=allStates[i];
			listObj.options[i-1].text=
			listObj.add(newOpt);
			
		}		
	}
	
function hideallStatus(){
	document.getElementById('userIdc').style.display = "none";
	document.getElementById('userIdw').style.display = "none";
	
	document.getElementById('passwordc').style.display = "none";
	document.getElementById('passwordw').style.display = "none";
	
	document.getElementById('userNamec').style.display = "none";
	document.getElementById('userNamew').style.display = "none";

	document.getElementById('userLstNamec').style.display = "none";
	document.getElementById('userLstNamew').style.display = "none";
	
	document.getElementById('userdobc').style.display = "none";
	document.getElementById('userdobw').style.display = "none";
	
	document.getElementById('useraddr1c').style.display = "none";
	document.getElementById('useraddr1w').style.display = "none";
	
	document.getElementById('useraddr2c').style.display = "none";
	document.getElementById('useraddr2w').style.display = "none";
	
	document.getElementById('countryc').style.display = "none";
	document.getElementById('countryw').style.display = "none";
	
	document.getElementById('statec').style.display = "none";
	document.getElementById('statew').style.display = "none";
	
	document.getElementById('useremailc').style.display = "none";
	document.getElementById('useremailw').style.display = "none";
	
	document.getElementById('useremailc').style.display = "none";
	document.getElementById('useremailw').style.display = "none";

	document.getElementById('useremailc').style.display = "none";
	document.getElementById('useremailw').style.display = "none";
	
}	
function regUser(){
	hideallStatus();
	var userid = document.getElementById('userId').value;
	var pw =  document.getElementById('password').value;
	var userName =  document.getElementById('userName').value;
	var userLstName =  document.getElementById('userLstName').value;
	var userdob =  document.getElementById('userdob').value;
	var useraddr1 = document.getElementById('useraddr1').value;
	var useraddr2 = document.getElementById('useraddr2').value;
	var country = document.getElementById('country').value;
	var state = document.getElementById('state').value;
	var useremail = document.getElementById('useremail').value;
	var useremail1 = document.getElementById('useremail1').value;
	var fail = 0;
	
	if(userid == ""){
		document.getElementById('userIdw').style.display = "";
		fail = 1;
	}else{
		document.getElementById('userIdc').style.display = "";
	}
	if(pw == ""){
		document.getElementById('passwordw').style.display = "";
		fail = 1;		
	}else{
		document.getElementById('passwordc').style.display = "";
	}
	if(userName == ""){
		document.getElementById('userNamew').style.display = "";
		fail = 1;		
	}else{
		document.getElementById('userNamec').style.display = "";		
	}
	if(userdob == ""){
		document.getElementById('userdobw').style.display = "";
	}else{
		document.getElementById('userdobc').style.display = "";
	}
	if(useraddr1 == ""){
		document.getElementById('useraddr1w').style.display = "";
		fail = 1;		
	}else{
		document.getElementById('useraddr1c').style.display = "";
	}
	if(useraddr2 == ""){
		document.getElementById('useraddr2w').style.display = "";
		fail = 1;
	}else{
		document.getElementById('useraddr2c').style.display = "";		
	}
	if(state == ""){
		document.getElementById('statew').style.display = "";
		fail = 1;
	}else{
		document.getElementById('statec').style.display = "";		
	}
	if(country == ""){
		document.getElementById('countryw').style.display = "";
		fail = 1;
	}else{
		document.getElementById('countryc').style.display = "";		
	}
	if(useremail == ""){
		document.getElementById('useremailw').style.display = "";
		fail = 1;
	}else{
		document.getElementById('useremailc').style.display = "";		
	}
	if(useremail1 == ""){
		document.getElementById('useremail1w').style.display = "";
		fail = 1;
	}else{
		document.getElementById('useremail1c').style.display = "";		
	}

	
	if(1== 1){
		var form = document.getElementById('userRegForm');
		form.action = "UserReg.php?action=regUser";
		form.submit();
	}


}
  
  
 function photoChanged(){
 	var fileSrc = document.getElementById("userimageFile").value;
 	alert(fileSrc);
 	
 }
  
  </script>
  </head>
 <body>
 <form enctype="multipart/form-data" id="userRegForm" name="userRegForm" action ="UserRegService.php" method="post">
 	<table border="0" width="600px" align="center" >
 		<tr><td class="userRegHeader" align="left "> <img src="imgs/users/Dummy_user_small.png"/> User Registration</td></tr>
 	</table>
 	<?
 	if($status == "dupUserId"){
 		echo "<table border='0' width='600px' align='center' >";
 		echo"	<tr><td class='userFormBlock' align='left'>Choosen user id already exists. Please choose other. </td></tr>";
 		echo "</table>";
 	}
 	?>
	<table border="0" width="600px" align="center" >
		<tr>
			<td class="userFormBlock" width="40%" >User ID:</td>
			<td class="userFormBlock1" width="50%" >
				<input type="text" id="userId" name="userId" maxlength="10" style="width: 200px;" value="<? echo $user_id?>" />   
			</td>
			<td width="10%" ><img id="userIdc" style="display:none" src="images/tick_icon_16.gif"><img id="userIdw" style="display:none" src="images/del_icon_16.gif"></td>						
		</tr>
		<tr>
			<td class="userFormBlock" width="40%" >Password:</td>
			<td class="userFormBlock1" width="50%" >
				<input type="text" id="Password" name="Password" maxlength="10" style="width: 200px;" />   
			</td>
			<td width="10%" ><img id="Passwordc" style="display:none" src="images/tick_icon_16.gif"><img id="Passwordw" style="display:none" src="images/del_icon_16.gif"></td>						
		</tr>
		<tr>
			<td width="40%" class="userFormBlock" >First Name:</td>
			<td width="50%" class="userFormBlock1">
				<input type="text" id="userName" name="userName" maxlength="20" value="<? echo $user_name?>" style="width: 200px;" />   
			</td>			
			<td width="10%" ><img id="userNamec" style="display:none" src="images/tick_icon_16.gif"><img id="userNamew" style="display:none" src="images/del_icon_16.gif"></td>
		</tr>
		<tr>
			<td width="40%" class="userFormBlock" >Last Name:</td>
			<td width="50%" class="userFormBlock1">
				<input type="text" id="userLstName" name="userLstName" maxlength="20" value="<? echo $user_lstname?>" style="width: 200px;" />   
			</td>			
			<td width="10%" ><img id="userLstNamec" style="display:none" src="images/tick_icon_16.gif"><img id="userlstNamew" style="display:none" src="images/del_icon_16.gif"></td>
		</tr>
		
		
		
		
		<tr>
			<td width="40%" class="userFormBlock">Date of Birth:</td>
			<td width="50%" class="userFormBlock1">
				<input type="text" id="userdob" name="userdob" maxlength="156 value="<? echo $user_dob?>"   style="width: 200px;" />   
			</td>			
			<td width="10%" ><img id="userdobc" style="display:none" src="images/tick_icon_16.gif"><img id="userdobw" style="display:none" src="images/del_icon_16.gif"></td>			
		</tr>				
		<tr>
			<td width="40%" class="userFormBlock">Address Line1:</td>
			<td width="50%" class="userFormBlock1">
				<input type="text" id="useraddr1" name="useraddr1" maxlength="40"  value="<? echo $user_addr1?>" style="width: 200px;" />   
			</td>			
			<td width="10%" ><img id="useraddr1c" style="display:none" src="images/tick_icon_16.gif"><img id="useraddr1w" style="display:none" src="images/del_icon_16.gif"></td>			
		</tr>				
		<tr>
			<td width="40%" class="userFormBlock">Address Line2:</td>
			<td width="50%" class="userFormBlock1">
				<input type="text" id="useraddr2" name="useraddr2" maxlength="40" value="<? echo $user_addr2?>"  style="width: 200px;" />   
			</td>			
			<td width="10%" ><img id="useraddr2c" style="display:none" src="images/tick_icon_16.gif"><img id="useraddr2w" style="display:none" src="images/del_icon_16.gif"></td>			
		</tr>				
		<tr>
			<td width="40%" class="userFormBlock">City:</td>
			<td width="50%" class="userFormBlock1">
				<input type="text" id="city" name="city" maxlength="16" value="<? echo $user_city?>" style="width: 200px;" />   
			</td>			
			<td width="10%" ><img id="cityc" style="display:none" src="images/tick_icon_16.gif"><img id="cityw" style="display:none" src="images/del_icon_16.gif"></td>			
		</tr>				
		<tr>
			<td width="40%" class="userFormBlock">Country:</td>
			<td width="50%" class="userFormBlock1">
				<select name="country" id="country" size="1" style="width: 200px;" onchange="countryChange();" >
				<?php
					$country;
					//$itr = $allCountries->getIterator();
					foreach ($allCountries as &$country){
						//$country = $itr->current();
						echo "<option value=".$country.">".$country."</option>";
					}
				?>
				
				</select>
			</td>			
			<td width="10%" ><img id="countryc" style="display:none" src="images/tick_icon_16.gif"><img id="countryw" style="display:none" src="images/del_icon_16.gif"></td>			
		</tr>	
		<tr>
			<td width="40%" class="userFormBlock">State</td>
			<td width="50%" class="userFormBlock1">
				<select name="state" id="state" disabled="disabled" size="1" style="width: 200px;" >
				</select>
			</td>			
			<td width="10%" ><img id="statec" style="display:none" src="images/tick_icon_16.gif"><img id="statew" style="display:none" src="images/del_icon_16.gif"></td>			
		</tr>			
		
					
		<tr>
			<td width="40%" class="userFormBlock">Email</td>
			<td width="50%" class="userFormBlock1">
				<input type="text" id="useremail" name="useremail" maxlength="200" value="<? echo $user_email?>" style="width: 200px;" />   
			</td>			
			<td width="10%" ><img id="useremailc" style="display:none" src="images/tick_icon_16.gif"><img id="useremailw" style="display:none" src="images/del_icon_16.gif"></td>			
		</tr>				
		<tr>
			<td width="40%" class="userFormBlock">Email (alt) :</td>
			<td width="50%" class="userFormBlock1">
				<input type="text" id="useremail1" name="useremail1" value="<? echo $user_email2?>" maxlength="10" style="width: 200px;" />   
			</td>			
			<td width="10%" ><img id="useremail1c" style="display:none" src="images/tick_icon_16.gif"><img id="useremail1w" style="display:none" src="images/del_icon_16.gif"></td>			
		</tr>										
	</table>
	
	<table border="0" width="600px" align="center" >
 		<tr> 
 			<td align="right" width="30%" class="userFormBlock">Photo<img id="userImage" name="userImage" height='50px' width='50px' src="images/misc_bg.gif" alt="user image" /> </td>
 			<td align="left" class="userFormBlock1"><input onchange="photoChanged();" class="userFormBlock1" type="file" id="userImageFile" name="userImageFile"/></td>
 		</tr>
 	</table>
	
	<table border="0" width="600px" align="center" >
 		<tr>
 			<td align="right"><input class="userFormBlock" type="button"  onclick ="regUser()" value="Submit"/></td>
 			<td align="left"><input class="userFormBlock1" type="reset" value="Reset"/></td>
 		</tr>
 	</table>
 	

 	
 	
 </form>	 
 </body>
</html>
