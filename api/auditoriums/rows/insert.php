<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("M");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_POST['audi_id']) && isset($_POST['sr_prefix']) && isset($_POST['sr_length']) && isset($_POST['sr_spacer']))
    {
        $id = $_POST['audi_id'];
        $sp = $_POST['sr_spacer'];
        $pre = $_POST['sr_prefix'];
        $len = $_POST['sr_length'];

        $query = "insert into seat_row(sr_prefix,sr_length,audi_id,sr_spacer) values('$pre',$len,$id,$sp)";

        $result = mysqli_query($conn,$query);
        if($result)
        {
            $cap = $len + $_POST['cap'];
            $query = "update audi_master set capacity = $cap where audi_id=$id";
            mysqli_query($conn,$query);

            $_SESSION['code'] = "200:New Row Added";
            header("location: /Manager/Auditoriums/AudiSeats.php?audi_id=$id");
        }
        else{
            $_SESSION['code'] = "400:Operation Failed";
            header("location: /Manager/Auditoriums/AudiSeats.php?audi_id=$id");
        }
    }
    else{
        $_SESSION['code'] = "400:Data Missing";
        header("location: /Manager/Auditoriums/AudiSeats.php?audi_id=$id");
    }
?>