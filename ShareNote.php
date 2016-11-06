<?php
	session_start();
	include('config.php');
	if (!isset($_SESSION['sess_username'])){
		session_destroy();			
		header("Location: /Thesis/login.php");
		exit();	
		
	}else{
		$sess_username = trim(strtoupper($_SESSION['sess_username']));
		$sess_email = trim($_SESSION['sess_email']);
		//$sess_user_status  = trim($_SESSION['sess_user_status']); 
		$sess_user_status  = "V";
		// User status e.g., "P" = presenter, "V" = viewer
		/*$sess_room_flag = trim(strtoupper($_SESSION['sess_room_flag'])); // Private flag of presentation e.g., "Y"
		$sess_room_code = trim(strtoupper($_SESSION['sess_room_code'])); // Private code to join room e.g, 12345 (5 characters)
		$sess_room = trim($_SESSION['sess_room_name']); 
		$sess_filename = trim($_SESSION['sess_file_name']); */
	
		
	}
	
	/*$sess_file_name = trim($_SESSION['sess_file_name']); 
	$sess_user_status  ='V';*/
	?>




<html  dir="ltr" mozdisallowselectionprint moznomarginboxes>
	<head >
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<!--#if GENERIC || CHROME-->
		<meta name="google" content="notranslate">
		<!--#endif-->
		<title>Share Note</title>
		<!--#if FIREFOX || MOZCENTRAL-->
		<!--#include viewer-snippet-firefox-extension.html-->
		<!--#endif-->
		<!--#if CHROME-->
		<!--#include viewer-snippet-chrome-extension.html-->
		<!--#endif-->
		<!-- <link rel="stylesheet" href="css/pdf-Vdevice.css"/> -->
		<link rel="stylesheet" href="css/shareNote.css"/>
		<!--<link rel="stylesheet" href="script/pdf_js/viewer.css"/>-->

		<link rel="resource" type="application/l10n" href="locale/locale.properties"/>
		<!--#if !(FIREFOX || MOZCENTRAL || CHROME)-->
		<script type="text/javascript" src="script/pdf_js/compatibility.js"></script>
		<!--#endif-->
		<script type="text/javascript" src="script/pdf_js/external/webL10n/l10n.js"></script>
		<script type="text/javascript" src="script/pdf_js/shared/util.js"></script>
		<script type="text/javascript" src="script/pdf_js/shared/colorspace.js"></script>
		<script type="text/javascript" src="script/pdf_js/shared/pattern.js"></script>
		<script type="text/javascript" src="script/pdf_js/shared/function.js"></script>
		<script type="text/javascript" src="script/pdf_js/shared/annotation.js"></script>
		<script type="text/javascript" src="script/pdf_js/display/api.js"></script>
		<script type="text/javascript" src="script/pdf_js/display/metadata.js"></script>
		<script type="text/javascript" src="script/pdf_js/display/canvas.js"></script>
		<script type="text/javascript" src="script/pdf_js/display/font_loader.js"></script>
		<script type="text/javascript">PDFJS.workerSrc = 'script/pdf_js/worker_loader.js';</script>
		<script type="text/javascript" src="script/pdf_js/ui_utils.js"></script>
		<script type="text/javascript" src="script/pdf_js/download_manager.js"></script>
		<script type="text/javascript" src="script/pdf_js/settings.js"></script>
		<script type="text/javascript" src="script/pdf_js/page_view.js"></script>
		<script type="text/javascript" src="script/pdf_js/thumbnail_view.js"></script>
		<script type="text/javascript" src="script/pdf_js/text_layer_builder.js"></script>
		<script type="text/javascript" src="script/pdf_js/pdf_find_bar.js"></script>
		<script type="text/javascript" src="script/pdf_js/pdf_find_controller.js"></script>
		<script type="text/javascript" src="script/pdf_js/pdf_history.js"></script>
		<script type="text/javascript" src="script/pdf_js/secondary_toolbar.js"></script>
		<script type="text/javascript" src="script/pdf_js/password_prompt.js"></script>
		<script type="text/javascript" src="script/pdf_js/presentation_mode.js"></script>
		<script type="text/javascript" src="script/pdf_js/debugger.js"></script>
		<!--<script type="text/javascript" src="script/pdf_js/viewer.js"></script>-->
		<script type="text/javascript" src="jquery/js/jquery-1.9.1.js"></script> 
		<script type="text/javascript" src="script/JSCommFunc.js"></script> 
		<script type="text/javascript" src="script/JSVerify.js"></script> 
		<script type="text/javascript" src="script/jSignature/jSignature.min.js"></script> 
		<script type="text/javascript" src="jquery/js/jquery.ui.touch-punch.min.js"></script> 
		<!--<link href="css/main.css" rel="stylesheet" type="text/css" />-->
		<link href="css/vpresent-style.css" rel="stylesheet" type="text/css" />
		<link href="script/jSignature/css/theme.jsignature.css" rel="stylesheet" type="text/css" />
		<script src = "jquery/tool/firebase.js"></script>
		<script src = "https://cdn.firebase.com/js/client/2.4.2/firebase.js"></script>
		<script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
		<script src="https://cdn.firebase.com/js/client/2.4.2/firebase.js"></script>
		<script src = "QuizJquery/quizmodeMain.js"></script>

		<!--<div id="Canvas"  style="background:#FFFFFF; color:#0000CD decor-color:transparent">
		<button style = "width:50px;"id="save">SAVE
		</button>
		<button style = "width:50px;" onClick = "test();">HEREEEEE</button>-->
