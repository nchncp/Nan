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
<title>signup</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/index-theme.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery/js/jquery-1.9.1.js"></script> 
<script type="text/javascript" src="jquery/js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="script/JSVerify.js"> </script>
<script type="text/javascript">
$(document).ready(function() { 
	//default
	document.getElementById("trMsg").hidden = true;
});

function clickSignUp(){

	if(chkUsername() == false) return false;
	if(chkPassword() == false) return false;
	if(chkRePassword() == false) return false;
	if(chkEmail() == false) return false;
	
	document.getElementById("trMsg").hidden = true;
	var filename = document.getElementById("hidFilename").value;
	$.ajax({
		type: "POST",
		url: getContextPath() + "PHPScript/signupConn.php",
		data: $("#frmSignup" ).serialize(),
		success: function(data){
			$('#divShowData').html(data);
			
			var strMsg = document.getElementById("hidMsg").value;

			if(strMsg != "" && strMsg != "finished"){
				document.getElementById("trMsg").hidden = false;
				document.getElementById("spanMsg").innerHTML = strMsg;
				
			}else if(strMsg == "finished"){
				window.location.href = 'login.php?f='+filename;
			}
		},
		error:function(){
			alert("Error to signup !!!");
		}
	});
	
}// END clickSignUp()
</script>

</head>

<body>
 	<table align="center" id="tbSignUp" border="0px" cellpadding="0px" cellspacing="0px" class="HomeCSS">
    	<form name="frmSignup" id="frmSignup" >
            <tr>
                <td style="background-color:#E6E6E6;height:60px;">
                    <input type="hidden" id="hidFilename" name="hidFilename" value="<?=$filename ?>" >
                </td>  
       		</tr>
     	 	<tr><td colspan="2" class="topic">
            	<img src="images/logo_web.png" style="position:absolute;padding:0;margin-top:5px;margin-left:60px;" />
                <p style="alignment-adjust:central;">SIGN UP</p>
            </td>
            </tr>
            <tr><td height="10" ></td></tr>  
            <tr>
                <td align="center">
                    <input type="text" name="txtUsername" id="txtUsername" maxlength="10" placeholder="Username" value="">
                </td>
            </tr>  
            <tr><td height="5" ></td></tr>
            <tr>
                <td align="center">
                    <input type="password" name="txtPassword"  id="txtPassword" maxlength="6" 
                    	placeholder="Password must be 4-6 numeric characters" value="" >
                </td>
            </tr>
             <tr><td height="5" ></td></tr>
            <tr>
                <td align="center">
                    <input type="password" name="txtRePassword"  id="txtRePassword" maxlength="6" 
                    	placeholder="Confirm Password" value="">
                </td>
            </tr>
            <tr><td height="5" ></td></tr>
            <tr>
                <td align="center">
                    <input type="text" name="txtEmail" id="txtEmail" 
                    	placeholder="E-mail: example@domain.com" style="text-transform:none;" value="">
                </td>
            </tr>
            <tr><td height="5" ></td></tr>     
            <tr id="trMsg">
            <td align="center" colspan="2" height="15"> 
                  <span id="spanMsg" class="error"> </span>
            </td>
        	</tr>
            <tr><td height="5" ></td></tr>       
            <tr>
                 <td colspan="2" align="center">
                 	<input type="button" name="btnSignup" id="btnSignup" value="SIGN UP" onClick="clickSignUp();">
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
