
<?php

$ipaddress = "172.16.25.65";//$SERVER_ADDR;
$ip = $ipaddress;//basename( $_FILES['uploadedfile']['ip']);
$target_path  = "//".$ip."/pdf/temp/";
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
{
    echo "The file ".  basename( $_FILES['uploadedfile']['name'])." has been uploaded";
} 
else
{
    echo "There was an error uploading the file, please try again!";
}

    

?>