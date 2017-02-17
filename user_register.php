<!--
________________USER_REGISTER.PHP_____________________________________________
        Attributes
Server-Side PHP to register new user
_______________________________________________________________________
-->


<?php
    session_start();                    //PHP Session Begins
    include 'db_config.php';

    if (isset($_POST['login'])){
        if ($_SESSION['csrfreg']==$_POST['token']){

            //mysql connection
            $conn = mysqli_connect($servername, $username, $password, $db);
            if (!$conn) {
                die('Could not connect: ');
            }

            //sanitizing user inputs
            $username=htmlspecialchars(strip_tags(trim($_POST['username'])));
            $password=htmlspecialchars(strip_tags(trim($_POST['password'])));


            $sql = "SELECT username FROM users WHERE username='".$username."'";   //check if username is taken
            
            $result = $conn->query($sql);
            
            //register user
            if ($result->num_rows == 0) {
                $sql = "INSERT INTO users ( username, password, user_id) VALUES ('".$username."','".hash('sha512',$password)."','".rand(100,100000000)."')";          //register new user in database
                echo $sql;
                $r = $conn->query($sql);    
                if(! $r )
                {
                    die('Could not register user: ' . mysqli_error($conn));
                    header('Location: register.php?msg=regf');      //redirect to login
                }


                echo "registration success";
                header('Location: login.php?msg=regs');      //redirect to login
                
                
            }
            else {
                header('Location: register.php?msg=regut'); //redirect to login page with fail message
            }
        }
        else{
            echo "csrf detected";
        }
    }


?>