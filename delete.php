<!--
________________DELETE.PHP_____________________________________________
        Attributes
Server_Side form to handle delete request
_______________________________________________________________________
-->

<?php 
	session_start();               //PHP Session Begins
	include 'db_config.php';

    //mysql connection
	$conn = mysqli_connect($servername, $username, $password, $db);
    if (!$conn) {
        die('Could not connect: ');
    }

    $img=htmlspecialchars(strip_tags(trim($_GET['img'])));      //input sanitization

    $sql = "SELECT filename FROM images WHERE imageid=".$img;   //sql query to identify image in database
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
    	$filename = $row['filename'];
    }
    
 
    $sql = "DELETE FROM images WHERE imageid=".$img;            //sql query to delete image from database
    $result = $conn->query($sql);
    if(! $result )
	{
  		die('Could not delete data: ' . mysql_error());
  		header('Location: profile.php?msg=fail');       //redirect to profile if deleting image fails
	}

	if (file_exists("img/".$filename)) {                   //delete image from server.
    	unlink("img/".$filename);
    }
	echo "Deleted data successfully\n";
	mysqli_close($conn);

	header('Location: profile.php?msg=success');           //redirect to profile after successfully deleting
?>