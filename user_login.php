<!--
________________USER_LOGIN.PHP_____________________________________________
        Attributes
Server-Side PHP to verify login
_______________________________________________________________________
-->


<?php
    session_start();                    //PHP Session Begins
    include 'db_config.php';

    $_SESSION['login'] = 0;             //set 'login' variable false
    if (isset($_POST['login'])){
        if ($_SESSION['csrflog']==$_POST['token']){

            //mysql connection
            $conn = mysqli_connect($servername, $username, $password, $db);
            if (!$conn) {
                die('Could not connect: ');
            }

            //sanitizing user inputs
            $username=htmlspecialchars(strip_tags(trim($_POST['username'])));
            $password=htmlspecialchars(strip_tags(trim($_POST['password'])));
            $sql = "SELECT user_id FROM users WHERE username='".$username."' AND password='".hash('sha512',$password)."'";          //Retreive user_id with submitted username/password
            
            $result = $conn->query($sql);
            
            //Log user in
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $_SESSION['user_id']=$row["user_id"];
                    $_SESSION['login']=1;
                    header('Location: index.php');      //redirect to homepage
                }
            } else {
                echo " login fail";
                header('Location: login.php?msg=fail'); //redirect to login page with fail message
            }
        }
        else{
            echo "csrf detected";
        }
    }


?>