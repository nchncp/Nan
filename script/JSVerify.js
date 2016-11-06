/**
 * returns the current context path,
 * ex: http://localhost:8080/MyApp/Controller returns /MyApp/
 * ex: http://localhost:8080/MyApp returns /MyApp/
 * ex: https://www.example.co.za/ returns /
 */
 
 var $data = new Array();
 
/*function getContextPath() {
    var ctx = window.location.pathname,
        path = '/' !== ctx ? ctx.substring(0, ctx.indexOf('/', 1) + 1) : ctx;
    return path + (/\/$/.test(path) ? '' : '/');
}*/

function GetXmlHttpObject()	{
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject) {
		// code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}// END GetXmlHttpObject()


/*function resetMsgError(){
	document.getElementById("trMsg").hidden = true;
	document.getElementById("spanMsg").innerHTML = "";	
	
}// END resetMsgError()*/

/*function chkUsername(){
	if( $_SESSION['sess_username'] == "" ){
		document.getElementById("$_SESSION['sess_username']").focus();
		document.getElementById("trMsg").hidden = false;
		document.getElementById("spanMsg").innerHTML = "Please enter username !";
		return false;
	}
	return true;	
}//END chkUsername()*/

function chkPassword(){
	
	if( document.getElementById("password").value == "" ){
		document.getElementById("password").focus();
		document.getElementById("trMsg").hidden = false;
		document.getElementById("spanMsg").innerHTML = "Please enter password !";
		return false;
		
	}
	/*
	else if(document.getElementById("password").value != "" && 
		     document.getElementById("password").value.length < 4 
			 
	){
		
		document.getElementById("password").focus();
		document.getElementById("trMsg").hidden = false;
		document.getElementById("spanMsg").innerHTML = "Please enter password 4-6 characters long !!!";
		return false;
	}
	*/
	return true;	
}//END chkPassword()

function chkRePassword(){
	if( document.getElementById("txtRePassword").value == "" )
	{
		document.getElementById("txtRePassword").focus();
		document.getElementById("trMsg").hidden = false;
		document.getElementById("spanMsg").innerHTML = "Please enter confirm password !";
		return false;
		
	}else if(document.getElementById("txtRePassword").value != "" && 
			 document.getElementById("password").value.length < 4 
			 
	){
		document.getElementById("txtRePassword").focus();
		document.getElementById("trMsg").hidden = false;
		document.getElementById("spanMsg").innerHTML = "Please enter password 4-6 characters long !";
		return false;
		
	}else if(document.getElementById("password").value != ""		&&
			 document.getElementById("txtRePassword").value != ""	&&
			 document.getElementById("password").value != document.getElementById("txtRePassword").value 
		){
			
		document.getElementById("txtRePassword").focus();
		document.getElementById("trMsg").hidden = false;
		document.getElementById("spanMsg").innerHTML = "Password mismatch !";
		return false;
	}
	
	return true;	
}//END chkRePassword()

function chkEmail(){
	/*
	if( document.getElementById("email").value == "" ){
		document.getElementById("email").focus();
		document.getElementById("trMsg").hidden = false;
		document.getElementById("spanMsg").innerHTML = "Please enter E-mail address.";
		return false;
		
	}
	*/
	if(document.getElementById("email").value != ""){
		
		var x=document.getElementById("email").value;
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
		
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){
			document.getElementById("email").focus();
			document.getElementById("trMsg").hidden = false;
			document.getElementById("spanMsg").innerHTML = "Invalid E-mail address !";
			return false;
		}
	}
	
	return true;
		
}//END chkEmail()

function chkRoom(){
	var btnLoginVal = document.getElementById("btnLogin").value;
	
	if(btnLoginVal == "PRESENT"){
		if( document.getElementById("room_name").value == "" ){
			document.getElementById("room_name").focus();
			document.getElementById("trMsg").hidden = false;
			document.getElementById("spanMsg").innerHTML = "Please enter room name.";
			return false;
		}//END if room_name = ''
	}else{
		if( document.getElementById("selPresentationRoom").value == "" ){
			document.getElementById("selPresentationRoom").focus();
			document.getElementById("trMsg").hidden = false;
			document.getElementById("spanMsg").innerHTML = "Please select presentation room.";
			return false;
		}//END if room_name = ''
	}
	
	return true;	
}//END chkRoom()

function chgPresentationRoom(){
	var btnLoginVal = document.getElementById("btnLogin").value;
	
	if(btnLoginVal == "VIEW" && 
	   document.getElementById("selPresentationRoom").value != "")
	{
		chkError();
	}//END Viewer
		
}//END chkError()

function chkError(){
	var user = json_encode($_SESSION['sess_username']);
    var pwd = json_encode($_SESSION['sess_password']);
    var room = json_encode($_SESSION['sess_room_name']);
    var room_code =json_encode($_SESSION['sess_password_room']);
    var selRoom = document.getElementById("selPresentationRoom").value;
    var action = document.getElementById("hidAction").value;

	/*var user = document.getElementById("username").value;
	var pwd = document.getElementById("password").value;
	var room = document.getElementById("room_name").value;
	var room_code = document.getElementById("password_room").value;
	var filename = document.getElementById("hidFilename").value;
	var selRoom = document.getElementById("selPresentationRoom").value;
	var action = document.getElementById("hidAction").value;*/
	$.ajax({
		type: "POST",
		/*url: getContextPath() + "PHPScript/loginconn.php",*/
		url: "Controller/userController.php",
		data: { sess_username: user,
                sess_password: pwd ,
                sess_room_name: room,
                sess_password_room: room_code,
                /*sess_hidFilename:filename,*/
                sess_selPresentationRoom: selRoom,
                sess_hidAction: action  					
		},
		success: function(data){
			
			$('#divShowData').html(data);
			var strMsg = document.getElementById("hidMsg").value;
			var strRoomCode = document.getElementById("hidRoomCode").value;
						
			if(document.getElementById("btnLogin").value == "VIEW"){
				if(strRoomCode != ""){//private room
					document.getElementById("password_room").hidden = false;
				}else{//public room
					document.getElementById("password_room").value = "";
					document.getElementById("password_room").hidden = true;
				}
			}//END if user = viewer
				
			if(strMsg != "" && strMsg != "finished"){
				document.getElementById("trMsg").hidden = false;
				document.getElementById("spanMsg").innerHTML = strMsg;
			}
		},
		error:function(){
			//alert("Error to login !!!");
		}
	});
}//END mainChkError()
function chkRoomCode(){
	var btnLoginVal = document.getElementById("btnLogin").value;
	if(btnLoginVal == "PRESENT"){
		if( document.getElementById("password_room").value == "" && 
	   		document.getElementById("chkRoomCode").checked == true )
		{
			document.getElementById("password_room").focus();
			document.getElementById("trMsg").hidden = false;
			document.getElementById("spanMsg").innerHTML = "Please enter room code.";
			return false;
		}
	}//END Presenter
	
	return true;
	
}//END chkRoomCode()

function clickChkRoomCode(){
	
	if(document.getElementById("chkRoomCode").checked == true){ //checked
		document.getElementById("password_room").value = "";
		document.getElementById("password_room").hidden = false;
		
	}else{//unchecked
		document.getElementById("password_room").hidden = true;
		
	}
}//END clickChkRoom()



