<?php 
    session_start(); 
    include("config.php");
    $room_id = $_GET['room_id'];
    $room_name = $_GET['room_name'];
?>
<!doctype html>
<html>
    <head>
        <title>bookshelf</title>
        <!-- <link rel="stylesheet" type="text/css" href="bookcase/css/bookshelf3.css"> -->
        <link rel="stylesheet" type="text/css" href="bookcase/css/bookshelf.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script type="text/javascript" src="jquery/js/jquery-1.9.1.js"></script> 
        
        
    </head>
    <body class="body">
       
        <div class="header">
            <div class="col-xs-12" >
                <div class="col-xs-1" style="padding-top: 8px; z-index: 999;">
                    <form action="Controller/fileController.php?action=uploadFile&room_name=<?php echo $room_name;?>&room_id=<?php echo $room_id;?>" method="post" enctype="multipart/form-data">
                        <!-- <input type="image" src="bookcase/img/add.png"> -->
                        <input class="upload" type="file" name="file" style="float: left;">
                        <input type="submit" class="upload-btn" value="Upload" style="position: absolute; right: -300px; z-index: 999;"> 
                    </form>
                </div>
                <div class="col-xs-7 head" style="padding-left: 250px;">
                    <center>
                        <h4>
                            <?php 
                                $room_name = $_GET['room_name'];
                                echo $room_name;
                            ?>
                        </h4>
                    </center>
                </div>
                 <div class="col-xs-1 fileUpload select-com" style="width: 10%; padding:0; margin-left: -5%;">
                    <button class="btn btn-default navbar-btn" id="selectBtn" style="width: 100%; font-size:1em;">SELECT</button>
                </div>
                <div class="col-xs-1 fileUpload menu-select" style="width: 120px">
                    <button class="btn btn-info navbar-btn" id="selectAllBtn" style="width: 100%;font-size: 1em;display: inline-block;padding: 0;margin: 8px 0 0 0;">SELECT ALL</button>
                     <form action="Controller/fileController.php?action=deleteFile&room_name=<?php echo $room_name;?>&room_id=<?php echo $room_id;?>" method="post">

                <input type="submit" class="btn btn-danger navbar-btn" id="deleteBtn" value="DELETE" style="width: 90px;/* font-size: 1em; */display: inline-block;padding: 0;margin: 2px 0 0 0;">
                
                </div>
                <div class="col-xs-1 fileUpload" style="">
                    
                </div>
                 <div class="col-xs-1 fileUpload LogoutBtn-com" style="position: absolute; right: 20px;width: 100px;">
                    <!-- <form action="Controller/roomController.php?action=outRoom" method="post">
                        <input type="submit" class="btn btn-warning navbar-btn" value="LOGOUT">
                    </form> -->
                    <a href="Controller/roomController.php?action=outRoom">
                        <input type="submit" class="btn btn-warning navbar-btn" value="LOGOUT" style=" font-size:1em; ">
                    </a>
                </div>
            </div>
        </div>
        
        <div>
           

          
                <div class="col-md-12" style="top: 10px;">
                    <?php 
                        $con = new connect();
                        $connect = $con -> getConnection();
                        
                        $selFile = "SELECT * FROM file_info WHERE ROOMID ='$room_id'";
                        $rsSelFile = mysqli_query($connect, $selFile) or die("SELECT ERROR: ". mysqli_error($connect)); 
                
                        while ($data = mysqli_fetch_array($rsSelFile)){
                            $file_id = trim($data['FILEID']);
                            $file_name = trim($data['FILE_NAME']);
                        ?>
                    <div class="col-xs-4 file"id="filename">
                        <input type="checkbox" class="select" name="select[]" value="<?php echo $file_id; ?>"> 
                        <center>
                            <p><?php echo $file_name;?></p>
                        </center>    
                        <center>
                            <h3>
                                <!-- <form action="Controller/fileController.php?action=enterToFile&room_id=<?php echo $room_id;?>&file_id=<?php echo $file_id;?>&room_name=<?php echo $room_name;?>&file_name=<?php echo $file_name;?>" method="post" enctype="multipart/form-data"> -->
                                    <a type="submit" href="Controller/fileController.php?action=enterToFile&room_id=<?php echo $room_id;?>&file_id=<?php echo $file_id;?>&room_name=<?php echo $room_name;?>&file_name=<?php echo $file_name;?>">
                                        <img src="img/pdf-icon.png" style="width: 30%;">
                                    </a>
                                <!-- </form> -->
                            </h3>
                        </center>
                    </div>
                    <?php
                        }
                    ?>
                     <img src="bookcase/img/shelf2.png" class="content">
            <img src="bookcase/img/shelf.png" class="content2">
            <div class="spr"></div>
            <img src="bookcase/img/shelf.png" class="content3">
            <div class="spr"></div>
            <img src="bookcase/img/shelf.png" class="content4">
                </div>
            </form>
        </div>
        <div class="footer"></div>

        <script type="text/javascript">
            $('.select').hide();
            $('#deleteBtn').hide();
            $('#selectAllBtn').hide();
            $(function(){
                $('#selectBtn').click(function() {
                    $('.select').toggle();
                    $('#deleteBtn').toggle();
                    $('#selectAllBtn').toggle();
                });
            });
            var check = 0;
            $(function(){
                $('#selectAllBtn').click(function(event) {
                    // Iterate each checkbox
                    
                    if(check == 0 ){  
                        $('.select').prop('checked', true);  
                        check = 1; 
                    } else { 
                        $('.select').prop('checked', false);  
                        check = 0; 
                    }
                });
            });

        </script>
    </body>
</html>