// JavaScript Document
function Logout(){
	window.clearInterval(inRecord);
	window.clearInterval(inListAnnotation);	
	window.clearInterval(inShowNote);

}//END Logout()
//========================================================================================================
function setParameter(){
	$("#divHead").scrollTop();
	$("#openFile").hide();
	$("#viewBookmark").hide();
	$("#firstPage").hide();
	$("#lastPage").hide();
	$("#pageRotateCw").hide();
	$("#pageRotateCcw").hide();
 	$("#print").hide();
	$("#presentationMode").hide();
	$("#download").hide();
	$("#viewThumbnail").hide();
	$("#viewOutline").hide();
	$("#sidebarContent").hide();
	
	$("#secondaryPresentationMode").hide();
	$("#secondaryOpenFile").hide();
	$("#secondaryPrint").hide();
	$("#secondaryViewBookmark").hide();
	$("#secondaryDownload").hide();
	
	//Scale PDF
	$("#scaleSelectContainer").hide();
	$("#zoomOut").hide();
	$("#zoomIn").hide();
	
	$("#divStopPresent").hide();
	
	$("#toolbarViewerMiddle").hide();
	
	if(document.getElementById("hidUserStatus").value == "P"){
		document.getElementById("txtBy").value = "Presented by ";
		$("#btnPresentStatus").hide();
	}else{
		document.getElementById("txtBy").value = "Viewed by ";
	}
} //END setParameter()
//========================================================================================================

function showNote(){ //displayNoteImages

	var CurrentPageNo = $("#pageNumber").val();
	var RoomNo = $("#txtRoomNo").val();
	var FileID = $("#hidFileid").val();
	var UserStatus = $("#hidUserStatus").val();
	var Username = $("#txtUsername").val();
	
	var btnPresent= $("#hidPresentStatus").val();
	var isPresent = "N";
	if(btnPresent == "STOP"){
		isPresent = "Y";
	}else{
		isPresent = "N";
	}
		
	//var TotalPageNo = $("#numPages").html().substring(3);
	//var total = parseInt(TotalPageNo, 10);
	var idPageArea = "#pageContainer" + CurrentPageNo;
	var PresenterPageNo = $("#hidPresenterPage").val(); //set value for vreak point // need to get true value 
	//$("#hidPresenterPage").val()

	$.ajax({
		type: "POST",
		url: "PHPScript/ShowAnnotationsImageConn.php",
		data: { txtPageNo: CurrentPageNo,
				txtUsername: Username,
				hidUserStatus: UserStatus,
				txtRoomNo: RoomNo,
				hidFileid: FileID,
				isPresent: isPresent,
				txtPresenterPageNo : PresenterPageNo

		},
		success: function(data){
			$('#spanShowNote').html(data);
			//convert string to array
			var strNoteName = document.getElementById("hidArrNoteName").value;
			var ArrNoteName = strNoteName.split(",");
						
			var strArrOwnerNote = document.getElementById("hidArrOwnerNote").value;
			var ArrOwnerNote = strArrOwnerNote.split(",");
			
			var strArrSourceImage = document.getElementById("hidArrSourceImage").value;
			var ArrSourceImage = strArrSourceImage.split(",");
			//===========================================================================
			var idDivShowNote = "divShowNoteUser" + Username + "_PageNo" + CurrentPageNo;
			console.log("showNote()-- idDivShowNote = "+idDivShowNote);
			// create note area to show
			var WidthPage = $(idPageArea).width();
			var HeightPage = $(idPageArea).height();
			
			$("#" + idDivShowNote).remove();
			$( idPageArea ).append('<div '
			+ 'id="'+ idDivShowNote +'" '
			+ 'style="width:' + WidthPage + 'px; ' 
			+ 'height:'+ HeightPage +'px; '
			+ 'z-index:200; position:absolute; top:0px; left:0px; right:0px; " > '
			+ '</div> '
			);// END ajax: append div tag
			if(ArrNoteName.length > 1 && isPresent == "N"){
				// Example: <div id="divShowNoteUserUSER2_PageNo1"></div>
				for (var x=0;x<ArrNoteName.length; x++){
											
					if(ArrNoteName[x] != ""){
						console.log("showNote()---------------------START------------------------------");
						console.log("showNote()-- IN FOR: note=" +ArrNoteName[x].toString() 
													+"| owner=" + ArrOwnerNote[x].toString()
													+"| source=" + ArrSourceImage[x].toString()
													+"| isPresent=" + isPresent
													+"| user=" + Username
													+"| id=" + idDivShowNote
													+"| w=" + WidthPage
													+"| h=" + HeightPage);		
						//var d = Date.now();
						//var srcImage= ArrSourceImage[x].toString()+"?time="+d;
						var srcImage= ArrSourceImage[x];
						console.log("showNote()-- srcImage = "+ srcImage);
						
						//Example: id = "imgUSER1_PageNo20"

						var idImgAnnotation = "img" + ArrNoteName[x].substr(0, ArrNoteName[x].length-4);
						var ImageNote = '<img id="'+idImgAnnotation+'" name="'+idImgAnnotation+'" src="'+srcImage+'" '
						+ 'style="width:' + WidthPage + 'px; ' 
						+ 'height:'+ HeightPage +'px; '
						+ 'z-index:250; position:absolute; top:0px; left:0px; right:0px;" > ';
							
						console.log("showNote()-- idDivShowNote = "+ idDivShowNote);
						console.log("showNote()-- ImageNote = "+ ImageNote);
						$( "#" + idDivShowNote ).append(ImageNote);// END ajax: append image
					}//END if the number of note updated is valid
					else{
						console.log("showNote()-- else... data is blank.");
					}
					console.log("showNote()---------------------END------------------------------");
				}//END For loop ArrNoteName
			}//END if(ArrNoteName.length > 1)
						
			//===========================================================================				
		},
		error:function(){
			//$("#spanMsgError").html("Error showNote() function !!!");
			console.log("JSCommFunc.js: Error showNote() !!!");
		}
	});//END ajax
	

}// END showNote()
//*****************************************************************************

