<?php
/*
 * Created on 30-Jan-09
 *	Log in page ****** :)
 *
 */
 include 'Services/LoginServices.php';
 $status = "";
 $action = $_REQUEST['action'];
 if($action == "login"){
 	$status = loginUser();
	if($status == "logged"){
		//var_dump($_SESSION["userBean"]);
		$userBean = $_SESSION["userBean"];
		//var_dump($userBean);
		echo "<div class='successMsgBlock' style='width:400px'>";
		echo "Welcome ".$userBean['firstname']."! You have successfully Logged.</div>";
	}
	if($status == "failed"){
		//echo "failed to log";
		echo "<div class='failMsgBlock' style='width:400px'>";
		echo "Incorrect username and/or password. Please try again.</div>";
	}  
 }
?>
<style>
.buttonblock{
	border-color:#C7DA8B;  
	margin-left:4px;
	margin-right:4px;
	margin-top:4px;
	margin-bottom:4px; 
	border-style: solid; 
	border-width:thin;
	padding = 4px 4px 4px 4px;
	background-color = "#FF7F2A";
	font-family:Verdana;
	font-size:12px;
	cursor:hand;
}

.loginblock{
	border-color:#F5BF9C;  
	margin-left:4px;
	margin-right:4px;
	margin-top:4px;
	margin-bottom:4px; 
	border-style: solid; 
	border-width:thin;
	padding = 4px 4px 4px 4px;
	background-color = "#528CD9";
	font-family:Verdana;
	font-size:12px;
}

.failMsgBlock{
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
.successMsgBlock{
	border-color:#F5BF9C;  
	margin-left:4px;
	margin-right:4px;
	margin-top:4px;
	margin-bottom:4px; 
	border-style: solid; 
	border-width:thin;
	padding = 4px 4px 4px 4px;
	background-color = "#CD8BEF";
	font-family:Verdana;
	font-size:12px;
}

.textuserscreen{
	font-family:Verdana;
	font-size:12px;
}	

</style>
<script language= "javascript">
function login(){
 var form =  document.getElementById("loginForm");
 form.submit();
} 
</script>


<form id="loginForm" method="post" action="login.php?action=login">
<img src="images/keys.gif"/>
<div class="loginBlock" style="width:400px">

<table widht="100%" border=0>
<tr><td class="textuserscreen">User Name:</td><td><input type="text" maxlength=15 style="width:200px;" id="userid" name="userid" /></td></tr>
<tr><td class="textuserscreen">Password:</td><td><input type="password" maxlength=10 style="width:200px;" id="password" name="password" /></td></tr>
</table>
<table widht="100%" border="0"><tr>
<td class="buttonblock" onclick ="login();" width="20%" aligh="left"><b>Login</b>&nbsp;</td>
<td class="buttonblock" width="33%">ForgetPassword</td>
<td class="buttonblock" align="right" width="33%">Change password</td>
</tr>
</table>
</div>
<br>
<div class="loginBlock" style="width:400px">
New user? Register <a href="#" style="color:red;">here.</a>
</div>
</form>