
<?php
include("../config.php");
$con = new connect();
$connect = $con -> getConnection();

if( !isset( $_POST['txtUsername'] ) ) $txtUsername = "";
else $txtUsername = trim(strtoupper($_POST['txtUsername']));

if( !isset( $_POST['txtRoomNo'] ) ) $txtRoomNo = "";
else $txtRoomNo = trim(strtoupper($_POST['txtRoomNo']));

if( !isset( $_POST['hidFilename'] ) ) $strFilename = "";
else $strFilename =  trim($_POST['hidFilename']);

if( !isset( $_POST['hidFileid'] ) ) $hidFileid = "";
else $hidFileid = trim($_POST['hidFileid']);

$strPathPdfFile = "../pdf/temp/" . $strFilename ;

//============================================================================================	
$selectSQL = "SELECT DISTINCT A.ANNOTATION_TEXT, A.PAGE_NO "
	."FROM ANNOTATION AS A, ANNOTATION_DISP AS DISP "
	."WHERE A.ROOM_NO = '$txtRoomNo' "
	." AND A.FILEID = '$hidFileid' "
	."AND DISP.USERNAME = '$txtUsername' "
	."AND DISP.CHECKED = 'Y' "
	."AND A.ANNOTATION_OWNER = DISP.OWNER "
	."AND A.PAGE_NO = DISP.PAGE_NO ";
	
//echo ">> SQL: " .$selectSQL. "<br>"; 	

$rsSelect = mysqli_query($connect,$selectSQL) or die(mysqli_error($connect));
$rowSelect = mysqli_num_rows($rsSelect);



require_once('../script/fpdf/fpdf.php');
require_once('../script/fpdi/fpdi.php');
define('FPDF_FONTPATH','font/');

$pdf = new FPDI();
$pageCount = $pdf->setSourceFile($strPathPdfFile);
$strPathImgNote = "";
//============================================================================================	
for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
	// import a page
	$templateId = $pdf->importPage($pageNo);
	// get the size of the imported page
	$size = $pdf->getTemplateSize($templateId);

	// create a page (landscape or portrait depending on the imported page size)
	if ($size['w'] > $size['h']) {
		$pdf->AddPage('L', array($size['w'], $size['h']));
	} else {
		$pdf->AddPage('P', array($size['w'], $size['h']));
	}
	
	$image_height = $size['h'];
	$image_width = $size['w'];
	
	// use the imported page
	$pdf->useTemplate($templateId);
	
	//echo ">> page_no(pdf)=" . $pageNo .  "<br>";
	mysqli_data_seek ($rsSelect, 0);
	while($data = mysqli_fetch_assoc($rsSelect)){
		$strNoteImg = trim($data['ANNOTATION_TEXT']);
		$strPageNo = trim($data['PAGE_NO']);
		
		//echo ">>" .  "<br>"; 
		//echo ">> page_no(DB)=" .$strPageNo.  ", page_no(pdf)=" . $pageNo .  "<br>";
		
		if($strPageNo == $pageNo){
			$strPathImgNote = "../images_annotation/" . $strNoteImg;
				
			//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
			$pdf->Image($strPathImgNote,0,0,$image_width,$image_height,'','');	
			
			//echo "==========================================================" .  "<br>"; 
			//echo ">> note=" .$strNoteImg . ", page_no=" .$strPageNo.  "<br>";
			//echo "==========================================================" .  "<br>"; 
		}//END if page number of pdf file = page number of note image 
		
	}//END For loop
}//END For loop all pageNo of PDF file
	
mysqli_close($connect);
//============================================================================================		
// Output the new PDF
$UploadedFilename = substr($strFilename, 0, -4) ."_". $txtUsername .".pdf";
$strPathOutput = "../pdf/uploaded/" . $UploadedFilename;
$pdf->Output($strPathOutput,"F");
	
?>

<input type="hidden" id="hidFilenameDownloaded" name="hidFilenameDownloaded" value="<?= $UploadedFilename ?>">