</head>
		<body>
		<div id="Canvas" onClick="showNotePresenter();">

<button  type="submit" id="status" onClick = "test();" class="button btn" value="True">

<span>Start shareNote</span></button>
<span id="spanShowNotePresenter" style = "background-color: #FFFFFF;"></span>

<script >
/*$('button').click(function () { 
    var text = 'Start shareNote';
    // save $(this) so jQuery doesn't have to execute again
    var $this = $(this).find('span');
    if ($this.text() === text) {
        $this.text('Stop');
    } else {
        $this.text(text)
    }
});*/
</script>



		<script type="text/javascript">
		/*CreateCanvas();
		function CreateCanvas(){
			var Username = $("#txtUsername").val();
				//var TotalPageNo =  PDFView.pdfDocument.numPages;
				//var CurrentPageNo = $("#pageNumber").val();
				var idSigDiv = "divWrtNoteUser" + Username
				//var idPageArea = "#pageContainer" + CurrentPageNo;
				var WidthPage = '1092';
				var HeightPage = '505';
			$( "Canvas").append('<div '
						+ 'id="'+ idSigDiv +'" '
						+ 'style="width:' + WidthPage + 'px; ' 
						+ 'height:'+ HeightPage +'px; '
						+ 'z-index:10000; position:absolute; top:0px; left:0px; right:0px; " > '
						+ '</div> '
					);
			
					// jSignature is initialized canvas.
					$( "Canvas").jSignature({
						
						'decor-color': 'transparent'
						,'width' : WidthPage
						,'height': HeightPage
						,'color' : "#0000CD"
						,'lineWidth':"1"
						
						
					});
		}
*/
//test();
	var inShowNote;
	$( document ).ready(function() {
		getGroupName();
	/*inShowNote = setInterval(function() {
						showNotePresenter();	
					
					}, 5000);*/
	insaveNote = setInterval(function() {

						save();	
					
					}, 1000);
	});


function test(){
	
	//console.log("dd");
	//var idPageArea = "#pageContainer";
	var Username = <?php echo json_encode($_SESSION['sess_username']) ?>;
	var idSigDiv = "divWrtNoteUser" + Username;
	$( "#Canvas").append('<div '
						+ 'id="'+ idSigDiv +'" '
						+ 'style="width:' + '1092' + 'px; ' 
						+ 'height:'+ '800' +'px; '
						+ 'z-index:10000; position:absolute; top:0px; left:0px; right:0px; " > '
						+ '</div> '
					);
//$('#Canvas').jSignature({ lineWidth: 1, width: 1092, height: 800});
			//randomPenColor();
			
			var randomNumber = Math.floor(Math.random() * ((6-1)+1) + 1);
				 
				 if(randomNumber == '1'){
				 	color = '#3E33FF';//blue
				 }else if(randomNumber == '2'){
				 	color = '#27813A'; //
				 }else if(randomNumber == '3'){
				 	color = '#FF5733'; //red
				 }else if(randomNumber == '4'){
				 	color = '#FFC300'; //yellow
				 }else if(randomNumber == '5'){
				 	color = '#060606'; //black
				 }else{
				 	color = '#32B547'; //green
				 }


 $("#" + idSigDiv).jSignature({
            'background-color': '#FFFFFF',
            'decor-color': 'transparent',
            'lineWidth': '1',
            'width': '1092',
            'height': '800',
            'color' : color
        });
 document.getElementById("status").disabled = true;

}

