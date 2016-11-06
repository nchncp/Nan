<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script type="text/javascript" src="jquery/js/jquery-1.9.1.js"></script> 
<script type="text/javascript" src="script/JSCommFunc.js"></script> 
<script type="text/javascript" src="script/JSVerify.js"></script> 
</head>
<script type="text/javascript">
$( document ).ready(function() {
	
convertImgToCanvas('images_annotation/PORNCHAI_PageNo9.png');
	/*
	var inShow = setInterval(function() {
		showNotePresenter();	
	}, 500);
	*/	
}); // END onReady() function

function convertImgToCanvas(srcImg) {
	// create hidden canvas (using image dimensions)
	 var canvas = document.getElementById('myCanvas');
	 var context = canvas.getContext('2d');
	 //var imageObj = new Image();
	 //imageObj.src = srcImg;
	 //imageObj.onload = function() {
		//context.drawImage(imageObj, 0, 0);
	// };
	  //imageObj.src = srcImg;
	document.getElementById("pageContainer1").style.backgroundImage = "url(images_annotation/PORNCHAI_PageNo9.png)";

}//END convertImgToCanvas()
function showNotePresenter(){ //displayNoteImages

	var CurrentPageNo = "1";
	var RoomNo = "tea";
	var UserStatus = "P";
	var Username = "USER6";
	
	var btnPresent= "STOP";
	var isPresent = "N";
	if(btnPresent == "STOP"){
		isPresent = "Y";
	}else{
		isPresent = "N";
	}
	

	
	var idPageArea = "#pageContainer1"  ;
	var PresenterPageNo = "9";
	
	
			
	$.ajax({
		type: "POST",
		url: "PHPScript/ShowPresenterAnnotation.php",
		data: { txtPageNo: CurrentPageNo,
				txtUsername: Username,
				txtUserStatus: UserStatus,
				txtRoomNo: RoomNo,
				isPresent: isPresent,
				txtPresenterPageNo : PresenterPageNo

		},
		success: function(data){
			$('#spanShowNotePresenter').html(data);
			//convert string to array
			var strNoteName = document.getElementById("hidNoteName2").value;
			//console.log("showNoteImagesPresenter()-- ArrNoteName.length = "+ ArrNoteName.length + ", " + ArrNoteName.toString());
			
			var strOwnerNote = document.getElementById("hidOwnerNote2").value;
			//console.log("showNoteImages()-- ArrOwnerNote.length = "+ ArrOwnerNote.length + ", " + ArrOwnerNote.toString());
			
			var strUpdatedNoNew = document.getElementById("hidUpdatedNoNew2").value;
			
			//hidArrSourceImage
			var strSourceImage = document.getElementById("hidSourceImage2").value;
			//console.log("showNoteImages()-- ArrSourceImage.length = "+ ArrSourceImage.length + ", " + ArrSourceImage.toString());
			//===========================================================================
			// Example: <div id="divShowNoteUserUSER2_PageNo1"></div>
			var idDivShowNote = "testDivShowNoteUser" + Username + "_PageNo" + CurrentPageNo;
			$("#" + idDivShowNote).remove();
			// create note area to show
			var WidthPage = $(idPageArea).width();
			var HeightPage = $(idPageArea).height();
			
		
			$( idPageArea ).append('<div '
			+ 'id="'+ idDivShowNote +'" '
			+ 'style="width:' + WidthPage + 'px; ' 
			+ 'height:'+ HeightPage +'px; '
			+ 'z-index:200; position:absolute; top:0px; left:0px; right:0px; " > '
			+ '</div> '
			);// END ajax: append div tag
			//===========================================================================
			if(strNoteName != ""){
				console.log("showNotePresenter()---------------------START ------------------------------");
				console.log("showNotePresenter()-- IN : note=" +strNoteName
											+"| owner=" +strOwnerNote
											+"| source=" + strSourceImage
											+"| isPresent=" + isPresent
											+"| user=" + Username
											+"| id=" + idDivShowNote
											+"| w=" + WidthPage
											+"| h=" + HeightPage);		
				var d = Date.now();
				//var srcImage= ArrSourceImage[x]+"?time="+d;
				
				var srcImage = strSourceImage+"?foo="+d;
				console.log("showNotePresenter()-- srcImage = "+ srcImage);
			
				//Example: id = "imgUSER1_PageNo20"
				var idImgAnnotation = "img" + strNoteName.substr(0, strNoteName.length-4);
				var ImageNote2 = '<img id="'+idImgAnnotation+'" name="'+idImgAnnotation+'" src="'+srcImage+'" '
				+ 'style="width:' + WidthPage + 'px; ' 
				+ 'height:'+ HeightPage +'px; '
				+ 'z-index:9999; position:absolute; top:0px; left:0px; right:0px;" > ';
		
				console.log("showNotePresenter()-- idDivShowNote = "+ idDivShowNote);
				console.log("showNotePresenter()-- ImageNote = "+ ImageNote2);
				$( "#" + idDivShowNote ).append(ImageNote2);// END ajax: append image
				
					
			}//END if the number of note updated is valid
			else{
				console.log("showNotePresenter()-- else... data is blank.");
			}

		console.log("showNotePresenter() **************************   END   ******************************");			
			//===========================================================================				
		},

		error:function(){
			$("#spanMsgError").html("Error showNoteImagesPresenter() function !!!");
		}
	});//END ajax
	

}// END showNoteImagesPresenter()
function doCancel(){
	
	window.clearInterval(inShow);
}//END cancel()
</script>
<body>
<canvas id="myCanvas" width="578" height="400"></canvas>

<div id="pageContainer1" style="width:200px;height:200px;"></div>
<!-- 
<input type="button" id="btnAction" onClick="doCancel();" value="CLICK">
<div id="spanShowNotePresenter"></div>
<div id="spanMsgError"></div>
-->
</body>
</html>