<!DOCTYPE html>
<?php
	session_start();
	include('config.php');
	
	if (!isset($_SESSION['sess_username'])){
		session_destroy();			
		header("Location: /Thesis/index.php");
		exit();	
		
	}else{
		$sess_username = trim(strtoupper($_SESSION['sess_username']));
		$sess_email = trim($_SESSION['sess_email']);
		$sess_user_status  = "P"; 
		/*$sess_room_flag = trim(strtoupper($_SESSION['sess_room_flag']));  Private flag of presentation e.g., "Y"
		$sess_room_code = trim(strtoupper($_SESSION['sess_password_room'])); // Private code to join room e.g, 12345 (5 characters)
		$sess_room = trim(strtoupper($_SESSION['sess_room_name'])); 
		$sess_filename = trim($_SESSION['sess_filename']); 
		$sess_filename = trim($_SESSION['sess_file_name']); */
		$sess_room = $_GET['room_name'];
		$sess_filename = $_GET['file_name'];
		$sess_userid = trim($_SESSION['sess_user_id']);
		$sess_fileid = $_GET['file_id'];
		$sess_roomid = $_GET['room_id'];
	
	}
	?>
<html dir="ltr" mozdisallowselectionprint moznomarginboxes>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<!--#if GENERIC || CHROME-->
		<meta name="google" content="notranslate">
		<!--#endif-->
		<title>PDF.js viewer</title>
		<!--#if FIREFOX || MOZCENTRAL-->
		<!--#include viewer-snippet-firefox-extension.html-->
		<!--#endif-->
		<!--#if CHROME-->
		<!--#include viewer-snippet-chrome-extension.html-->
		<!--#endif-->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<link rel="stylesheet" href="css/pdf-device.css"/>
		<link rel="stylesheet" href="script/pdf_js/viewer.css"/>
		<link rel="stylesheet" href="script/pdf_js/css/workonPDF.css"/>
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
		<script type="text/javascript" src="script/pdf_js/viewer.js"></script>
		<script type="text/javascript" src="jquery/js/jquery-1.9.1.js"></script> 
		<script type="text/javascript" src="script/JSCommFunc.js"></script> 
		<script type="text/javascript" src="script/JSVerify.js"></script> 
		<script type="text/javascript" src="script/jSignature/jSignature.min.js"></script> 
		<script type="text/javascript" src="jquery/js/jquery.ui.touch-punch.min.js"></script> 
		<link href="css/main.css" rel="stylesheet" type="text/css" />
		<link href="css/vpresent-style.css" rel="stylesheet" type="text/css" />
		<link href="script/jSignature/css/theme.jsignature.css" rel="stylesheet" type="text/css" />
		<!--      this script make the tools can not work
			<script src = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
		<script src = "jquery/tool/firebase.js"></script>
		<script src = "https://cdn.firebase.com/js/client/2.4.2/firebase.js"></script>
		<script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
		<script src="https://cdn.firebase.com/js/client/2.4.2/firebase.js"></script>
		<script src = "QuizJquery/quizmodeMain.js"></script>
		<script type="text/javascript">
			//Start up setInterval parameter.
			var inRecord; // Auto update current page no into database both presenter and viewer.
			var inPresent; // Presenter Mode.
			var inShowNotePresentMode;
			var inListAnnotation;
			var inShowNote;
			
			$( document ).ready(function() {
				// call setParameter(): To set page parameter.
				setParameter();	
				//PDFView.setScale('page-fit', true);
				// call startRecPageNo(): To insert/update current page no into database.
				startRecPageNo();
				/*clearInterval(inShowNote);*/
				//Auto show annotation list on left menu that depend on page no.
				inListAnnotation = setInterval(function() {
					// call getListAnnotation(): To reset annotation list on left menu.
					getListAnnotation();
			
				}, 800);
				
				inShowNote = setInterval(function() {
					
					showNote();	
				//},400);
				}, 400);
				//onloadWorked();
			}); // END onReady() function
			
			
			//========================================================================================================
			/*function onloadWorked(){
				if(document.getElementById("hidUserStatus").value == "V" ){
					startView();
				}
			}//END onloadWork()*/
			//========================================================================================================
			function resetNote(){
				// To reset button to delete all annotation in box.
				var Username = $("#txtUsername").val();
				var CurrentPageNo = $("#pageNumber").val();
				var idSigDiv = "divWrtNoteUser" + Username + "_PageNo" + CurrentPageNo ;
				console.log("reset: " + idSigDiv);
				$( "#" + idSigDiv ).jSignature('clear');
				
				cancelWriteNote();
			}// END resetNote()
			//========================================================================================================
			var arrPageNo = []; // check page no passed.
			function writeNote(color, linewidth){
				var Username = $("#txtUsername").val();
				var TotalPageNo =  PDFView.pdfDocument.numPages;
				var CurrentPageNo = $("#pageNumber").val();
				
				var idPageArea = "#pageContainer" + CurrentPageNo;
				var WidthPage = $(idPageArea).width();
				var HeightPage = $(idPageArea).height();
				
				var NoteLineColor = "", BGColor = "";
				
				if(color == "black"){
					NoteLineColor = "#000000";
					
				}else if(color == "red"){
					NoteLineColor = "#FF0000";
					
				}else if(color == "blue"){
					NoteLineColor = "#0000CD";
					
				}else if(color == "yellow"){
					NoteLineColor = "rgba(255, 255, 0, 0.1)";
					
				}else if(color == "white"){
					NoteLineColor = "rgba(255, 255, 255, 0.1)";
					//NoteLineColor = "transparent";
				}
			
				var NoteLineWidth = linewidth;
				
				var idSigDiv = "divWrtNoteUser" + Username + "_PageNo" + CurrentPageNo ;
				
				var isExistPageNo = arrPageNo.indexOf(CurrentPageNo);
				if(isExistPageNo <= -1){
					arrPageNo.push(CurrentPageNo);
					
					// create note area to write
					$( idPageArea ).append('<div '
						+ 'id="'+ idSigDiv +'" '
						+ 'style="width:' + WidthPage + 'px; ' 
						+ 'height:'+ HeightPage +'px; '
						+ 'z-index:10000; position:absolute; top:0px; left:0px; right:0px; " > '
						+ '</div> '
					);
			
					// jSignature is initialized canvas.
					$( "#" + idSigDiv ).jSignature({
						'UndoButton':true
						,'decor-color': 'transparent'
						,'width' : WidthPage
						,'height': HeightPage
						,'color' : NoteLineColor
						,'lineWidth':NoteLineWidth
						
					});
				} // END if(isExistPageNo <= -1)	
				else{
						
				}// END else if isExistPageNo <> -1
			}// END writeNote()
			//========================================================================================================
			var CountImgNote = 0;
			function saveNote(){
				var CurrentPageNo = $("#pageNumber").val();
				var RoomNo = $("#txtRoomNo").val();
				var FileID = $("#hidFileid").val();
				var Username = $("#txtUsername").val();
				var UserStatus = $("#hidUserStatus").val();
				
				//div tag 
				var idSigDiv = "#divWrtNoteUser" + Username + "_PageNo" + CurrentPageNo;
				var data = $( idSigDiv ).jSignature('getData', "image");
			
				var i = new Image();
				i.src = 'data:' + data[0] + ',' + data[1];
				//console.log(i.src);
				var ImageTime = (new Date()).getTime();
				console.log("saveNote()-- ImageTime = "+ImageTime);
				//$(i).appendTo($out);
				$.ajax({
					type: "POST",
					url: "PHPScript/AnnotationConn.php",
					data: { txtRoomNo: RoomNo ,
							hidFileid: FileID,
							txtUsername: Username,
							txtPageNo: CurrentPageNo ,
							imgs: data[1],
							hidUserStatus: UserStatus,
							imgTime:ImageTime
					},
					success: function(data){
						$('#DBMsgResult').html( data );
						//alert("success");
					},
					error:function(){
						console.log("Ppresent.php: Error saveNote() !!!");
						alert("fail");
					}
				}); // END ajax send to AnnotationConn.php
				
			}// END saveNote()
			//========================================================================================================
			function ChkNote(idChkBox){
				var RoomNo = $("#txtRoomNo").val();
				var FileID = $("#hidFileid").val();
				var CurrentPageNo = $("#pageNumber").val();
				var UserStatus = $("#hidUserStatus").val();
				var Username = $("#txtUsername").val();
				//var NoteImgName = $("#" + idChkBox).val();
				var NoteOwner = idChkBox.substring(3);
				var chkStatus =  document.getElementById(idChkBox).checked;
				
				var CheckedVal = "N";
				
				if(chkStatus){ //true = checked
					//document.getElementById(idChkBox).checked = true;
					CheckedVal = "Y";
				}else{ //false = unchecked
					CheckedVal = "N";
				}
				console.log("ChkNote()-- CheckedVal = "+CheckedVal +", idChkBox = "+idChkBox+ ", Owner = "+NoteOwner + ", User=" + Username);
				$.ajax({
					type: "POST",
					url: "PHPScript/ChkAnnotationConn.php",
					data: { txtRoomNo: RoomNo,
							hidFileid: FileID,
							txtPageNo: CurrentPageNo ,
							hidUserStatus: UserStatus,
							txtUsername: Username,
							isChecked:CheckedVal,
							txtNoteOwner: NoteOwner
							
					},
					success: function(data){
						$('#DBMsgResult').html( data );
			
					},
					error:function(){
						console.log("Ppresent.php: Error ChkNote() !!!");
					}
				}); //END ajax sent to ChkAnnotationConn.php
			
			}// END ChkNote()
			
			//========================================================================================================
			/*function setPresentationMode(){
				
				//document.getElementById("btnPresentStatus").style.backgroundImage = "url(images/pause.png)";
				document.getElementById("hidPresentStatus").value = "STOP";
				$(".toolbar").hide();
				
				$("#divAnnotationTools").hide();
				$("#divLeftSlidebar").hide();
				$("#secondaryToolbar").hide();
				$("#toolbarSidebar").hide();
			}// END setPresentationView()
			*/
			/*function setViewMode(){
				//document.getElementById("btnPresentStatus").style.backgroundImage = "url(images/start.png)";
				document.getElementById("hidPresentStatus").value = "START";
				$(".toolbar").show();
				$("#divAnnotationTools").show();
				$("#divLeftSlidebar").show();
				$("#secondaryToolbar").show();
				$("#toolbarSidebar").show();
			}// END setViewMode()
			
			function startView(){
				// To check present button.
				var PresentStatus= document.getElementById("hidPresentStatus").value;
				$("#divStopPresent").show();
				
				//set scale only one page
				PDFView.setScale('page-fit', true);
				
				if(PresentStatus == "START"){
					clearInterval(inShowNote);
					setPresentationMode();
				
					inShowNotePresentMode = setInterval(function() {
						showNotePresenter();	
					}, 400);
					
				}else{
					
					setViewMode();
					clearInterval(inPresent);
					clearInterval(inShowNotePresentMode);
					window.location.reload();
				}
			}// END startView()
			function stopView(){
				// To check stop present button.
				var PresentStatus= document.getElementById("hidPresentStatus").value;
				$("#divStopPresent").hide();
				
				//set scale only one page
				PDFView.setScale('page-fit', true);
				
				if(PresentStatus == "START"){
					clearInterval(inShowNote);
					setPresentationMode();
				
					inShowNotePresentMode = setInterval(function() {
						showNotePresenter();	
					}, 400);
					
				}else{
					
					setViewMode();
					clearInterval(inPresent);
					clearInterval(inShowNotePresentMode);
					window.location.reload();
				}
			}*/// END stopView()
			//========================================================================================================
			function startRecPageNo(){
				// To record #pageNumber into database separated by username.
				var $myPage = $("#pageNumber");
				$myPage.data("value", $myPage.val());
				
				inRecord = setInterval(function() {
					var data = $myPage.data("value"),
						val = $myPage.val();
						
					if (data !== val) {
						$myPage.data("value", val);
						// page changed.
						setNowPageNo();// update/insert into annotation table
						cancelWriteNote();// disabled annotation mode on previous page 
					}
				}, 100); //100	
			
			}// END startRecPageNo()
			//========================================================================================================
		</script>
		<style type="text/css">
			.txt{
			background-color:transparent;
			color:#D8D8D8;
			border:none;
			padding:0px;
			margin:0px;
			font-size: 12px;
			}
		</style>
	</head>
	<body tabindex="1" onbeforeunload="return exitPage()">
		<!-- <body tabindex="1" onbeforeunload="exitPage();"> -->
		<div id="DBMsgResult" style="display: none; color:#FFFFFF; background-color:#333333; "></div>
		<div id="divDownloadMsg" style="color:#FFFFFF; background-color:#333333; "></div>
		<div id="divHead" style="padding:0; margin:0;" >
			<span id="spanMsgError" style="color:#CCCCCC;"></span>
			<span id="spanNowPageNo" style="color:#CCCCCC; display: none;" ></span>
			<span id="spanGetNowPageNo" style="color:#CCCCCC;"></span>
			<span id="spanShowNote" style="color:#CCCCCC;"></span>
			<span id="spanUpdatedNo" style="color:#CCCCCC;"></span>
			<span id="spanShowNotePresenter" style="color:#CCCCCC;"></span>
			<!-- <input type="hidden" id="hidRoomFlag" name="hidRoomFlag" value="<?= $sess_room_flag?>"> -->
			<input type="hidden" id="hidRoomCode" name="hidRoomCode" value="<?= $sess_room_code ?>">
			<input type="hidden" id="hidUserStatus" name="hidUserStatus" value="<?= $sess_user_status ?>" >
			<input type="hidden" id="hidFilename" name="hidFilename" value="<?= $sess_filename ?>" > 
			<input type="hidden" id="hidFileid" name="hidFileid" value="<?= $sess_fileid ?>" >
			<input type="hidden" id="txtRoomid" name="txtRoomid" value="<?= $sess_roomid ?>" >
			<input type="hidden" id="txtUserid" name="txtUserid" value="<?= $sess_userid ?>" >
			<input type="hidden" id="hidAnnotationSelected" name="hidAnnotationSelected" value=""  > 
			<div id="divStopPresent" style="display:inline-block; margin:0px;">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td width="100%">
							<input type="button" id="btnStopView" name="btnStopView" 
								onMouseOver="OverAnnotationTools(id);" onMouseOut="OutAnnotationTools(id);"
								class="AnnotationTools" style="background-image:url(images/pause.png);margin-left:10px;" 
								onClick="stopView();" > 
						</td>
					</tr>
				</table>
			</div>
			<!-- END id="divStopPresent" -->
		</div>
		<!-- END id="divHead" -->
	<div id="outerContainer" class="loadingInProgress">
		<div id="sidebarContainer"  >
			<div id="toolbarSidebar">
				<div class="splitToolbarButton toggled">
					<button id="viewThumbnail" class="toolbarButton group toggled" title="Show Thumbnails" 
						tabindex="2" data-l10n-id="thumbs">
					<span data-l10n-id="thumbs_label">Thumbnails</span>
					</button>
					<button id="viewOutline" class="toolbarButton group" title="Show Document Outline" 
						tabindex="3" data-l10n-id="outline">
					<span data-l10n-id="outline_label">Document Outline</span>
					</button>
				</div>
			</div>
			<div id="sidebarContent">
				<div id="thumbnailView">
				</div>
				<div id="outlineView" class="hidden">
				</div>
			</div>
			<div id="divLeftSlidebar" class="LeftShowData" >
			</div>
		</div>		<!-- sidebarContainer -->
		<div id="mainContainer">
		<div class="findbar hidden doorHanger hiddenSmallView" id="findbar">
			<label for="findInput" class="toolbarLabel" data-l10n-id="find_label">Find:</label>
			<input id="findInput" class="toolbarField" tabindex="41">
			<div class="splitToolbarButton" style="right: 0px">
				<button class="toolbarButton findPrevious" title="" id="findPrevious" tabindex="42" data-l10n-id="find_previous">
				<span data-l10n-id="find_previous_label">Previous</span>
				</button>
				<div class="splitToolbarButtonSeparator"></div>
				<button class="toolbarButton findNext" title="" id="findNext" tabindex="43" data-l10n-id="find_next">
				<span data-l10n-id="find_next_label">Next</span>
				</button>
			</div>
			<input type="checkbox" id="findHighlightAll" class="toolbarField">
			<label for="findHighlightAll" class="toolbarLabel" tabindex="44" data-l10n-id="find_highlight">Highlight all</label>
			<input type="checkbox" id="findMatchCase" class="toolbarField">
			<label for="findMatchCase" class="toolbarLabel" tabindex="45" data-l10n-id="find_match_case_label">Match case</label>
			<span id="findMsg" class="toolbarLabel"></span>
		</div>
		<!-- findbar -->
		<div class = "navbar ">
			<div class="toolbar-space">
				<div id="secondaryToolbar" class="secondaryToolbar hidden doorHangerRight">
					<div id="secondaryToolbarButtonContainer">
						<button id="secondaryPresentationMode" class="secondaryToolbarButton presentationMode visibleLargeView" 
							title="Switch to Presentation Mode" tabindex="18" data-l10n-id="presentation_mode">
						<span data-l10n-id="presentation_mode_label">Presentation Mode</span>
						</button>
						<button id="secondaryOpenFile" class="secondaryToolbarButton openFile visibleLargeView" title="Open File" 
							tabindex="19" data-l10n-id="open_file">
						<span data-l10n-id="open_file_label">Open</span>
						</button>
						<button id="secondaryPrint" class="secondaryToolbarButton print visibleMediumView" title="Print" 
							tabindex="20" data-l10n-id="print">
						<span data-l10n-id="print_label">Print</span>
						</button>
						<button id="secondaryDownload" class="secondaryToolbarButton download visibleMediumView" title="Download" 
							tabindex="21" data-l10n-id="download">
						<span data-l10n-id="download_label">Download</span>
						</button>
						<a href="#" id="secondaryViewBookmark" class="secondaryToolbarButton bookmark visibleSmallView" 
							title="Current view (copy or open in new window)" tabindex="22" data-l10n-id="bookmark">
						<span data-l10n-id="bookmark_label">Current View</span>
						</a>
						<div class="horizontalToolbarSeparator visibleLargeView"></div>
						<button id="firstPage" class="secondaryToolbarButton firstPage" title="Go to First Page" 
							tabindex="23" data-l10n-id="first_page">
						<span data-l10n-id="first_page_label">Go to First Page</span>
						</button>
						<button id="lastPage" class="secondaryToolbarButton lastPage" title="Go to Last Page" 
							tabindex="24" data-l10n-id="last_page">
						<span data-l10n-id="last_page_label">Go to Last Page</span>
						</button>
						<div class="horizontalToolbarSeparator"></div>
						<button id="pageRotateCw" class="secondaryToolbarButton rotateCw" title="Rotate Clockwise" 
							tabindex="25" data-l10n-id="page_rotate_cw">
						<span data-l10n-id="page_rotate_cw_label">Rotate Clockwise</span>
						</button>
						<button id="pageRotateCcw" class="secondaryToolbarButton rotateCcw" title="Rotate Counterclockwise" 
							tabindex="26" data-l10n-id="page_rotate_ccw">
						<span data-l10n-id="page_rotate_ccw_label">Rotate Counterclockwise</span>
						</button>
						<table>
							<tr>
								<td colspan="2" style="background-color:#666666;">
									<input type="button" id="btnSave" name="btnSave" value="" class="AnnotationTools" 
										style="background-image:url(images/save.png);" 
										onClick="loadNewFile();"
										onMouseOver="OverAnnotationTools(id);" onMouseOut="OutAnnotationTools(id);">
									   Download                       
									<!--       
										<input type="button" id="btnDownloadNewFile" name="btnDownloadNewFile" onClick="loadNewFile();" 
										   	value="Download" class="ButtonStyle" alt="Tools"> -->  
								</td>
							</tr>
							<tr>
								<td><input type="text" id="txtRoomNoLabel" name="txtRoomNoLabel" value="Room No." 
									class="txt" size="9" readonly ></td>
								<td><input type="text" id="txtRoomNo" name="txtRoomNo" value="<?= $sess_room ?>" 
									class="txt" size="12" readonly></td>
							</tr>
							<tr>
								<td><input type="text" id="txtBy" name="txtBy" value=""  class="txt" size="11" readonly ></td>
								<td><input type="text" id="txtUsername" name="txtUsername" value="<?= $sess_username ?>"  
									class="txt" size="12" readonly></td>
							</tr>
							<tr>
								<td colspan="2" > 
									<a href="logout.php?usr=<?= $sess_username ?>" class="logout" onClick="Logout();">Log out</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<!-- secondaryToolbar -->
				<div class="toolbar">
					<div id="toolbarContainer">
						<div id="toolbarViewer">
							<div id="toolbarViewerLeft" style="width: 32%;">
								<div id="sidebarToggle" class="page-btn hvr-bob" title="Toggle Sidebar" tabindex="4" data-l10n-id="toggle_sidebar">
									<img src="images/button/totalpage.png">
								</div>
								<!-- <div class="toolbarButtonSpacer" ></div>-->
								<div id="viewFind" class=" group hiddenSmallView zoom-in hvr-bob" title="Find in Document" tabindex="5"data-l10n-id="findbar">
									<img src="images/button/zoomin2.png">
								</div>
						<!--		<div class="splitToolbarButton" style="width: inherit;">
									<div class=" pageUp previous-btn hvr-skew-backward" title="Previous Page" id="previous" tabindex="6" data-l10n-id="previous">
										<img src="images/button/prevpage.png">
										<span data-l10n-id="previous_label">Previous</span>
									</div>
									<div class=" pageDown next-btn hvr-skew-forward" title="Next Page" id="next" tabindex="7" data-l10n-id="next">
										<img src="images/button/nextpage.png">
										<span data-l10n-id="next_label">Next</span>
									</div>
								</div>    -->
								<label id="pageNumberLabel" class="toolbarLabel" for="pageNumber" data-l10n-id="page_label"style="right: 45px;">Page:</label>
								<input type="number" id="pageNumber" class="toolbarField pageNumber" value="1" size="2" min="1" tabindex="8" style="right: 45px;">
								</input>
								<span id="numPages" class="toolbarLabel" style="right: 45px;"></span>

								<!-- move nextandprev to here -->
							<div class="splitToolbarButton page-next-prev" style="width: inherit;">
									<div class=" pageUp previous-btn hvr-skew-backward" title="Previous Page" id="previous" tabindex="6" data-l10n-id="previous">
										<img src="images/button/prevpage.png">
										<span data-l10n-id="previous_label">Previous</span>
									</div>
									<div class=" pageDown next-btn hvr-skew-forward" title="Next Page" id="next" tabindex="7" data-l10n-id="next">
										<img src="images/button/nextpage.png">
										<span data-l10n-id="next_label">Next</span>
									</div>
								</div>
							</div>
							


							<div id="toolbarViewerRight" class="toolbar-device" style="width: 40%">
								<!-- =============================================================================================== -->
								<div id="divFuncTools" style="display:inline-block; margin:0px;">
									<table border="0" cellspacing="0" cellpadding="0" width="100%">
										<tr>
											<td width="100%">
												<!-- <input type="button" id="btnPresentStatus" name="btnPresentStatus" 
													onMouseOver="OverAnnotationTools(id);" onMouseOut="OutAnnotationTools(id);"
													class="AnnotationTools" style="background-image:url(images/start.png);margin-left:10px;" 
													onClick="startView();" >  -->
												<input type="hidden" id="hidPresentStatus" name="hidPresentStatus" value="START" >
											</td>
										</tr>
									</table>
								</div>
								<!-- END id="divFuncTools" -->
								<div id="divAnnotationTools" style="width: 100%;display:inline-block; margin:0px;">
									<table id="anno-portrait" class="anno-portrait" border="0" cellspacing="0" cellpadding="0"  style="float:left;">
										<tr>
											<td width="100%">
												<input type="button" id="btnMarker1X" class="hvr-bob AnnotationTools" value=""
													style="background-image:url(images/highlighttsmall.png);"	
													onClick="clickPen('yellow', '20');" 
													onMouseOver="OverAnnotationTools(id);" onMouseOut="OutAnnotationTools(id);">
												<input type="button" id="btnMarker2X" class="hvr-bob AnnotationTools" value="" 
													style="background-image:url(images/highlightt.png);"
													onClick="clickPen('yellow', '40');" 
													onMouseOver="OverAnnotationTools(id);" onMouseOut="OutAnnotationTools(id);">
												<input type="button" id="btnBlack" name="btnBlack" value="" 
													style="background-image:url(images/blackpen.png);" 
													class="hvr-bob AnnotationTools" onClick="clickPen('black', '1');"
													onMouseOver="OverAnnotationTools(id);" onMouseOut="OutAnnotationTools(id);">
												<input type="button" id="btnRed" name="btnRed" value="" 
													style="background-image:url(images/redpen.png);"
													class="hvr-bob AnnotationTools" onClick="clickPen('red', '1');"
													onMouseOver="OverAnnotationTools(id);" onMouseOut="OutAnnotationTools(id);">
												<input type="button" id="btnBlue" name="btnBlue" value="" 
													style="background-image:url(images/bluepen.png);"
													class="hvr-bob AnnotationTools" onClick="clickPen('blue', '1');" 
													onMouseOver="OverAnnotationTools(id);" onMouseOut="OutAnnotationTools(id);">
												<input type="button" id="btnRubNote" name="btnRubNote" value="" class="hvr-bob AnnotationTools"  
													onClick="clickPen('white', '10');" style="background-image:url(images/eraser2.png);" 
													onMouseOver="OverAnnotationTools(id);" onMouseOut="OutAnnotationTools(id);">                    
											</td>
										</tr>
									</table>
											<nav class="pt-device"  style="float: right;">
												<input type="button" id="btnResetNote" name="btnResetNote" value="Clear" 
													class="btn-new" onClick="resetNote();" 
													onMouseOver="OverAnnotationTools(id);" onMouseOut="OutAnnotationTools(id);">
												<a <input type="button" id="btnSend" name="btnSend" value="Send" class="btn-new" 
													onClick="sendNote();"
													onMouseOver="OverAnnotationTools(id);" onMouseOut="OutAnnotationTools(id);">send <i class="fa fa-paper-plane" aria-hidden="true"></i></a> 
												<!--	</button id="secondaryToolbarToggle" class=" btn-new " title="Tools" value="Tools" tabindex="17" data-l10n-id="tools">
													<span data-l10n-id="tools_label">Tools</span>
													</button> -->

												<div class="dropdown select-main-button menu-btn" >
													<a <input type="button" id="menu-bar-Btn" name="menu-bar-Btn" value="menu" 
														class="dropdown btn-new "
														>menu <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
												<div class="dropdown-content">

													<table>
													  <tr>
								<td><input style="padding: 9px; font-size: 14px; color:#545454;" type="text" id="txtRoomNoLabel" name="txtRoomNoLabel" value="Room Name" 
									class="txt" size="9" readonly ></td>
								<td><input style="font-size: 14px;color: #181750;" type="text" id="txtRoomNo" name="txtRoomNo" value="<?= $sess_room ?>" 
									class="txt" size="12" readonly></td>
							</tr>
							<tr>
								<td><input style="font-size: 14px;color:#545454;" type="text" id="txtBy" name="txtBy" value="&nbsp;&nbsp;&nbsp;Presenter"  class="txt" size="11" readonly ></td>
								<td><input style="font-size: 14px;color: #181750;"  type="text" id="txtUsername" name="txtUsername" value="<?= $sess_username ?>"  
									class="txt" size="12" readonly></td>
							</tr>
							</table>
							<li class="menu-line"></li>
														<ul style="padding:0; margin:0;list-style: none; position: relative;">
															<li>
																<a href="#">
																	Real Time Mode  &nbsp;&nbsp;&nbsp;
																	<label class="switch">
																		<input id="realTime" type="checkbox">
																		<div class="slider round"></div>
																	</label>
																</a>
															</li>
										 <a id="myBtn"><i class="fa fa-question fa-fw" aria-hidden="true"></i> Question Mode</a>
													<a id="view-score-btn"><i class="fa fa-check-circle-o fa-fw" aria-hidden="true"></i> View Score  </a>
													<li class="menu-line"></li>
												
													<li><a onclick="loadNewFile(); downloadalert();" ><i class="fa fa-download fa-fw" aria-hidden="true"></i> Download File   </a></li>
															<li class="menu-line"></li>
													
													<script>
															function goBack() {
															    window.history.back();
															}
															</script>
													<a onclick="goBack()" ><i class="fa fa-arrow-left fa-fw" aria-hidden="true"></i> Back to Bookshelf </a>
													
													<a href="logout.php?usr=<?= $sess_username ?>" onClick="Logout();"><i class="fa fa-sign-out  fa-fw" aria-hidden="true"></i> Log out   </a>
												  </div>
												</div>
												</ul>
												</div>
												</div>
												</nav>

											
								</div>

								

								<!--	<div class="dropdownn select-main-button menu-btn">
													<button onclick="myFunctionn()" class="dropbtnn btn-new  ">Menu</button>
												<!--	<input type="button" id="menu-bar-Btn" name="menu-bar-Btn" value="menu" onclick="myFunctionn()" class="dropbtnn btn-new ">  
													  <div id="myDropdownn" class="dropdown-contentt ">
													  	<table>
													  <tr>
								<td><input style="padding: 9px; font-size: 14px; color:#545454;" type="text" id="txtRoomNoLabel" name="txtRoomNoLabel" value="Room Name" 
									class="txt" size="9" readonly ></td>
								<td><input style="font-size: 14px;color: #181750;" type="text" id="txtRoomNo" name="txtRoomNo" value="<?= $sess_room ?>" 
									class="txt" size="12" readonly></td>
							</tr>
							<tr>
								<td><input style="font-size: 14px;color:#545454;" type="text" id="txtBy" name="txtBy" value="&nbsp;&nbsp;&nbsp;Presenter"  class="txt" size="11" readonly ></td>
								<td><input style="font-size: 14px;color: #181750;"  type="text" id="txtUsername" name="txtUsername" value="<?= $sess_username ?>"  
									class="txt" size="12" readonly></td>
							</tr>
							</table>
							<li class="menu-line"></li>
													  <a href="#">
																	Real Time Mode  &nbsp;&nbsp;&nbsp;
																	<label class="switch">
																		<input type="checkbox">
																		<div class="slider round"></div>
																	</label>
																</a>
												    <a href="#">Create Group</a>
												    <a id="myBtn">Question Mode</a>
													<a id="view-score-btn">View Score</a>
													<li class="menu-line"></li>
													<a href="#">New Page</a>
													<a href="#">Save File</a>
													<li class="menu-line"></li>
															<script>
															function goBack() {
															    window.history.back();
															}
															</script>
													<a onclick="goBack()">Back to Bookshelf</a>
													<a href="logout.php?usr=<?= $sess_username ?>">Log out</a>
												   
												  </div>
												</div>
										</nav>
								</div>  
                                -->


								<!-- END id="divAnnotationTools" -->
								<!-- ============================================================================================ -->
								<button id="presentationMode" class="toolbarButton presentationMode hiddenLargeView" 
									title="Switch to Presentation Mode" tabindex="12" data-l10n-id="presentation_mode">
								<span data-l10n-id="presentation_mode_label">Presentation Mode</span>
								</button>
								<button id="openFile" class="toolbarButton openFile hiddenLargeView" title="Open File" tabindex="13" 			
									data-l10n-id="open_file">
								<span data-l10n-id="open_file_label">Open</span>
								</button>
								<button id="print" class="toolbarButton print hiddenMediumView" title="Print" tabindex="14" 
									data-l10n-id="print">
								<span data-l10n-id="print_label">Print</span>
								</button>
								<button id="download" class="toolbarButton download hiddenMediumView" title="Download" 
									tabindex="15" data-l10n-id="download">
								<span data-l10n-id="download_label">Download</span>
								</button>
								<!-- <div class="toolbarButtonSpacer"></div> -->
								<a href="#" id="viewBookmark" class="toolbarButton bookmark hiddenSmallView" 
									title="Current view (copy or open in new window)" tabindex="16" data-l10n-id="bookmark">
								<span data-l10n-id="bookmark_label">Current View</span>
								</a>
							</div>
							<div class="outerCenter">
								<div class="innerCenter" id="toolbarViewerMiddle">
									<div class="splitToolbarButton">
										<button id="zoomOut" class="toolbarButton zoomOut" title="Zoom Out" tabindex="9" data-l10n-id="zoom_out">
										<span data-l10n-id="zoom_out_label">Zoom Out</span>
										</button>
										<div class="splitToolbarButtonSeparator"></div>
										<button id="zoomIn" class="toolbarButton zoomIn" title="Zoom In" tabindex="10" data-l10n-id="zoom_in">
										<span data-l10n-id="zoom_in_label">Zoom In</span>
										</button>
									</div>
									<span id="scaleSelectContainer" class="dropdownToolbarButton">
										<select id="scaleSelect" title="Zoom" tabindex="11" data-l10n-id="zoom">
											<option id="pageAutoOption" value="auto" selected="selected" data-l10n-id="page_scale_auto">Automatic Zoom</option>
											<option id="pageActualOption" value="page-actual" data-l10n-id="page_scale_actual">Actual Size</option>
											<option id="pageFitOption" value="page-fit" data-l10n-id="page_scale_fit">Fit Page</option>
											<option id="pageWidthOption" value="page-width" data-l10n-id="page_scale_width">Full Width</option>
											<option id="customScaleOption" value="custom"></option>
											<option value="0.5">50%</option>
											<option value="0.75">75%</option>
											<option value="1">100%</option>
											<option value="1.25">125%</option>
											<option value="1.5">150%</option>
											<option value="2">200%</option>
										</select>
									</span>
								</div>
							</div>
						</div>
						<div id="loadingBar">
							<div class="progress">
								<div class="glimmer">
								</div>
							</div>
						</div>
					</div>
					<!-- Q popup -->
					<div id="myModal" class="modal" >
						<!-- Modal content -->
						<div class="modal-content">
							<div class="modal-header">
								<span id="cls1" class="close">×</span>
								<h2>Choose Question type</h2>
							</div>
							<div class="modal-body">
								<div class="q-btn">
									<div id="choiceBtn" class="choice">
										<img src="images/choice.png">
									</div>
									<div id="fillBtn" class="fill">
										<img src="images/fill.png">
									</div>
									<div id="tfBtn" class="truefalse">
										<img src="images/truefalse.png">
									</div>
								</div>
								<div class="group-mode">
									<div class="mode-space">
										<span>Mode</span> 
									</div>
									<label>  
									<input type="radio" name="mode" value="group">
									Group 
									</label><br>
									<label>
									<input type="radio" name="mode" checked="checked" value="individual">  Individual 
									</label>
								</div>
								<div class="timing">
									<div class="span-time">
										<span>Time</span> 
									</div>
									<input class="input-time" type="input" name="time">
								</div>
								<div class="modal-footer">
									<input id="myBtn1" class="btn btn-q-type " type="submit" value="submit" onclick=""/>
								</div>
							</div>
						</div>
					</div>
						<!-- Multiple Choice model-->
					<div id="choiceModal" class="modal" >
						<!-- Modal content -->
						<div class="modal-content m-c-c">
							<div class="modal-header">
								<span id="cls2" class="close">×</span>
								<h2>Multiple Choice</h2>
							</div>
							<div class="modal-body m-b-c">
								<form action="login_test.php" method="post">
									<div class="input-group">
										<span class="log-pic input-group-addon"></span>
										<input type="text" class="form-control q-box" id="Question" name="login_user" placeholder="Question" required="" data-validation-required-message="Question" required>
									</div>
									<br>
									<div class="input-group">
										<span class="log-pic input-group-addon">
										<input name="ans" value = "C1" type = "radio" required></input>
										</span>
										<input type="text" class="form-control ans-box" id="Choice1" placeholder="Choice 1" required="" data-validation-required-message="Choice " required>
									</div>
									<br>
									<div class="input-group">
										<span class="log-pic input-group-addon">
										<input name="ans"  value = "C2" type = "radio" required></input>
										</span>
										<input type="text" class="form-control ans-box" id="Choice2" placeholder="Choice 2" required="" data-validation-required-message="Choice " required>
									</div>
									<br>
									<div class="input-group">
										<span class="log-pic input-group-addon">
										<input name="ans" value = "C3" type = "radio" required></input>
										</span>
										<input type="text" class="form-control ans-box" id="Choice3" placeholder="Choice 3" required="" data-validation-required-message="Choice " required>
									</div>
									<br>
								
							</div>
							<div class="modal-footer">
								<button  id ="AddmultipleQ" class="log btn btn-primary" href="quizmode.php" value="Add Questions">Add Question</button>
							</div>
							
						</div>
					</div>
					

					<!-- Fill in the blank ModL -->
					<div id="fillModal" class="modal" >
						<!-- Modal content -->
						<div class="modal-content">
							<div class="modal-header">
								<span id="cls3" class="close">×</span>
								<h2>Fill in the blank</h2>
							</div>
							<div class="modal-body">
								<form action="" method="post">
									<div class="input-group">
										<span class="log-pic input-group-addon"></span>
										<input type="text" class="form-control q-box" id="QuestionFill" placeholder="Question"  data-validation-required-message="Question" required>
									</div>
									<br>
									<div class="input-group">
										<span class="log-pic input-group-addon"></span>
										<input type="text" class="form-control ans-fill-box" id="Fillans" placeholder="Ans"  data-validation-required-message="Choice " required>
									</div>
								
							</div>
							</form>
							<div class="modal-footer">
								<button  id ="AddFillQ" class="log btn btn-primary" href="quizmode.php"  value="Add Questions">Add Question</button>
							</div>
							
						</div>
					</div>
					<!-- True or false Mode -->
					<div id="tfModal" class="modal" >
						<!-- Modal content -->
						<div class="modal-content">
							<div class="modal-header">
								<span id="cls4" class="close">×</span>
								<h2>True or False</h2>
							</div>
							<div class="modal-body">
								<form action="" method="post">
									<div class="input-group">
										<span class="log-pic input-group-addon"></span>
										<input type="text" class="form-control q-box" id="QuestionTF" name="login_user" placeholder="Question" required="" data-validation-required-message="Question">
									</div>
									<br>
									<div class="input-group" >
										<!--<span class="log-pic input-group-addon">-->
										<span class="ans-true">
										<input name="ans" value = "true" type = "radio" required>     True</input>
										</span>
									</div>
									<br>
									<div class="input-group">
										<!--<span class="log-pic input-group-addon">-->
										<span class="ans-false">
										<input name="ans"  value = "false" type = "radio"  required>     False</input>
										</span>
									</div>
							
							</div>
							<div class="modal-footer">
								<button  id ="AddTFQ" class="log btn btn-primary" href="quizmode.php" value="Add Questions">Add Question</button>
							</div>
								
						</div>
					</div>
					<!-- score popup -->
					<div id="scoreModal" class="modal" >
						<!-- Modal content -->
						<div class="modal-content">
							<div class="modal-header">
								<span id="cls5" class="close">×</span>
								<h2>Score</h2>
							</div>
							<div class="modal-body" style="border: none;">
								<form action="" method="post">
									<div class="input-group">

										<h4 style="color: rgb(89, 89, 89); margin-bottom: 2px;"> Question </h4>
										<label class="form-control" id="showQuestion" ></label>
									</div>
									<br>
									<h4 style="color: rgb(89, 89, 89); margin-bottom: 2px; margin-top: 5px"> Answer </h4>
									<div class="input-group">
										
										<h6>Correct Answer <i class="fa fa-check" aria-hidden="true" style="color: green"></i></h6>
										<p type="text" class="form-control" id="correctScore"></p>
									</div>
									<br>
									<div class="input-group">
										<h6>Incorrect Answer <i class="fa fa-times" aria-hidden="true" style="color: red"></i></h6>
										<p type="text" class="form-control" id="incorrectScore"></p>
									</div>
							</div>
							<div class="modal-footer">
							</div>
							</form>
						</div>
					</div>
				</div>
				<menu type="context" id="viewerContextMenu">
					<menuitem id="contextFirstPage" label="First Page" data-l10n-id="first_page"></menuitem>
					<menuitem id="contextLastPage" label="Last Page" data-l10n-id="last_page"></menuitem>
					<menuitem id="contextPageRotateCw" label="Rotate Clockwise" data-l10n-id="page_rotate_cw"></menuitem>
					<menuitem id="contextPageRotateCcw" label="Rotate Counter-Clockwise" data-l10n-id="page_rotate_ccw"></menuitem>
				</menu>
				<div id="viewerContainer" class="view-hori"  tabindex="0" onClick ="turnOnRealtimeMode()">
					<div id="viewer" style=""></div>
				</div>
				<div id="errorWrapper" hidden='true'>
					<div id="errorMessageLeft">
						<span id="errorMessage"></span>
						<button id="errorShowMore" data-l10n-id="error_more_info">
						More Information
						</button>
						<button id="errorShowLess" data-l10n-id="error_less_info" hidden='true'>
						Less Information
						</button>
					</div>
					<div id="errorMessageRight">
						<button id="errorClose" data-l10n-id="error_close">
						Close
						</button>
					</div>
					<div class="clearBoth"></div>
					<textarea id="errorMoreInfo" hidden='true' readonly></textarea>
				</div>
			</div>
			<!-- mainContainer -->
			<div id="overlayContainer" class="hidden">
				<div id="promptContainer">
					<div id="passwordContainer" class="prompt doorHanger">
						<div class="row">
							<p id="passwordText" data-l10n-id="password_label">Enter the password to open this PDF file:</p>
						</div>
						<div class="row">
							<input type="password" id="password" class="toolbarField" />
						</div>
						<div class="row">
							<button id="passwordCancel" class="promptButton"><span data-l10n-id="password_cancel">Cancel</span></button>
							<button id="passwordSubmit" class="promptButton"><span data-l10n-id="password_ok">OK</span></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- outerContainer -->
		<div id="printContainer"></div>
	</body>
	<script type="text/javascript">
		var modal = document.getElementById('myModal');
		var choice1 = document.getElementById('choiceModal');
		var fill1 = document.getElementById('fillModal');
		var tf1 = document.getElementById('tfModal');
		
		var score = document.getElementById('scoreModal');
		
		// Get the button that opens the modal
		var btn = document.getElementById("myBtn");
		var btn1 = document.getElementById("choiceBtn");
		var btn2 = document.getElementById("fillBtn");
		var btn3 = document.getElementById("tfBtn");
		
		var scorebtn = document.getElementById("view-score-btn");
		
		// Get the <span> element that closes the modal
		var cls1 = document.getElementsByClassName("close")[0];
		var cls2 = document.getElementsByClassName("close")[1];
		var cls3 = document.getElementsByClassName("close")[2];
		var cls4 = document.getElementsByClassName("close")[3];
		
		// When the user clicks the button, open the modal
		btn.onclick = function() {
			cancelWriteNote();
		    modal.style.display = "block";
		}
		var GModearr=[];
		//open choice
		btn1.onclick = function() {
			 modal.style.display = "none";
		    choice1.style.display = "block";
		    var GMode = ($('input[name=mode]:checked').val());
			GModearr.push(GMode);
		
		}
		//open fill 
		btn2.onclick = function() {
			 modal.style.display = "none";
		    fill1.style.display = "block";
		    var GMode = ($('input[name=mode]:checked').val());
			GModearr.push(GMode);
		
		}
		
		//open true false 
		btn3.onclick = function() {
			 modal.style.display = "none";
		    tf1.style.display = "block";
		    var GMode = ($('input[name=mode]:checked').val());
			GModearr.push(GMode);
			
		
		}
		
		//view score
		scorebtn.onclick = function() {
			cancelWriteNote();
		    score.style.display = "block";
		}
		
		// When the user clicks on <span> (x), close the modal
		cls1.onclick = function() {
			GModearr.length = 0;
		    modal.style.display = "none";
		    //GModearr.length = 0;
		}
		cls2.onclick = function() {
		    choice1.style.display ="none"
		    GModearr.length = 0;
		}
		cls3.onclick = function() {
		    fill1.style.display ="none"
		    GModearr.length = 0;
		}
		cls4.onclick = function() {
		    tf1.style.display ="none"
		    GModearr.length = 0;
		}
		
		cls5.onclick = function() {
		    score.style.display ="none"
		    GModearr.length = 0;
		}
		
		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		    if (event.target == modal ) {
		        modal.style.display = "none";
		
		    }
		}
		
		window.onclick = function(event) {
		    if (event.target == choice1 ) {
		        choice1.style.display = "none";
		
		    }
		}
		
		window.onclick = function(event) {
		    if (event.target == fill1 ) {
		        fill1.style.display = "none";
		
		    }
		}
		
		window.onclick = function(event) {
		    if (event.target == tf1 ) {
		        tf1.style.display = "none";
		
		    }
		}
		
		window.onclick = function(event) {
		    if (event.target == score ) {
		        score.style.display = "none";
		
		    }
		}
		//=========end pop up======================//
		
	</script>
	<script>
		//========Quiz mode ===================//
		//MULTI
		
		var MP1 = $('#Question');
				var MP2 = $('#Choice1'); 
				var MP3 = $('#Choice2'); 
				var MP4 = $('#Choice3'); 
		$('#view-score-btn').click(function(){
			var RoomNo = $("#txtRoomNo").val(); 
			CollectScore(RoomNo);
		});
		
		
		$('#AddmultipleQ').click(function(){
				SubmitMultipleQuestion();
				choice1.style.display ="none";
				GModearr.length = 0;
				 $('#Question').val('');
		         $('#Choice1').val('');
		         $('#Choice2').val('');
		         $('#Choice3').val('');
		         
		
		});
		
		/*$('#submitmultipleBtn').click(function(){
			    SubmitMultipleQuestion();
			
			});*/
		
		
		
			//TF
		
			var TF1 = $('#QuestionTF');
				 
				 
		
		$('#AddTFQ').click(function(){
				SubmitTFQuestion();
				tf1.style.display ="none";
				GModearr.length = 0;
				$('#QuestionTF').val('');
		        
		
		});
		
		/*$('#submitTFBtn').click(function(){
			    SubmitTFQuestion();
			
		
			});*/
		
		
		var Fill1 = $('#QuestionFill');
		var Ans = $('#Fillans'); 
				 
		
		
		$('#AddFillQ').click(function(){
				SubmitFillQuestion();
				fill1.style.display ="none";
				GModearr.length = 0;
		        $('#QuestionFill').val('');
		        $('#Fillans').val('');
		});
		var check=0;
		var arrRealTime =[];
		 $('#realTime').click(function(event) {
		                    // Iterate each checkbox
		                    
		                    if(check == 0 ){  
		                        $('.select').prop('checked', true);  
		                        check = 1; 
		                        arrRealTime.push(check);
		                    } else { 
		                        $('.select').prop('checked', false);  
		                        check = 0; 
		                        arrRealTime.length=0;
		                    }
		                });
		
		function turnOnRealtimeMode(){
			if(arrRealTime!=0){
				saveNote();
			}
		}
		/*
		$('#submitFillBtn').click(function(){
			    SubmitFillQuestion();
			
			});*/
		
		//get Mode for viewers
		
		
	</script>
	<script>
		/* When the user clicks on the button,
		toggle between hiding and showing the dropdown content */
		function myFunctionn() {
		    document.getElementById("myDropdownn").classList.toggle("showw");
		}
		
		// Close the dropdown if the user clicks outside of it
		window.onclick = function(event) {
		  if (!event.target.matches('.dropbtnn')) {
		
		    var dropdowns = document.getElementsByClassName("dropdown-contentt");
		    var i;
		    for (i = 0; i < dropdowns.length; i++) {
		      var openDropdown = dropdowns[i];
		      if (openDropdown.classList.contains('showw')) {
		        openDropdown.classList.remove('showw');
		      }
		    }
		  }
		}
	</script>

<script type="text/javascript">
	function hide(target) {
    document.getElementById(target).style.display = 'none';
}
</script>

<script >
	function downloadalert() {
    alert("Download Complete !");
}
</script>
</html>