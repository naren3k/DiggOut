
/* AJAX UTILS -  NAREN */
var xmlHttpReq;
var ajaxResopnseText;
function makeAjaxCall(url,returnFunctionName,serverMethod){
		xmlHttpReq = new ActiveXObject("Msxml2.XMLHTTP");
		returnFun = returnFunctionName;
		if(xmlHttpReq != null){
 			xmlHttpReq.onreadystatechange = ajaxResponse;
			xmlHttpReq.open("GET",url,true);
			xmlHttpReq.send(null);
		}
}

function ajaxResponse(){
		if(xmlHttpReq.readystate == 4){
  	 		ajaxResopnseText = xmlHttpReq.responseText;
  	 		eval(returnFun+"()");
		}	
}
/* AJAX UTILS */
