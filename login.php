<!--
________________LOGIN.PHP_____________________________________________
        Attributes
Login Page for users
_______________________________________________________________________
-->


<!doctype html>
<html lang="en">
<head>
    <?php
        session_start();        //PHP Session Begins
    ?>
    <title>ImageCon:A Web Gallery</title>    
    <link rel="stylesheet" href="base.css">
</head>
<body>
    
    <?php 
        $csrf1 = bin2hex(random_bytes(64));     //Login form CSRF Token Generation
        $_SESSION['csrflog'] = $csrf1;
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
    	</ul>
    </div>
    
    <!-- Main Body -->
    
    <div class="login">
        <?php 
            if (isset($_GET['msg'])){           //Login Success/Fail Banner
                if ($_GET["msg"]=="fail"){
                    echo "<font color='red'>Invalid Username/Password. Please try again</font>";
                }
            }
        ?>
        <table class="tab1">        <!-- Login Form -->
            <form method="post" action="user_login.php" >
            <input type="hidden" name="token" value="<?php echo $csrf1 ?>">
            <tr>
                <td id="user"><input type="text" id="username" name="username" placeholder="Username"></td>
            </tr>
            <tr>
                <td id="pass"><input type="password" name="password" id="password" placeholder="Password"></td>
            </tr>
            <tr>
                <td id="usub"><input type="submit" name="login" value="Login"></td>
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