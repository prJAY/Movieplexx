<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("M");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_POST['audi_name']))
    {
        $name = $_POST['audi_name'];

        $query = "insert into audi_master(audi_name) values('$name')";

        $result = mysqli_query($conn,$query);
        if($result)
        {
            $_SESSION['code'] = "200:Auditorium Added";
            header("location: /Manager/Auditoriums/");
        }
        else{
            $_SESSION['code'] = "400:Operation Failed";
            header("location: /Manager/Auditoriums/");
        }
    }
    else{
        $_SESSION['code'] = "400:Data Missing";
        header("location: /Manager/Auditoriums/");
    }
?>