arrGN =[];
function getGroupName(){
	var Username = <?php echo json_encode($_SESSION['sess_username']) ?>;
	getGroupNameInSelectBossTable(Username);
	//var returnValue = getGroupNameInSelectBossTable(arrPassValue);
	//alert(arrPassValue);

	//var tmp = arrPassValue[0];
	//if(arrPassValue.length>0){
	//arrGN.push(arrPassValue[0]);
	//alert(arrGN);
	//}	
	//arrGN.push(GroupName);

}
function  getGroupNameConn(GroupName){
//debugger;
//alert(GroupName);

arrGN.push(GroupName);
}

function save(){

	var Username = <?php echo json_encode($_SESSION['sess_username']) ?>;
	var RoomNo = arrGN[0];
	
	//var Username = 'kk';
	//var iniImg = $('#Canvas').jSignature();
	//var idSigDiv = "#divWrtNoteUser" + Username;
	var data = $( '#Canvas').jSignature('getData', "image");

	if(data == undefined){
		//not do
	}else{
	var i = new Image();
				i.src = 'data:' + data[0] + ',' + data[1];
				//console.log(i.src);
				var ImageTime = (new Date()).getTime();
				console.log("saveNote()-- ImageTime = "+ImageTime);
				$.ajax({
					type: "POST",
					url: "PHPScript/ShareNoteConn.php",
					data: { txtRoomNo: RoomNo ,
							//hidFileid: FileID,
							txtUsername: Username,
							//txtPageNo: CurrentPageNo ,
							imgs: data[1],
							//hidUserStatus: UserStatus,
							imgTime:ImageTime
					},
					success: function(data){
						$('#DBMsgResult').html( data );
					},
					error:function(){
						console.log("vpresent.php: Error saveNote() !!!");
					}
				}); // END ajax send to AnnotationConn.php
			}
}
//showNotePresenter();
function showNotePresenter(){ 
	//var CurrentPageNo = $("#pageNumber").val();
	var RoomNo = arrGN[0];
	var isPresent = "N";

	//var FileID = $("#hidFileid").val();
	//var UserStatus = $("#hidUserStatus").val();
	var Username = <?php echo json_encode($_SESSION['sess_username']) ?>;
	
	/*var btnPresent= $("#hidPresentStatus").val();
	var isPresent = "N";
	if(btnPresent == "STOP"){
		isPresent = "Y";
	}else{
		isPresent = "N";
	}	
	var idPageArea = "#pageContainer" + CurrentPageNo;*/

	$.ajax({
		type: "POST",
		url: "PHPScript/ShowNoteAuto.php",
		data: { //txtPageNo: CurrentPageNo,
				txtUsername: Username,
				//hidUserStatus: UserStatus,
				txtRoomNo: RoomNo,
				//hidFileid: FileID,
				//isPresent: isPresent
		},
		cache: false,
		success: function(data){
			$('#spanShowNotePresenter').html(data);
			//PDFView.page = document.getElementById("hidPresenterPage").value;	
			//convert string to array
			var hidArrNoteName = document.getElementById("hidArrNoteNamePresenter").value;
			var arrNoteName = hidArrNoteName.split(",");
			
			var hidOwnerName = document.getElementById("hidArrOwnerNotePresenter").value;
			var arrOwnerNote = hidOwnerName.split(",");
			
			var hidArrSrcImg = document.getElementById("hidArrSourceImagePresenter").value;
			var arrSourceImage = hidArrSrcImg.split(",");
			//===========================================================================
			// Example: <div id="divShowNoteUserUSER2_PageNo1"></div>
			var idDivShowNotePresenter = "divShowNotePresenter" + Username;
			var idDivShowNote = "divShowNoteUser" + Username;
			// create note area to show
			var WidthPage = '1092';
			var HeightPage = '800';
			
			 if ($('#' + idDivShowNote) != null ) {
				$("#" + idDivShowNote).remove();
				console.log("showNotePresenter()-- if... alerdy remove idDivShowNote");
			}else{
				console.log("showNotePresenter()-- else.. no found idDivShowNote");
			}
			
			$("#" + idDivShowNotePresenter).remove();
			$( "#Canvas" ).append('<div '
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
		</script>

		</div>

<script>
$(document).ready(function(){
    $("#hide").click(function(){
        $("p").hide();
    });
    $("#show").click(function(){
        $("p").show();
    });
});
</script>
<br>
<br><br>
<br>
<h2 class="alert">Let's share your idea by click the Start button and draw what you want :) </h2>






<script type="text/javascript">
	window.setTimeout(function() {
    $(".alert").fadeTo(400, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
</script>




</body>

</html>