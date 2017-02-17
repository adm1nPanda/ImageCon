<!--
________________EDIT.PHP_____________________________________________
        Attributes
Form to edit the caption.
_______________________________________________________________________
-->

<!doctype html>
<html lang="en">
<head>
	<?php
        session_start();          //PHP Session Begin
    ?>
	<title>ImageCon:A Web Gallery</title>    
    <link rel="stylesheet" href="base.css">
</head>
<body>
   	<?php

        if ($_SESSION['login']==0){           //redirect if user has not logged in
            header('Location: login.php');
        }

        $csrfedit = bin2hex(random_bytes(64));    //csrf token generation for edit form
        $_SESSION['csrfedit'] = $csrfedit;
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
   		<div class="uload">        <!-- Form to edit caption-->
	        <table class="tab">
        	    <form method="post" action="edit_image.php" id="fileu" enctype="multipart/form-data">
    	        <input type="hidden" name="token" value="<?php echo $csrfedit ?>">
    	        <input type="hidden" name="imgid" value="<?php echo $_GET['img'] ?>">
    	        <tr>
	                <td id="caption"><label align="left">Enter New Image Caption: </label><input type="text" name="caption" ></td>
            	</tr>
        	    <tr>
    	            <td id="usub"><input type="submit" id="submit" name="submit" value="submit"></td>
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
