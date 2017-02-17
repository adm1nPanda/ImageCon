<!--
________________IMG_UPLOAD.PHP_____________________________________________
        Attributes
Server-Side PHP to handle image upload
Server-Side verification before upload
_______________________________________________________________________
-->


<?php
	session_start();			//PHP Session Begins
	include 'db_config.php';

	if ($_SESSION['csrf']==$_POST['token']){		//CSRF token validation
		//variable initializations
		$target_dir = __DIR__."/img/";				//Image upload directory
		$date = new DateTime();
													//Sanitizing inputs from form
		$filename=htmlspecialchars(strip_tags(trim($_FILES["fileupload"]["name"])));
		$tmpfilename=htmlspecialchars(strip_tags(trim($_FILES["fileupload"]["tmp_name"])));
		$caption=htmlspecialchars(strip_tags(trim($_POST['caption'])));
		$user_id=htmlspecialchars(strip_tags(trim($_SESSION['user_id'])));

		$filehash = md5(basename(date_format($date, 'U = Y-m-d H:i:s').$filename));	//Hashing filename before Upload
		$target_file = $target_dir . $filehash;
		$uploadOk = 1;
		$imageFileType = pathinfo(__DIR__."/img/".$filename,PATHINFO_EXTENSION);	//strip image filetype

		//server side verification
		if(isset($_POST["submit"])) {			//Check if file is an image
    		$check = getimagesize($tmpfilename);
    		if($check !== false) {
        		echo "File is an image - " . $check["mime"] . ".";
      		  	$uploadOk = 1;
    		} else {
        		echo "File is not an image.";
        		$uploadOk = 0;
    		}
		}

		if (file_exists($target_file)) {		//Check if exact file already exists
    		echo "Sorry, file already exists.";
    		$uploadOk = 0;
		}

		if ($_FILES["fileupload"]["size"] > 50000000) {			//check if image is below max image size
    		echo "Sorry, your file is too large.";
    		$uploadOk = 0;
		}
	
		$imageFileType = strtolower($imageFileType);		//check if image is of accepted format
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    		$uploadOk = 0;
		}	

		//upload file
		if ($uploadOk == 0) {
    		echo "Sorry, your file was not uploaded.";
		} else {
    		if (move_uploaded_file($tmpfilename, $target_file)) {
       		 	echo "The file ".$filehash. " has been uploaded.";

       		 	//mysql connection
				$conn = mysqli_connect($servername, $username, $password, $db);
				
				if (!$conn) {
    				die('Could not connect: ');	
    				//delete image- couldn't connect to database
    				if (file_exists("img/".$filehash)) {
    					unlink("img/".$filehash);
    				}
				}
				echo 'Connected successfully';
				$sql = "INSERT INTO images (filename, caption, user_id) VALUES ('".$filehash."', '".$caption."','".$user_id."');";				//SQL query to store file in database
				if ($conn->query($sql) === TRUE) {
    				echo "New record created successfully";
    				mysqli_close($conn);

					header('Location: upload.php?msg=success');	
				} else {
    				echo "Error: " . $sql . "<br>" . $conn->error;
    				//delete image, failed to store file in database
    				if (file_exists("img/".$filehash)) {
    					unlink("img/".$filehash);
    				}
    				mysqli_close($conn);			//close mysql connection
    				header('Location: upload.php?msg=fail');	//redirect back to upload page
				}

    		} else {
        		echo "Sorry, there was an error uploading your file.";
        		header('Location: upload.php?msg=fail');
    		}
		}

	}
	else{
		echo "CSRF detected";
	}
?>
