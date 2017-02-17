<!--
________________UPLOAD.PHP_____________________________________________
        Attributes
Form to upload image to server
Accessible only after login.
Client-Side verification before sending
_______________________________________________________________________
-->


<!doctype html>
<html lang="en">
<head>
    <?php
        session_start();            //PHP Session Begins
    ?>
    <title>ImageCon:A Web Gallery</title>    
    <link rel="stylesheet" href="base.css">        <!-- Linking CSS To Page-->
</head>
<body onload="return form1()">                      <!-- JavaScript to Handle Upload Form-->
    <script>
        function form1(){
            document.getElementById("mysubmit").disabled = true;
            return true;
        }

        //Client Side verification of Image
        function imgverify(filename) {
            var allowed_exts = new Array("jpg","jpeg","png","gif");
            var ext = filename.split(".").pop();
            document.getElementById("mysubmit").disabled = true;
            for(var i = 0; i <= allowed_exts.length; i++){
                if(allowed_exts[i]==ext.toLowerCase()){
                    document.getElementById("mysubmit").disabled = false;
                    return true;
                }
            }
            return false;
        }
    </script>

    <?php

        if ($_SESSION['login']==0){                     //Redirect if not Logged-in
            header('Location: login.php');
        }

        $csrf = bin2hex(random_bytes(64));              //CSRF Token Generation
        $_SESSION['csrf'] = $csrf;
    ?>

<div id="layout" class="body">
    <!-- Header/Topbar -->
    <div class="topbar">
        <div class="header">
            <h1 class="title">ImageCon</h1>
            <h2 class="tagline">A Simple Web Gallery</h2>
        </div>
    </div>
    <!-- Menu -->
    <div class="menu">
    	<ul align="center">
    		<li><a href="index.php">Home</a></li>
    		<li><a href="upload.php">Upload</a></li>
            <?php if(isset($_SESSION['login']) && $_SESSION['login']==1){echo"<li class=\"dropdown\"style=\"position: absolute; right: 0px\";><a href=\"profile.php\">Welcome back!</a><div class=\"dropdown-content\"><a href=\"profile.php\">profile</a><a href=\"logout.php\">Logout</a></div></li>";}else{ echo"<li style=\"position: absolute; right: 0px\";><a href=\"login.php\">Login</a></li>";}?>
    	</ul>
    </div>
    
    <!-- Main Body -->

    <div class="uload">
        <?php 
            if (isset($_GET['msg'])){                       //Image Upload Success/Fail Banner
                if($_GET["msg"]=="success"){
                    echo "File upload was a success";
                }
                else if ($_GET["msg"]=="fail"){
                    echo "<font color='red'>File upload was a failure. Please try again</font>";
                }
            }
        ?>
        <table class="tab">             <!-- Image Upload Form -->
            <form method="post" action="img_upload.php" id="fileu" enctype="multipart/form-data">
            <input type="hidden" name="token" value="<?php echo $csrf ?>">
            <tr>
                <td id="uin"><input type="file" onchange="return imgverify(this.value)" id="filename" name="fileupload" value="fileupload"></td>
            </tr>
            <tr>
                <td id="caption"><label align="left">Enter Image Caption: </label><input type="text" name="caption" ></td>
            </tr>
            <tr>
                <td id="usub"><input type="submit" id="mysubmit" name="submit" value="submit"></td>
            </tr>
            </form>
        </table>
    </div>
    <div>
    	<!-- Footer -->
        <div class="footer">
        	<p>Website developed for class project. Website by Dushyanth Chowdary</p>
    	</div>
    </div>
</div>
</body>
</html>