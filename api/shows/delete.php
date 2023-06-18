<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("M");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_GET['id']))
    {
        $id = trim($_GET["id"]);
        $query = "delete from show_master where show_id = $id";
        $result = mysqli_query($conn,$query);

        if($result)
        {
            $_SESSION['code'] = "200:Show Removed";
            header("location: /Manager/Shows/");
        }
        else{
            $_SESSION['code'] = "400:Operation Failed! Show Booking Started";
            header("location: /Manager/Shows/");
        }  
    }
    else{
        $_SESSION['code'] = "400:Data Missing";
        header("location: /Manager/Shows/");
    }
?>