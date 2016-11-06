function newXmlHttp(){
var xmlhttp = false;

  try{
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  }catch(e){
	  try{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	  }catch(e){
		xmlhttp = false;
	  }
  }

  if(!xmlhttp && document.createElement){
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}

function check_name(nick, Mode) {
  var cancle=false;
    if (nick.length==0) {
      alert('กรุณาป้อนชื่อก่อน');
      document.frm.nick.focus(); 
      cancle=true;
    }
  
  if (cancle==false) {
    doCheckName(Mode);		
  }
  return false;
}

function doCheckName(Mode) {

  var radField = document.frm.psn; 
  var radLength = document.frm.psn.length; 

  for (var i=0; i<radLength; i++) { 
    if (radField[i].checked) { 
      var chkpsn = radField[i].value; 
      continue; 
    } 
  } 
  	
  var url = 'chat.php';
  var pmeters = "unick=" + encodeURI( document.getElementById("nick").value ) +
    "&upsn=" + chkpsn +
    "&aMode=" + Mode ;	
  xmlhttp = newXmlHttp();
  xmlhttp.open('POST',url,true);

  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.setRequestHeader("Content-length", pmeters.length);
  xmlhttp.setRequestHeader("Connection", "close");
  xmlhttp.send(pmeters);
				
  xmlhttp.onreadystatechange = function(){

    if(xmlhttp.readyState == 3)  {
      document.getElementById("msg").innerHTML = "Now is Loading...";
    }

    if(xmlhttp.readyState == 4) {
		if(xmlhttp.responseText=='Y') {
			window.location.href="chatroom.php";
		} else {
      document.getElementById("msg").innerHTML = xmlhttp.responseText;
		}
    }
				
  }	

}

function doShowChatter(Mode) {
	
  var url = 'show_chatter.php';
  var pmeters = "aMode=" + Mode ;
  xmlhttp = newXmlHttp();
  xmlhttp.open('POST',url,true);

  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.setRequestHeader("Content-length", pmeters.length);
  xmlhttp.setRequestHeader("Connection", "close");
  xmlhttp.send(pmeters);
				
  xmlhttp.onreadystatechange = function()  {

    if(xmlhttp.readyState == 3)      {
      document.getElementById("chatter").innerHTML = "Now is Loading...";
    }

    if(xmlhttp.readyState == 4)     {
      document.getElementById("chatter").innerHTML = xmlhttp.responseText;				   			  
    }
				
  }
}

function check_data(msg, Mode) {
  var cancle=false;
    if (msg.length==0) {
      alert('กรุณาป้อนข้อความก่อน') ;
      document.frm.message.focus(); 
      cancle=true;
    }
  
  if (cancle==false) {
    doChat(Mode);
  }
  return false;
}

function doChat(Mode) {
	
  var radField = document.frm.color; 
  var radLength = document.frm.color.length; 

  for (var i=0; i<radLength; i++) { 
    if (radField[i].checked) { 
      var chkColor = radField[i].value; 
      continue; 
    } 
  } 
	
  var url = 'show_message.php';
  var pmeters = "uchatname=" + encodeURI( document.getElementById("chatname").value ) +
    "&umsg=" + encodeURI( document.getElementById("message").value ) +
    "&ucolor=" + chkColor +						
    "&aMode=" + Mode ;
  xmlhttp = newXmlHttp();
  xmlhttp.open('POST',url,true);

  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.setRequestHeader("Content-length", pmeters.length);
  xmlhttp.setRequestHeader("Connection", "close");
  xmlhttp.send(pmeters);
				
  xmlhttp.onreadystatechange = function()  {
    if(xmlhttp.readyState == 4)     {
      document.getElementById("message").value = '';	
      document.getElementById("color").value = '';					   			  
    }
				
  }	

}

function doShowMsg(Mode) {
	
  var url = 'show_message.php';
  var pmeters = "aMode=" + Mode ;
  xmlhttp = newXmlHttp();
  xmlhttp.open('POST',url,true);

  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.setRequestHeader("Content-length", pmeters.length);
  xmlhttp.setRequestHeader("Connection", "close");
  xmlhttp.send(pmeters);
				
  xmlhttp.onreadystatechange = function()  {

    if(xmlhttp.readyState == 3)      {
      document.getElementById("msg").innerHTML = "Now is Loading...";
    }

    if(xmlhttp.readyState == 4)     {
      document.getElementById("msg").innerHTML = xmlhttp.responseText;				   			  
    }
				
  }	

}

function doExit(name) {
	
  var url = 'exitroom.php';
  var pmeters = "user=" + name ;
  xmlhttp = newXmlHttp();
  xmlhttp.open('POST',url,true);

  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.setRequestHeader("Content-length", pmeters.length);
  xmlhttp.setRequestHeader("Connection", "close");
  xmlhttp.send(pmeters);
				
  xmlhttp.onreadystatechange = function()  {

    if(xmlhttp.readyState == 3)      {
      document.getElementById("msg").innerHTML = "Now is Loading...";
    }

    if(xmlhttp.readyState == 4)     {
		window.location.href="index.php";
    }
				
  }	

}