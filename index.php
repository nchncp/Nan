<?php session_start(); include("config.php");?>
<!doctype html>
<!--[if lt IE 7]>      
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="">
    <![endif]-->
    <!--[if IE 7]>         
    <html class="no-js lt-ie9 lt-ie8" lang="">
        <![endif]-->
        <!--[if IE 8]>         
        <html class="no-js lt-ie9" lang="">
            <![endif]-->
            <!--[if gt IE 8]><!--> 
            <html class="no-js" lang="">
                <!--<![endif]-->
                <head>
                    <meta charset="utf-8">
                    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
                    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                    <title>U-Note </title>
                    <meta name="description" content="">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="apple-touch-icon" href="apple-touch-icon.png">
                    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
                    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
                    <link rel="stylesheet" href="css/normalize.min.css">
                    <link rel="stylesheet" href="css/bootstrap.min.css">
                    <link rel="stylesheet" href="css/jquery.fancybox.css">
                    <link rel="stylesheet" href="css/flexslider.css">
                    <link rel="stylesheet" href="css/styles.css">
                    <link rel="stylesheet" href="css/queries.css">
                    <link rel="stylesheet" href="css/etline-font.css">
                    <link rel="stylesheet" href="bower_components/animate.css/animate.min.css">
                    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
                    
                    <script type="text/javascript" src="jquery/js/jquery-1.9.1.js"></script> 
                    <script type="text/javascript" src="jquery/js/jquery-ui-1.10.3.custom.js"></script>
                   
                    
                    <script type="text/javascript" src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
                    <script type="text/javascript" src="js/jquery.js"></script>

                    <script type="text/javascript">
                    
                        function clickButton(){
                            /*if(chkUsername() == false) return false;
                            if(chkPassword() == false) return false;
                            if(chkRoom() == false) return false;
                            if(chkRoomCode() == false) return false;
                            document.getElementById("trMsg").hidden = true;
                            document.getElementById("hidAction").value = "click";*/
                            
                            /*var user = document.getElementById("username").value;*/
                            var user_id = <?php echo json_encode($_SESSION['sess_user_id'])?>;
                            var user = <?php echo json_encode($_SESSION['sess_username'])?>;
                            var pwd = <?php echo json_encode($_SESSION['sess_password']) ?>;
                            /*var room = <?php echo json_encode($_SESSION['sess_room_name']) ?>;
                            var room_code = <?php echo json_encode($_SESSION['sess_password_room']) ?>;*/
                            var selRoom = document.getElementById("selPresentationRoom").value;
                            var action = document.getElementById("hidAction").value;
                            /*var pwd = document.getElementById("password").value;
                            var room = document.getElementById("room_name").value;
                            var room_code = document.getElementById("password_room").value;
                            var filename = document.getElementById("hidFilename").value;
                            var selRoom = document.getElementById("selPresentationRoom").value;
                            var action = document.getElementById("hidAction").value;*/
                            
                            $.ajax({
                                type: "POST",
                                url: getContextPath() + "Controller/userController.php",
                                data: { user_id: user_id,
                                        username: user,
                                        password: pwd ,
                                        /*room_name: room,
                                        password_room: room_code,
                                        sess_hidFilename:filename,*/
                                        selPresentationRoom: selRoom,
                                        hidAction: action           
                                },
                                success: function(data){
                                    console.log("Hello" + data);
                                    window.location.href = 'vpresent.php';
                                    /*$('#divShowData').html(data);
                                    var strMsg = document.getElementById("hidMsg").value;
                                    
                                    if(strMsg != "" && strMsg != "finished"){
                                        document.getElementById("trMsg").hidden = false;
                                        document.getElementById("spanMsg").innerHTML = strMsg;

                                    }else if(strMsg == "finished"){*/
                                        /*window.location.href = 'vpresent.php';*/
                                    /*}*/
                                },
                                error:function(){
                                    console.log("index.php: Error to login !!!");
                                }
                            });
                            
                        }// END clickPresent()
                        $(document).ready(function(){
                            $('#btnLogin').click(function(){
                                clickButton();
                                /*window.location.href = 'vpresent.php';*/
                            });
                        });
                    </script>
                    <script type="text/javascript">

                    $( document ).ready(function() {
                        // onload page 
                        /*document.getElementById("trMsg").hidden = true;
                        document.getElementById("hidAction").value = "";*/
                        getListPresentationRoom();
                        //Presenter
                        /*if(document.getElementById("btnLogin").value == "PRESENT"){
                            document.getElementById("txtRoomCode").hidden = false;
                            $("#trPresenterRoom").show();
                            $("#trViewerRoom").hide();
                        }//END Presenter
                        else{
                            //Viewer
                            document.getElementById("txtRoomCode").hidden = true;
                            document.getElementById("trChkRoomCode").hidden = true;
                            $("#trPresenterRoom").hide();
                            $("#trViewerRoom").show();
                        }//END Viewer*/
                        
                    });
                        function getListPresentationRoom(){
                            var url = getContextPath() + "PHPScript/ListPresentationRoomConn.php";

                            var xmlhttp;
                            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                                xmlhttp = new XMLHttpRequest();
                            }else { // code for IE6, IE5
                                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                            }
                            xmlhttp.onreadystatechange = function() {
                                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                    $('#spanPresentationRoom').html(xmlhttp.responseText);
                                }
                            }
                            xmlhttp.open("POST",url,true);
                            xmlhttp.send();
                        }// END getListPresentationRoom()

                       
                         var $data = new Array();
                         
                        function getContextPath() {
                            var ctx = window.location.pathname,
                                path = '/' !== ctx ? ctx.substring(0, ctx.indexOf('/', 1) + 1) : ctx;
                            return path + (/\/$/.test(path) ? '' : '/');
                        }

                        function GetXmlHttpObject() {
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


                        function resetMsgError(){
                            document.getElementById("trMsg").hidden = true;
                            document.getElementById("spanMsg").innerHTML = "";  
                            
                        }// END resetMsgError()

                        function chkUsername(){
                            if( document.getElementById("username").value == "" ){
                                document.getElementById("username").focus();
                                document.getElementById("trMsg").hidden = false;
                                document.getElementById("spanMsg").innerHTML = "Please enter username !";
                                return false;
                            }
                            return true;    
                        }//END chkUsername()

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
                                
                            }else if(document.getElementById("password").value != ""        &&
                                     document.getElementById("txtRePassword").value != ""   &&
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
                            var user = <?php echo json_encode($_SESSION['sess_username']) ?>;
                            var pwd = <?php echo json_encode($_SESSION['sess_password']) ?>;
                            /*var room = <?php echo json_encode($_SESSION['sess_room_name']) ?>;
                            var room_code = <?php echo json_encode($_SESSION['sess_password_room']) ?>;*/
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
                                url: getContextPath() + "Controller/userController.php",
                                data: { username: user,
                                        password: pwd ,
                                        /*room_name: room,
                                        password_room: room_code,
                                        sess_hidFilename:filename,*/
                                        selPresentationRoom: selRoom,
                                        hidAction: action                      
                                },
                                success: function(data){
                                    
                                    /*$('#divShowData').html(data);
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
                                    }*/

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

                    </script>
                </head>
                <body id="top">
                    <!--[if lt IE 8]>
                    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
                    <![endif]-->
                    <section class="hero">
                        <section class="navigation">
                            <header>
                                <div class="header-content">
                                    <div class="logo"><a href="#"><img src="img/u-note_hand2.png" alt="unote logo"></a></div>
                                    <div class="header-nav">
                                        <nav>
                                            <ul class="primary-nav">
                                                <li><a href="#features">Features</a></li>
                                                <li><a href="#about">About</a></li>
                                                <li><a href="#contact">Contact</a></li>
                                            </ul>
                                            <ul class="member-actions">
                                                <?php if(isset($_SESSION['sess_username']) && !empty($_SESSION['sess_username'])) { ?>
                                                    
                                                    <li><a type="submit" class="login" data-toggle="modal" href=""><?php echo $_SESSION['sess_username'];?></a></li>
                                                    <li><a class="room" data-toggle="modal" data-target="#exampleModal-profile" href="">Profile</a></li>
                                                    <!-- <li><a href="logout.php?usr=<?= $sess_username ?>" class="btn-white btn-small" onClick="Logout();">LOG OUT</a></li> -->
                                                    <!-- <li><a class="btn-white btn-small" href="Controller/userController.php?action=logout&user_id=<?php echo $user_id;?>">LOG OUT</a></li> -->
                                                    <li><a href="logout.php?usr=<?= $sess_username ?>" class="btn-white btn-small" onClick="Logout();">LOG OUT</a></li>         
                                                <?php } else { ?>
                                                    <li><a type="submit" class="login" data-toggle="modal" data-target="#exampleModal-login" href="">LOGIN</a></li>
                                                    <li><a type="submit" class="btn-white btn-small" data-toggle="modal" data-target="#exampleModal-signup" href="">SIGN UP</a></li>
                                                <?php } ?>
                                            </ul>
                                        </nav>
                                    </div>

                                    <div class="modal fade" id="exampleModal-profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h3 class="modal-title" id="exampleModalLabel">
                                                        &nbsp;&nbsp;&nbsp;&nbsp;All Create room</h3>
                                                </div>
                                                
                                                <div class="modal-body">
                                                    <?php
                                                        $con = new connect();
                                                        $connect = $con -> getConnection();
                                                        
                                                        $user_id = $_SESSION['sess_user_id'];
                                                        $selAllRoom = "SELECT ROOM_NAME, ROOMID FROM room_info WHERE '$user_id' = USERID";
                                                        
                                                        $rsSelAllRoom = mysqli_query($connect, $selAllRoom) or die(mysqli_error($connect));

                                                        while ($data = mysqli_fetch_array($rsSelAllRoom)){
                                                            $room_name = trim($data['ROOM_NAME']);
                                                            $room_id = trim($data['ROOMID']);
                                                    ?>
                                                        <a style="color: black;" href="bookshelf.php?action=selectFile&room_name=<?php echo $room_name;?>&room_id=<?php echo $room_id;?>" ><?php echo $room_name;?></a>
                                                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        &times;</button> -->
                                                        <a href="Controller/fileController.php?action=deleteRoom&room_id=<?php echo $room_id;?>&room_name=<?php echo $room_name;?>" style="color: #989898; right:0px; position: absolute; padding-right:10px;">&times;</a>
                                                        </br>
                                                        
                                                        <input type="hidden" name="room_name" value="<?php echo $room_name;?>">
                                                        <!-- <input type="hidden" name="room_name"> -->
                                                        <input type="hidden" name="room_id" value="<?php echo $room_id;?>">
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="exampleModal-login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h3 class="modal-title" id="exampleModalLabel">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;LOG IN</h4>
                                                </div>
                                                <form action="Controller/userController.php?action=login" method="post">
                                                    <div class="modal-body">
                                                        <div class="input-group">
                                                            <span class="log-pic input-group-addon"><i class="fa fa-envelope"></i></span>
                                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required data-validation-required-message="Please Enter Username">
                                                        </div>
                                                        <br>
                                                        <div class="input-group">
                                                            <span class="log-pic input-group-addon"><i class="fa fa-lock"></i></span>
                                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required data-validation-required-message="">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input class="log btn btn-primary" type="submit" value="LOG IN"/>  
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="exampleModal-signup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h3 class="modal-title" id="exampleModalLabel">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIGN UP</h4>
                                                </div>
                                                <form action="Controller/userController.php?action=signup" method="post" class="form-horizontal">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        
                                                            <div class="in more form-group">
                                                                <label for="user" class="col-sm-4 control-label">Username</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="space form-control" id="username" name="username" required data-validation-required-message="">
                                                                </div>
                                                            </div>
                                                            <div class="in more form-group">
                                                                <label for="email" class="col-sm-4 control-label">Email</label>
                                                                <div class="col-sm-8">
                                                                    <input type="email" class="space form-control" id="email" name="email" required data-validation-required-message="">
                                                                </div>
                                                            </div>
                                                            <div class="in more form-group">
                                                                <label for="pass" class="col-sm-4 control-label">Password</label>
                                                                <div class="col-sm-8">
                                                                    <input type="password" class="space form-control" id="password" name="password" required data-validation-required-message="">
                                                                </div>
                                                            </div>
                                                            <div class="in more form-group">
                                                                <label for="con-pass" class="col-sm-4 control-label">Confirm Password</label>
                                                                <div class="col-sm-8">
                                                                    <input type="password" class="space form-control" id="re_password" name="re_password" required data-validation-required-message="">
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input class="sig btn btn-primary" type="submit" value="SIGN UP" onclick=""/>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="navicon">
                                        <a class="nav-toggle" href="#"><span></span></a>
                                    </div>
                                </div>
                            </header>
                        </section>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="hero-content text-center">
                                        <div  align="center" ><img class = "index-Logo" src="img/u-noteLogo.png"/></div>
                                        <?php if(isset($_SESSION['sess_username']) && !empty($_SESSION['sess_username'])) { ?>
                                            <p></p>
                                            <p></p>
                                            <a type="submit" class="btn-fill btn-accent btn-large" data-toggle="modal" data-target="#join-room" data-whatever="joinroom" href="">Join Room</a> 
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a type="submit" class="btn-fill btn-accent btn-large margin-Top" data-toggle="modal" data-target="#create-room" data-whatever="createroom" href="">Create Room</a>             
                                        <?php } else { ?>
                                            <p></p>
                                            <p></p>
                                            <h1>Create, Collaborate, Share!</h1>
                                            <p class="intro">Introducing “UNote”. A presentation web application on the local LAN or via Internet.</p>
                                        <?php } ?>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="join-room" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h3 class="modal-title" id="exampleModalLabel">
                                    &nbsp;&nbsp;&nbsp;&nbsp;Join Room</h4>
                                </div>
                                <form action="Controller/fileController.php?action=joinRoom&room_id=<?php echo $room_id;?>&room_name=<?php echo $room_name;?>" method="post">
                                <div class="modal-body">
                                        <div class="input-group">
                                            <span class="log-pic input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                                            <input type="text" class="form-control" id="room_name" name="room_name" placeholder="Search">
                                        </div>
                                        <br>
                                        <select class="form-control filterable-select" placeholder="Select room" data-native-menu="false"
                                             id="selPresentationRoom" name="selPresentationRoom" style="width:90%;" onChange="chkError();">
                                        <option value="">Select presentation room</option>
                                            <?php
                                            
                                            $con = new connect();
                                            $connect = $con -> getConnection();

                                            $selPresentationRoomSQL = "SELECT ROOM_NAME,PRIVATE_CODE FROM room_info WHERE ROOM_STATUS = 'ON'";
                                            
                                            /*$selPresentationRoomSQL = "SELECT F.ROOM_NAME FROM room_info AS F, user_account AS U , status AS S " 
                                                                     ."WHERE  U.user_id = F.user_id "
                                                                     ."AND F.user_id = S.user_id "
                                                                     ."AND F.ROOM_STATUS = 'ON'"
                                                                     ."AND S.USERSTATUS='P' ";*/

                                            $rsSelPresentationRoom = mysqli_query($connect, $selPresentationRoomSQL) or die("Select Presentation Room error: ". mysqli_error());

                                            while ($row = mysqli_fetch_array($rsSelPresentationRoom)){
                                                $presentation_room = trim($row['ROOM_NAME']);
                                                $password_room = trim($row['PRIVATE_CODE']);
                                                echo '<option value="'.$presentation_room.'">'.$presentation_room.'</option>';
                                            }//END while loop
                                            //=================================================================================================================
                                            mysqli_close($connect);
                                            ?>
                                        </select>
                                        <input class="form-control" type="text" name="password_room"  id="password_room" placeholder="Room code e.g.,12345" 
                                            value="" onKeyPress="resetMsgError();" >

                                </div>
                                <div class="modal-footer">
                                    <!-- <input class="log btn btn-primary" type="submit" value=" &nbsp;Join&nbsp;"/> -->
                                    <!-- <input class="log btn btn-primary" type="button" name="btnLogin" id="btnLogin" value="<?=$btnValue ?>" onClick="clickButton();"> -->
                                    <input type="hidden" name="password_name" value="<?php echo $password_room;?>">
                                    <input class="log btn btn-primary" type="submit" name="btnLogin" id="btnLogin" value="JOIN" />

                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="create-room" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h3 class="modal-title" id="exampleModalLabel">
                                    &nbsp;&nbsp;&nbsp;&nbsp;Create room</h4>
                                </div>
                                
                                    <form action="Controller/roomController.php?action=createRoom&room_name=<?php echo $room_name;?>&room_id=<?php echo $room_id;?>" method="post">
                                <div class="modal-body">        
                                    <div class="input-group">
                                        <span class="log-pic input-group-addon"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="room_name" id="room_name" placeholder="Room name">
                                    </div><br>
                                    <div class="input-group" style="width: 100%">
                                        <!-- <span class="log-pic input-group-addon"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" id="room-name" placeholder="Room name"> -->

                                   <script type="text/javascript">

                                            function statusCheck() {

                                                if (document.getElementById('privateCheck').checked) {//private
                                                    /*document.getElementById('ifPrivate').style.display = 'block';*/
                                                    $('#ifPrivate').show();  
                                                    console.log("true");
                                                    // $('#password_room').attr('disabled', 'disabled');
                                                    //$("#password_room").prop("disabled", true)
                                                   // document.getElementById("ifPrivate").disabled = false;
                                                    //$('#password_room').disabled = false;
                                                }
                                                else{//public
                                                    console.log("false");
                                                   // $('#password_room').removeAttr('disabled');
                                                    
                                                    //$('#ifPrivate').hide();
                                                  
                                                    
                                                    /*document.getElementById('ifPrivate').style.display = 'none';*/  
                                                } 

                                            }

                                            </script>
                                            <label name="status">Status</label><br>
                            
                                            <input type="radio" onclick="javascript:statusCheck();" name="status" id="publicCheck" value="N" checked>
                                            Public <br>

                                            <input type="radio" onclick="javascript:statusCheck();" name="status" id="privateCheck" value="P"> 
                                             Private <br>

                                            <!-- <div id="ifPrivate"  style="display:none; padding: 10px 0px"> -->
                                            <div class="input-group" id="ifPrivate">
                                                <!-- <div class="input-group" id="ifPrivate" style="display:none;" > -->
                                                    <span class="log-pic input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>

                                                     <input type="password" class="form-control" name="password_room" id="password_room" placeholder="Password"  required data-validation-required-message="">
                                                     <br>
                                                    
                                                </div>
                                            <!-- </div> -->
                                <div class="modal-footer">
                                    <input class="log btn btn-primary" type="submit" value=" Create "/>
                                    
                                    
                                </div>
                                </form>
                            </div>
                            
                            </div>
                        </div>
                    </div>
                        </div>
                        <div class="down-arrow floating-arrow"><a href="#"><i class="fa fa-angle-down"></i></a></div>
                    </section>
                    <section class="intro section-padding">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 intro-feature">
                                    <div class="intro-icon">
                                        <span data-icon="&#xe033;" class="icon"></span>
                                    </div>
                                    <div class="intro-content">
                                        <h5>INTERACTIVE WHITE BOARD</h5>
                                        <p>Presenters and participants can expand on ideas through annotate on the app.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4 intro-feature">
                                    <div class="intro-icon">
                                        <span data-icon="&#xe030;" class="icon"></span>
                                    </div>
                                    <div class="intro-content">
                                        <h5>Modern Design</h5>
                                        <p>Designed with modern trends and techniques.</p>
                                    </div>
                                </div>
                                <div class="col-md-4 intro-feature">
                                    <div class="intro-icon">
                                        <span data-icon="&#xe04c;" class="icon"></span>
                                    </div>
                                    <div class="intro-content last">
                                        <h5>Easily manage</h5>
                                        <p>Easily to start up and make them faster by upload file from device or cloud. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="features section-padding" id="features">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5 col-md-offset-7">
                                    <div class="feature-list">
                                        <h3>Take it easy and smarter with UNote </h3>
                                        <p>Present your product, start up, or portfolio in a beautifully modern way. Turn your visitors in to clients.</p>
                                        <ul class="features-stack">
                                            <li class="feature-item">
                                                <div class="feature-icon">
                                                    <span data-icon="&#xe03e;" class="icon"></span>
                                                </div>
                                                <div class="feature-content">
                                                    <h5>Real Time Mode</h5>
                                                    <p>See and do everything with fellow collaborators – work together on content live between devices.</p>
                                                </div>
                                            </li>
                                            <li class="feature-item">
                                                <div class="feature-icon">
                                                    <span data-icon="&#xe05b;" class="icon"></span>
                                                </div>
                                                <div class="feature-content">
                                                    <h5>User Friendly Design</h5>
                                                    <p>UNote design concept is make it easy to use and understand.</p>
                                                </div>
                                            </li>
                                            <li class="feature-item">
                                                <div class="feature-icon">
                                                    <span data-icon="&#xe018;" class="icon"></span>
                                                </div>
                                                <div class="feature-content">
                                                    <h5>Check For Understanding</h5>
                                                    <p>Use the inbuilt question to measure levels of understanding, gather instant feedback and check the results.</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="device-showcase">
                            <div class="devices">
                                <div class="ipad-wrap wp1"></div>
                                <div class="iphone-wrap wp2"></div>
                            </div>
                        </div>
                        <div class="responsive-feature-img"><!-- <img src="img/devices.png" alt="responsive devices"> --></div>
                    </section>
                    <section class="features-extra section-padding" id="about">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="feature-list">
                                        <h3>About U-Note</h3>
                                        <p>U-Note is a web application which provides users with a collaborative connection anywhere to increase the performance in presentations. Using U-Note both presenter and listener can independently control presentation file. </p>
                                        <p>Furthermore, increasing the convenience the user can provide the presentation everywhere on a tablet computer by using this web application project.
                                        </p>
                                        <a href="#" class="btn btn-ghost btn-accent btn-small">What's UNote?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="macbook-wrap wp3"></div>
                        <div class="responsive-feature-img"><!-- <img src="img/macbook-pro.png" alt="responsive devices"> --></div>
                    </section>
                    <section class="hero-strip section-padding">
                        <div class="container">
                            <div class="col-md-12 text-center">
                                <h2>
                                    Make a presentation with an useful instruments
                                </h2>
                                <p>Highlight/draw/color every aspect of U-Note give you a convenience and fun to use</p>
                                <a href="#" class="btn btn-ghost btn-accent btn-large">Learn more</a>
                                <div class="logo-placeholder floating-logo ">
                                    <img src="img/Untitled-1.png" style="width: 350px; align="center>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="sign-up section-padding text-center" id="contact">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <h1>Get in touch </h1>
                                    <p>Please feel free to contact us if you need any further information or let we know what you think, we are respect all of opinions</p>
                                    <form class="signup-form" action="#" method="POST" role="form">
                                        <div class="form-input-group">
                                            <i class="fa fa-envelope"></i><input type="text" class="" placeholder="Enter your email" required>
                                        </div>
                                        <textarea class="form-input-group"
                                            placeholder="                  comment" name="comment" form="usrform" style="height: 155px;"></textarea>
                                        <button type="submit" class="btn-fill sign-up-btn">Send the message</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="to-top">
                        <div class="container">
                            <div class="row">
                                <div class="to-top-wrap">
                                    <a href="#top" class="top"><i class="fa fa-angle-up"></i></a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="footer-links">
                                        <ul class="footer-group">
                                            <li><a href="#features">Features</a></li>
                                            <li><a href="#">Sign up</a></li>
                                            <li><a href="#">Licence</a></li>
                                        </ul>
                                        <p>Copyright © 2016 <a href="#">NPC Team</a><br>
                                            <a href=#>Licence</a> | Made with <span class="fa fa-heart pulse2"></span> by <a href=#>NPC Team</a>.
                                        </p>
                                    </div>
                                </div>
                                <div class="social-share">
                                    <p>Share U-Note with your friends</p>
                                    <a href=# class="twitter-share"><i class="fa fa-twitter"></i></a> <a href="#" class="facebook-share"><i class="fa fa-facebook"></i></a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
                    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
                    <script src="bower_components/retina.js/dist/retina.js"></script>
                    <script src="js/jquery.fancybox.pack.js"></script>
                    <script src="js/vendor/bootstrap.min.js"></script>
                    <script src="js/scripts.js"></script>
                    <script src="js/jquery.flexslider-min.js"></script>
                    <script src="bower_components/classie/classie.js"></script>
                    <script src="bower_components/jquery-waypoints/lib/jquery.waypoints.min.js"></script>
                    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
                    <script>
                        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
                        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
                        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
                        e.src='//www.google-analytics.com/analytics.js';
                        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
                        ga('create','UA-XXXXX-X','auto');ga('send','pageview');
                    </script>
                </body>
            </html>