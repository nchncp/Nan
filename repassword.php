<!DOCTYPE HTML>
<?php 

if( !isset( $_GET['f'] ) ) $filename = "";
else $filename =  trim($_GET['f']);
//echo "File = " . $filename;

?>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>repassword</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/index-theme.css" rel="stylesheet" type="text/css" />
<link href="jquery/css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery/js/jquery-1.9.1.js"></script> 
<script type="text/javascript" src="jquery/js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="script/JSVerify.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
	//default
	document.getElementById("trMsg").hidden = true;
});

function chkUsernameOrEmail(){
	if(document.getElementById("txtUsername").value != ""){
		document.getElementById("txtEmail").style.backgroundColor = "#D3D3D3";
		document.getElementById("txtEmail").value = "";
		document.getElementById("txtEmail").disabled = true;
		
	}else if(document.getElementById("txtEmail").value != ""){
		document.getElementById("txtUsername").style.backgroundColor = "#D3D3D3";
		document.getElementById("txtUsername").value = "";
		document.getElementById("txtUsername").disabled = true;
	}else{
		document.getElementById("txtUsername").style.backgroundColor = "white";
		document.getElementById("txtEmail").style.backgroundColor = "white";
		document.getElementById("txtUsername").disabled = false;
		document.getElementById("txtEmail").disabled = false;
	}
}// END chkUsernameOrEmail()

function clickConfirmBtn(){
	if(document.getElementById("txtUsername").value != "" && document.getElementById("txtEmail").value == ""){
		if(chkUsername() == false) return false;
		
	}else if(document.getElementById("txtUsername").value == "" && document.getElementById("txtEmail").value != ""){
		if(chkEmail() == false) return false;
		
	}else if(document.getElementById("txtUsername").value == "" && document.getElementById("txtEmail").value == ""){
		if(chkUsername() == false) return false;
	}
	
	if(chkPassword() == false) return false;
	if(chkRePassword() == false) return false;
	
	
	document.getElementById("trMsg").hidden = true;
	
	$.ajax({
		type: "POST",
		url: getContextPath() + "PHPScript/repasswordConn.php",
		data: $("#frmRePassword" ).serialize(),
		success: function(data){
			$('#divShowData').html(data);
			
			var strMsg = document.getElementById("hidMsg").value;

			var filename = document.getElementById("hidFilename").value;
			if(strMsg != "" && strMsg != "finished"){
				document.getElementById("trMsg").hidden = false;
				document.getElementById("spanMsg").innerHTML = strMsg;
				
			}else if(strMsg == "finished"){
				alert("Already change password !!!");
				window.location.href = 'login.php?f='+filename;
			}
		},
		error:function(){
			alert("Error to signup !!!");
		}
	});
	
}// END clickConfirmBtn()



</script>

</head>
<body>
<table align="center" id="tbRepassword" border="0px" cellpadding="0px" cellspacing="0px"  class="HomeCSS">
    <form name="frmRePassword" id="frmRePassword" >
    	<tr>
        	<td style="background-color:#E6E6E6;height:60px;"></td>  
            <input type="hidden" id="hidFilename" name="hidFilename" value="<?=$filename ?>" >
        </tr>
        <tr>
        	<td colspan="2" class="topic">
        	 <img src="images/logo_web.png" style="position:absolute;padding:0;margin-top:5px;margin-left:100px;" />
             <p style="alignment-adjust:central;">RE-PASSWORD</p>
       		</td>
        </tr>
        <tr><td height="20" align="center" style="font-size:small;font-weight:bold;color:#666;">Please enter username or E-mail only one.</td></tr>  
        <tr><td height="5" ></td></tr>
        <tr>
            <td align="center">
                <input type="text" name="txtUsername" id="txtUsername" maxlength="10" 
                	placeholder="Username" value="" onKeyUp="chkUsernameOrEmail();">
            </td>
        </tr>
		<tr><td height="5" ></td></tr>
        <tr>
            <td align="center">
                <input type="text" name="txtEmail" id="txtEmail" maxlength="45" placeholder="E-mail: example@domain.com" 
                style="text-transform:none;" value="" onKeyUp="chkUsernameOrEmail();">
            </td>
        </tr>
        <tr><td height="5" ></td></tr>
        <tr>
            <td align="center">
                <input type="password" name="txtPassword"  id="txtPassword" 
                	maxlength="6" placeholder="New Password" value="" >
            </td>
        </tr>
        <tr><td height="5" ></td></tr>
        <tr>
            <td align="center">
                <input type="password" name="txtRePassword"  id="txtRePassword" 
                	maxlength="6" placeholder="Confirm Password" value="" >
            </td>
        </tr>

        <tr id="trMsg">
            <td align="center" colspan="2" height="15"> 
                <span id="spanMsg" class="error"> </span>
            </td>
        </tr>      
        <tr><td height="5" ></td></tr>  
        <tr>
             <td colspan="2" align="center">
                <input type="button" name="btnConfirm" id="btnConfirm" value="CONFIRM" onClick="clickConfirmBtn();">
             </td>
        </tr>
        <tr><td height="10" ></td></tr>
     </form>     
</table>
<table  align="center" id="tbHidden" border="0px" cellpadding="0px" cellspacing="0px" width="400px">
        <tr>
            <td align="right" colspan="2">
                <a href="login.php?f=<?=$filename ?>" >Go to login page</a>
            </td>
        </tr> 
</table>

<div id="divShowData"></div>
</body>
</html>
