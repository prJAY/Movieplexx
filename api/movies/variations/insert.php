<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("M");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_POST['var_name']))
    {
        $id = $_POST['movie_id'];
        $var_name = $_POST['var_name'];
        $status= $_POST['status'];
        $amount= $_POST['amount'];

        if($id == "" || $var_name == "" || $status == "" || $amount == "")
        {
            $_SESSION['code'] = "400:No Data Received";
            header("location: /Manager/Movies/details.php?movie_id=$id");
        }
        else
        {
            $query = "INSERT INTO movie_variation (var_name,status,amount,movie_id) VALUES ('$var_name','$status',$amount,$id)";
            $result = mysqli_query($conn,$query);
            if($result)
            {
                $_SESSION['code'] = "200:Movie Variation Added";
                header("location: /Manager/Movies/details.php?movie_id=$id");
            }
            else{

                $_SESSION['code'] = "400:Operation Failed";
                header("location: /Manager/Movies/details.php?movie_id=$id");
            }
        }
    }
    else{
        $_SESSION['code'] = "400:Data Missing";
        header("location: /Manager/Movies/details.php?movie_id=$id");
    }
?>