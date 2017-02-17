<!--
________________LOGOUT.PHP_____________________________________________
        Attributes
Server-Side PHP to logout users
_______________________________________________________________________
-->

<?php
	session_start();		//PHP Session Begins
	session_unset();		//PHP unset session
	session_destroy();		//Destroy current session
	ob_start();
	header("location:index.php");	//redirect to homepage
	ob_end_flush(); 
	include 'index.php';
	//include 'home.php';
	exit();
?>