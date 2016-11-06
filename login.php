<!DOCTYPE HTML>

<?php

if( !isset( $_GET['f'] ) ) $filename = "";
else $filename =  $_GET['f'];

if($filename == ""){
	$btnValue = "VIEW";
}else{
	$btnValue = "PRESENT";
}

?>


<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<title>login</title>
<script type="text/javascript" src="jquery/js/jquery-1.9.1.js"></script> 
<script type="text/javascript" src="jquery/js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="script/JSVerify.js"></script>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/index-theme.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
$( document ).ready(function() {
	// onload page 
	document.getElementById("trMsg").hidden = true;
	document.getElementById("hidAction").value = "";
	getListPresentationRoom();
	//Presenter
	if(document.getElementById("btnLogin").value == "PRESENT"){
		document.getElementById("txtRoomCode").hidden = false;
		$("#trPresenterRoom").show();
		$("#trViewerRoom").hide();
	}//END Presenter
	else{
		//Viewer
		document.getElementById("txtRoomCode").hidden = true;
		document.getElementById("trChkRoomCode").hidden = true;
		$("#trPresenterRoom").hide();
		$("#trViewerRoom").show();
	}//END Viewer
	
}); //END $( document ).ready(function() {

function clickButton(){
	if(chkUsername() == false) return false;
	if(chkPassword() == false) return false;
	if(chkRoom() == false) return false;
	if(chkRoomCode() == false) return false;
	document.getElementById("trMsg").hidden = true;
	document.getElementById("hidAction").value = "click";
	
	var user = document.getElementById("txtUsername").value;
	var pwd = document.getElementById("txtPassword").value;
	var room = document.getElementById("txtRoom").value;
	var room_code = document.getElementById("txtRoomCode").value;
	var filename = document.getElementById("hidFilename").value;
	var selRoom = document.getElementById("selPresentationRoom").value;
	var action = document.getElementById("hidAction").value;
	
	$.ajax({
		type: "POST",
		url: getContextPath() + "PHPScript/loginconn.php",
		data: { txtUsername: user,
				txtPassword: pwd ,
				txtRoom: room,
				txtRoomCode: room_code,
				hidFilename:filename,
				selPresentationRoom: selRoom,
				hidAction: action			
		},
		success: function(data){
			
			$('#divShowData').html(data);
			var strMsg = document.getElementById("hidMsg").value;
			
			if(strMsg != "" && strMsg != "finished"){
				document.getElementById("trMsg").hidden = false;
				document.getElementById("spanMsg").innerHTML = strMsg;

			}else if(strMsg == "finished"){
				window.location.href = 'vpresent.php';
			}
		},
		error:function(){
			console.log("login.php: Error to login !!!");
		}
	});
	
}// END clickPresent()


function getListPresentationRoom(){
		var url = getContextPath() + "PHPScript/ListPresentationRoomConn.php";

	  	var xmlhttp;
		if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		}else { // code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			 	$('#spanPresentationRoom').html(xmlhttp.responseText);
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.send();
}// END getListPresentationRoom()

</script>
</head>

<body>
<table align="center" id="tbLogin" border="0px" cellpadding="0px" cellspacing="0px" class="HomeCSS">
	
    <form name="frmLogin" id="frmLogin">	
     	<tr>
        	<td style="background-color:#E6E6E6;height:60px;"></td>  
        </tr>
        <tr><td colspan="2" class="topic" align="center">
                <img src="images/logo_web.png" style="position:absolute;padding:0;margin-top:5px;margin-left:60px;" />
                <p style="alignment-adjust:central;">LOG IN</p>
        	</td>  
        </tr>
        <tr><td height="10" ></td></tr>  
        <tr>
            <td align="center">
            	
            	<input type="hidden" id="hidFilename" name="hidFilename" value="<?=$filename ?>" >
                <input type="text" name="txtUsername" id="txtUsername" maxlength="10" placeholder="Username" 
                value="" onKeyPress="resetMsgError();"  >
            </td>
        </tr>
        <tr><td height="10" ></td></tr>  
        <tr>
            <td align="center">
                <input type="password" name="txtPassword"  id="txtPassword" maxlength="6" placeholder="Password" 
                value="" onKeyPress="resetMsgError();" >
            </td>
        </tr>
        <tr><td height="10" ></td></tr>
        <span id="spanPresenterTool">
            <tr>
                <td align="center" colspan="2" class="subtopic">Room Settings</td>
            </tr>
            <tr><td height="10" ></td></tr>
            <tr id="trPresenterRoom">
            	<td align="center">
                	<input type="text" name="txtRoom"  id="txtRoom" maxlength="10" placeholder="Room name" 
                    value="" onKeyPress="resetMsgError();" >
                </td>
            </tr>
            <tr id="trViewerRoom">
                <td align="center">
                	<span id="spanPresentationRoom">
                   	<select id="selPresentationRoom" name="selPresentationRoom" style="width:90%;" 
                    		onChange="chgPresentationRoom();">
                        <option value="">- Select presentation room -</option>
                    </select>
                    </span>
                </td>
            </tr>
            <tr><td height="10" ></td></tr>
             <tr id="trChkRoomCode">
                <td style="color:#993300;">&nbsp;&nbsp;
                    <input type="checkbox" id="chkRoomCode" name="chkRoomCode" checked
                    	style="margin-bottom:10px;" onClick="clickChkRoomCode();">&nbsp;&nbsp;Private Room
                </td>
            </tr>
            <tr>
                <td align="center">
                    <input type="text" name="txtRoomCode"  id="txtRoomCode" maxlength="5" placeholder="Room code e.g.,12345" 
                    value="" onKeyPress="resetMsgError();" >
                </td>
            </tr>
        </span>
       
        <tr id="trMsg">
            <td align="center" height="15" > 
                <span id="spanMsg" class="error"> </span>
            </td>
            <td height="5" ></td>
        </tr>  
        <tr><td height="10" ></td></tr>  
        <tr id="trBtnPresent">
             <td colspan="2" align="center">
                <input type="button" name="btnLogin" id="btnLogin" value="<?=$btnValue ?>" onClick="clickButton();">
                <input type="hidden" name="hidAction" id="hidAction" value="" >
             </td>
        </tr>
        <tr><td height="15" ></td></tr>
    </form>    
</table>
<table  align="center" id="tbHidden" border="0px" cellpadding="0px" cellspacing="0px">
    <tr>
        <td align="right" ><a href="signup.php?f=<?=$filename ?>" width="65%">Sign Up</a></td>
        <td align="right" width="40%"><a href="repassword.php?f=<?=$filename ?>">Forgot Password</a></td>
    </tr> 
</table>

<div id="divShowData"></div>


</body>
</html>
