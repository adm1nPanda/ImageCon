<!--
________________PROFILE.PHP_____________________________________________
        Attributes
Webpage to display profile of user
Gives users a choice to update captions or delete their images.
_______________________________________________________________________
-->

<!doctype html>
<html lang="en">
<head>
    <?php
        session_start();                //PHP Session Begins
        include 'db_config.php';
    ?>
    <title>ImageCon:A Web Gallery</title>    
    <link rel="stylesheet" href="base.css">
</head>
<body>

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
    <?php 
        if (isset($_GET['msg'])){               //Update request Success/Fail Banner
            if($_GET["msg"]=="success"){
                echo "Update was a success";
            }
            else if ($_GET["msg"]=="fail"){
                echo "<font color='red'>Update was a failure. Please try again</font>";
            }
        }
    ?>
    
    <?php                                           
        if ($_SESSION['login']==0){             //redirect if not logged in
            header('Location: login.php');
        }
        //mysql connection        
        $conn = mysqli_connect($servername, $username, $password, $db);
        if (!$conn) {
            die('We could not connect to the database. Please comback later'); 
        }

        //pagination configuration
        $tbl_name="images";             //table name
        $adjacents = 3;

        $query = "SELECT COUNT(*) as num FROM $tbl_name";
        $total_pages = mysqli_fetch_array(mysqli_query($conn,$query));
        $total_pages = $total_pages["num"];

        $targetpage = "profile.php";      //return webpage
        $limit = 10;                    //Number of items per page

        if(isset($_GET['page']))
            $page = $_GET['page'];
        else
            $page = 0;

        if($page) 
            $start = ($page - 1) * $limit;          //first item to display on this page
        else
            $start = 0;                             //if no page number is given

        
        //SQL query to retreive only unser's images from database
        $sql = "SELECT imageid,filename,caption,user_id FROM $tbl_name WHERE user_id='".$_SESSION['user_id']."' ORDER BY uploadtime DESC LIMIT $start,$limit";
        $result = $conn->query($sql);


        if ($page == 0){ $page = 1;}                //if no page var is given, default to 1.
        $prev = $page - 1;                          //previous page is page - 1
        $next = $page + 1;                          //next page is page + 1
        $lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
        $lpm1 = $lastpage - 1;                      //last page minus 1

        $pagination = "";
        if($lastpage > 1)
        {   
            $pagination .= "<div class=\"pagination\">";
            if ($page > 1) 
                $pagination.= "<a href=\"$targetpage?page=$prev\">&ltprevious </a>";
            else
                $pagination.= "<span class=\"disabled\">&ltprevious </span>"; 

            //pages 
            if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up
            {   
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<span class='current'>$counter</span>";
                    else
                        $pagination.= "<a href='$targetpage?page=$counter'>$counter</a>";                 
                }
            }
            elseif($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
            {
                //close to beginning; only hide later pages
                if($page < 1 + ($adjacents * 2))     
                {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class='current'>$counter</span>";
                        else
                            $pagination.= "<a href='$targetpage?page=$counter'>$counter</a>";                 
                    }
                    $pagination.= "...";
                    $pagination.= "<a href='$targetpage?page=$lpm1'>$lpm1</a>";
                    $pagination.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";       
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                {
                    $pagination.= "<a href='$targetpage?page=1'> 1 </a>";
                    $pagination.= "<a href='$targetpage?page=2'> 2 </a>";
                    $pagination.= "...";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class='current'> $counter </span>";
                        else
                            $pagination.= "<a href='$targetpage?page=$counter'> $counter </a>";                 
                    }
                    $pagination.= "...";
                    $pagination.= "<a href='$targetpage?page=$lpm1'> $lpm1 </a>";
                    $pagination.= "<a href='$targetpage?page=$lastpage'> $lastpage </a>";       
                }
                //close to end; only hide early pages
                else
                {
                    $pagination.= "<a href='$targetpage?page=1'> 1 </a>";
                    $pagination.= "<a href='$targetpage?page=2'> 2 </a>";
                    $pagination.= "...";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class='current'> $counter </span>";
                        else
                            $pagination.= "<a href='$targetpage?page=$counter'> $counter </a>";
                    }
                }
            }  

            //next button
            if ($page < $counter - 1) 
                $pagination.= "<a href='$targetpage?page=$next'> next &gt</a>";
            else
                $pagination.= "<span class='disabled'> next &gt</span>";
            $pagination.= "</div>\n";     
        }
    ?>
    

    <?php
        while($row = mysqli_fetch_array($result))   //Display user's images 
        {
            echo "<div class='ibox'><img src=img/" . $row["filename"]. " class='imgs' />";
            echo "<span> Caption : ".$row['caption']."</span><br/>";
            $user = "SELECT username AS name FROM users WHERE user_id=".$row['user_id'];
            $res = $conn->query($user);
            while($u = mysqli_fetch_array($res)){
                echo "<span> Uploaded By : ".$u['name']."</span>";
            }


            echo "<br /><br />";
            echo "<a href='edit.php?img=".$row['imageid']."'>edit</a><br /><br />"; //edit image caption
            echo "<a href='delete.php?img=".$row['imageid']."'>delete</a></div>";   //delete image
        }
    ?>

<?=$pagination?>


    <div>
    	<div class="footer">
        <!-- Footer -->
        	<p>Website developed for class project. Website by Dushyanth Chowdary</p>
    	</div>
    </div>
</div>



</body>
</html>
