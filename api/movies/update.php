<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("M");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_POST['movie_id']) && isset($_POST['interval_time']) && isset($_POST['reset_time']))
    {
        $id = $_POST['movie_id'];
        $inter = $_POST['interval_time'];
        $reset = $_POST['reset_time'];

        $query = "update movie_master set interval_time = $inter , reset_time = $reset where movie_id = $id";

        $result = mysqli_query($conn,$query);
        if($result)
        {
            $_SESSION['code'] = "200:Time Updated";
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