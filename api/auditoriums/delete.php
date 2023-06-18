<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("M");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_GET['id']))
    {
        $id = trim($_GET["id"]);
        $query = "delete from seat_row,audi_master where audi_id = $id";
        $result = mysqli_query($conn,$query);

        if($result)
        {
            $_SESSION['code'] = "200:Auditorium Removed";
            header("location: /Manager/Auditoriums/");
        }
        else{
            $_SESSION['code'] = "400:Operation Failed! Active Shows Assigned";
            header("location: /Manager/Auditoriums/");
        }  
    }
    else{
        $_SESSION['code'] = "400:Data Missing";
        header("location: /Manager/Auditoriums/");
    }
?>