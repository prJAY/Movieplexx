<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("A");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_GET['id']))
    {
        $userid = trim($_GET["id"]);
        $query = "delete from user_master where user_id = '$userid'";
        $result = mysqli_query($conn,$query);

        if($result)
        {
            echo "200:User Deleted Successfully.";
        }
        else
        {   
            echo "400:Operation Failed.";
        }
    }
    else{
        echo "400:Data Missing.";
    }
?>