function loadImgToCanvas(srcImg) {
	console.log("loadImgToCanvas()-- " + srcImg);
	// create hidden canvas (using image dimensions)
	var canvas = document.getElementById('myCanvas');
	var context = canvas.getContext('2d');
	var imageObj = new Image();
	imageObj.src = srcImg;
	imageObj.onload = function() {
		context.drawImage(imageObj, 0, 0);
	};

}//END convertImgToCanvas()

function showNotePresenter(){ 
	var CurrentPageNo = $("#pageNumber").val();
	var RoomNo = $("#txtRoomNo").val();
	var FileID = $("#hidFileid").val();
	var UserStatus = $("#hidUserStatus").val();
	var Username = $("#txtUsername").val();
	
	var btnPresent= $("#hidPresentStatus").val();
	var isPresent = "N";
	if(btnPresent == "STOP"){
		isPresent = "Y";
	}else{
		isPresent = "N";
	}	
	var idPageArea = "#pageContainer" + CurrentPageNo;

	$.ajax({
		type: "POST",
		url: "PHPScript/ShowPresenterAnnotation.php",
		data: { txtPageNo: CurrentPageNo,
				txtUsername: Username,
				hidUserStatus: UserStatus,
				txtRoomNo: RoomNo,
				hidFileid: FileID,
				isPresent: isPresent
		},
		cache: false,
		success: function(data){
			$('#spanShowNotePresenter').html(data);
			PDFView.page = document.getElementById("hidPresenterPage").value;	
			//convert string to array
			var hidArrNoteName = document.getElementById("hidArrNoteNamePresenter").value;
			var arrNoteName = hidArrNoteName.split(",");
			
			var hidOwnerName = document.getElementById("hidArrOwnerNotePresenter").value;
			var arrOwnerNote = hidOwnerName.split(",");
			
			var hidArrSrcImg = document.getElementById("hidArrSourceImagePresenter").value;
			var arrSourceImage = hidArrSrcImg.split(",");
			//===========================================================================
			// Example: <div id="divShowNoteUserUSER2_PageNo1"></div>
			var idDivShowNotePresenter = "divShowNotePresenter" + Username + "_PageNo" + CurrentPageNo;
			var idDivShowNote = "divShowNoteUser" + Username + "_PageNo" + CurrentPageNo;
			// create note area to show
			var WidthPage = $(idPageArea).width();
			var HeightPage = $(idPageArea).height();
			
			 if ($('#' + idDivShowNote) != null ) {
				$("#" + idDivShowNote).remove();
				console.log("showNotePresenter()-- if... alerdy remove idDivShowNote");
			}else{
				console.log("showNotePresenter()-- else.. no found idDivShowNote");
			}
			
			$("#" + idDivShowNotePresenter).remove();
			$( idPageArea ).append('<div '
			+ 'id="'+ idDivShowNotePresenter +'" '
			+ 'style="width:' + WidthPage + 'px; ' 
			+ 'height:'+ HeightPage +'px; '
			+ 'z-index:200; position:absolute; top:0px; left:0px; right:0px; " > '
			+ '</div> '
			);// END ajax: append div tag
			
			//===========================================================================
			/*
			if(strNoteName != ""){
				
				console.log("showNotePresenter()---------------------START ------------------------------");
				console.log("showNotePresenter()-- IN : note=" +strNoteName
											+"| owner=" +strOwnerNote
											+"| source=" + strSourceImage
											+"| isPresent=" + isPresent
											+"| user=" + Username
											+"| id=" + idDivShowNotePresenter
											+"| w=" + WidthPage
											+"| h=" + HeightPage);		

				
				var srcImage = strSourceImage;
				console.log("showNotePresenter()-- srcImage = "+ srcImage);
			
				//Example: id = "imgUSER1_PageNo20"
				var idImgAnnotation = "img" + strNoteName.substr(0, strNoteName.length-4);
				var ImageNote2 = '<img id="'+idImgAnnotation+'" name="'+idImgAnnotation+'" src="'+srcImage+'" '
				+ 'style="width:' + WidthPage + 'px; ' 
				+ 'height:'+ HeightPage +'px; '
				+ 'z-index:1000; position:absolute; top:0px; left:0px; right:0px;" > ';
		
				console.log("showNotePresenter()-- idDivShowNote = "+ idDivShowNote);
				console.log("showNotePresenter()-- ImageNote = "+ ImageNote2);
				$( "#" + idDivShowNotePresenter ).append(ImageNote2);// END ajax: append image
			}//END if the number of note updated is valid
			else{
				console.log("showNotePresenter()-- else... data is blank.");
			}*/
			if(arrNoteName.length > 1){
				for (var i=0;i<arrNoteName.length; i++){
				//for (var i=0;i<1; i++){							
					if(arrNoteName[i] != ""){
						
						//var d = Date.now();
						//var srcImage= ArrSourceImage[x].toString()+"?time="+d;
						var srcImage= arrSourceImage[i];
						console.log("showNote()-- srcImage = "+ srcImage);
						
						//Example: id = "imgUSER1_PageNo20"
						var idImgAnnotation = "img" + arrNoteName[i].substr(0, arrNoteName[i].length-4);
						var ImageNote2 = '<img id="'+idImgAnnotation+'" name="'+idImgAnnotation+'" src="'+srcImage+'" '
						+ 'style="width:' + WidthPage + 'px; ' 
						+ 'height:'+ HeightPage +'px; '
						+ 'z-index:250; position:absolute; top:0px; left:0px; right:0px;" > ';
							
						console.log("showNote()-- idDivShowNotePresenter = "+ idDivShowNotePresenter);
						console.log("showNote()-- ImageNote2 = "+ ImageNote2);
						$( "#" + idDivShowNotePresenter ).append(ImageNote2);// END ajax: append image
					}//END if the number of note updated is valid
					else{
						console.log("showNotePresenter()-- else... data is blank.");
					}
					console.log("showNotePresenter()---------------------END------------------------------");
				}//END For loop ArrNoteName
			}
			

		console.log("showNotePresenter() **************************   END   ******************************");			
			//===========================================================================				
		},
		error:function(){
			//$("#spanMsgError").html("Error showNotePresenter() function !!!");
			console.log("JSCommFunc.js: Error showNotePresenter() !!!");
		}
	});//END ajax
	

}// END showNotePresenter()
//========================================================================================================
function setNowPageNo(){
	var UserStatus = document.getElementById("hidUserStatus").value;	
	var PageNo = document.getElementById("pageNumber").value;	
	var Username = document.getElementById("txtUsername").value;
	/*var RoomFlag = document.getElementById("hidRoomFlag").value;*/
	var RoomNo = document.getElementById("txtRoomNo").value;
	var RoomCode = document.getElementById("hidRoomCode").value;
	var Filename = document.getElementById("hidFilename").value;
	var UserID = document.getElementById("txtUserid").value;
	var RoomID = document.getElementById("txtRoomid").value;
	var FileID = document.getElementById("hidFileid").value;

	$.ajax({
		type: "POST",
		url: "PHPScript/PresentConn.php",
		data: { txtPageNo: PageNo,
				txtUsername: Username,
				hidUserStatus: UserStatus,
				/*txtRoomFlag: RoomFlag,*/
				txtRoomNo: RoomNo,
				txtRoomCode: RoomCode,
				txtFilename:Filename,
				txtUserid:UserID,
				txtRoomid:RoomID,
				hidFileid:FileID
		},
		success: function(data){
			$('#spanNowPageNo').html(data);
		},
		error:function(){
			//$("#spanMsgError").html("Error setNowPageNo() function !!!");
			console.log("JSCommFunc.js: Error setNowPageNo() !!!");
		}
	});//END ajax
}//END setNowPageNo()

