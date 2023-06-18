<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("A");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_POST['user_id']) && isset($_POST['user_name']) && isset($_POST['user_password']) && isset($_POST['user_type']))
    {
        $userid = $_POST['user_id'];
        $password = $_POST['user_password'];
        $uname = $_POST['user_name'];
        $utype = substr($_POST['user_type'],0,1);

        $query = "insert into user_master values('$userid','$password','$uname','$utype')";

        $result = mysqli_query($conn,$query);
        if($result)
        {
            echo "200:User Added Successfully.";
        }
        else
        {   
            echo "400:Operation Failed.";
        }
    }
    else{
        echo "400:Data Missing";
    }
?>