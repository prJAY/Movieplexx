<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("M");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_POST['var_id']) && isset($_POST['var_name']) && isset($_POST['status']) && isset($_POST['amount']))
    {
        $id = $_POST['movie_id'];
        $varid = $_POST['var_id'];
        $status = $_POST['status'];
        $varname = $_POST['var_name'];
        $amount = $_POST['amount'];

        $query = "update movie_variation set status='$status',var_name='$varname',amount=$amount WHERE var_id = $varid";

        $result = mysqli_query($conn,$query);
        if($result)
        {
            $_SESSION['code'] = "200:Variation Updated";
            header("location: /Manager/Movies/details.php?movie_id=$id");
        }
        else{
            $_SESSION['code'] = "400:Operation Failed";
            header("location: /Manager/Movies/details.php?movie_id=$id");
        }
    }
    else{
        $_SESSION['code'] = "400:Data Missing";
        header("location: /Manager/Movies/details.php?movie_id=$id");
    }
?>