//========================================================================================================
function getListAnnotation(){
	// To get all list annotations from ANNOTATION table, then show on left menu.
	var RoomNo = $("#txtRoomNo").val();
	var FileID = $("#hidFileid").val();
	var PageNo = $("#pageNumber").val();
	var Username = $("#txtUsername").val();
	var UserStatus = $("#hidUserStatus").val();
	
	$.ajax({
		type: "POST",
		url: "PHPScript/ListAnnotationConn.php",
		data: {	txtRoomNo: RoomNo,
				hidFileid: FileID,
				txtPageNo: PageNo,
				txtUsername:Username,
				hidUserStatus:UserStatus
		},
		success: function(data){
			$('#divLeftSlidebar').html(data);
		},
		error:function(){
			//$("#spanMsgError").html("Error getListAnnotation() function !!!");
			console.log("JSCommFunc.js: Error getListAnnotation() !!!");
		}
	});//END ajax
}// END getListAnnotation()
//========================================================================================================
function setBtnColorStyle(){
	document.getElementById("btnMarker1X").disabled = true;
	document.getElementById("btnMarker2X").disabled = true;
}//END setBtnColorStyle();
//========================================================================================================
var arrColor =[];
var idBtnColor = "";
function clickPen(color, linewidth){
	var idBtnColor = "";
	
	if(color == "black"){
		idBtnColor = "btnBlack";
		document.getElementById("btnRed").disabled = true;
		document.getElementById("btnBlue").disabled = true;
		document.getElementById("btnRubNote").disabled = true;
		setBtnColorStyle();
		arrColor.push(idBtnColor);
		
	}else if(color == "red"){
		idBtnColor = "btnRed";
		document.getElementById("btnBlack").disabled = true;
		document.getElementById("btnBlue").disabled = true;
		document.getElementById("btnRubNote").disabled = true;
		setBtnColorStyle();
		arrColor.push(idBtnColor);
		
	}else if(color == "blue"){
		idBtnColor = "btnBlue";
		document.getElementById("btnBlack").disabled = true;
		document.getElementById("btnRed").disabled = true;
		document.getElementById("btnRubNote").disabled = true;
		setBtnColorStyle();
		
	}else if(color == "white"){
		idBtnColor = "btnRubNote";
		document.getElementById("btnRubNote").style.backgroundColor = "#FFFFFF";
		document.getElementById("btnBlack").disabled = true;
		document.getElementById("btnRed").disabled = true;
		document.getElementById("btnBlue").disabled = true;
		setBtnColorStyle();	
		
		
	}else if(color == "yellow"){
		if(linewidth == 40){
			idBtnColor = "btnMarker2X";
			//document.getElementById("btnMarker1X").disabled = true;
			
		}else{
			idBtnColor = "btnMarker1X";
			//document.getElementById("btnMarker2X").disabled = true;
		}
		document.getElementById("btnBlack").disabled = true;
		document.getElementById("btnRed").disabled = true;
		document.getElementById("btnBlue").disabled = true;
		document.getElementById("btnRubNote").disabled = true;
		document.getElementById("btnRubNote").value = "";
	}// END if color = 'yellow'
	
	
	
	if( document.getElementById("hidAnnotationSelected").value == "" )
	{
		$( "#"+idBtnColor ).addClass( "AnnotationTools_Selected" );
		document.getElementById("hidAnnotationSelected").value = idBtnColor;
		writeNote(color, linewidth);
	}

}// END clickPen()

