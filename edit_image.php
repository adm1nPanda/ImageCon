<!--
________________EDIT_IMAGE.PHP_____________________________________________
        Attributes
Server_Side form to handle edit request
_______________________________________________________________________
-->

<?php 
	session_start();		//PHP Session Begins
	include 'db_config.php';
	if ($_SESSION['csrfedit']==$_POST['token']){		//CSRF token verification
		//mysql connection
		$conn = mysqli_connect($servername, $username, $password, $db);
    	if (!$conn) {
        	die('Could not connect: ');
    	}

    	$img=htmlspecialchars(strip_tags(trim($_POST['imgid'])));		//user input sanitization
		$caption=htmlspecialchars(strip_tags(trim($_POST['caption'])));

    	$sql = "UPDATE images SET caption='".$caption."' WHERE imageid=".$img;  	//SQL query to update database
	    $result = $conn->query($sql);
    	if(! $result )
		{
  			die('Could not update data: ' . mysql_error());
	  		header('Location: profile.php?msg=fail');		//redirect to profile on failure
		}
		echo "Updated data successfully\n";
		mysqli_close($conn);
		header('Location: profile.php?msg=success');		//redirect to profile on success
	}
	else {
		echo "csrf detected";
	}
?>