//========================================================================================================
function sendNote(){
	
	if( document.getElementById("hidAnnotationSelected").value != "" )
	{
		saveNote();
		cancelWriteNote();
	}
}//END sendNote()

function cancelWriteNote(){

	var CurrentPageNo = $("#pageNumber").val();
	var Username = $("#txtUsername").val();
	var idSigDiv = "divWrtNoteUser" + Username + "_PageNo" + CurrentPageNo ;
	$( "#" + idSigDiv ).remove();
	
	var isExistPageNo = arrPageNo.indexOf(CurrentPageNo);
	if(isExistPageNo > -1){
		arrPageNo.splice(arrPageNo.indexOf(CurrentPageNo));
	}
	if( document.getElementById("hidAnnotationSelected").value != "" )
	{
		var idBtnColor = document.getElementById("hidAnnotationSelected").value;
		$( "#"+idBtnColor ).removeClass( "AnnotationTools_Selected" );
		document.getElementById("hidAnnotationSelected").value = "";
	}
	
	document.getElementById("btnBlack").disabled = false;
	document.getElementById("btnRed").disabled = false;
	document.getElementById("btnBlue").disabled = false;
	document.getElementById("btnMarker1X").disabled = false;
	document.getElementById("btnMarker2X").disabled = false;
	document.getElementById("btnRubNote").disabled = false;
	document.getElementById("btnRubNote").style.backgroundColor = "#F5F5F5";
}// END cancelWriteNote()
//========================================================================================================
function loadNewFile(){
	var Username = document.getElementById("txtUsername").value;
	var RoomNo = document.getElementById("txtRoomNo").value;
	var Filename = document.getElementById("hidFilename").value;
	var FileID = $("#hidFileid").val();

	$.ajax({
		type: "POST",
		url: "PHPScript/loadPDF.php",
		data: { txtUsername: Username,
				txtRoomNo : RoomNo,
				hidFileid : FileID,
				hidFilename : Filename
		},
		success: function(data){
			$('#divDownloadMsg').html( data ).hide();
			
			var filename = document.getElementById("hidFilenameDownloaded").value;
			/*var filename = "AChristmasCarol.pdf"*/
			var path = "pdf/uploaded/" + filename; 
			/*document.location = path;*/
		},
		error:function(){
			//alert("Error loadNewFile()!!!");
			console.log("JSCommFunc.js: Error loadNewFile() !!!");
		}
	});
	
}// END loadNewFile()
//========================================================================================================
function OverAnnotationTools(id){
	$( "#"+id ).addClass( "AnnotationTools_Over" );
}// END OverAnnotationTools()
function OutAnnotationTools(id){
	$( "#"+id ).removeClass( "AnnotationTools_Over" );
}// END OverAnnotationTools()
//========================================================================================================



