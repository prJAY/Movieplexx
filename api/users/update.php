<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("A");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_POST['user_id']) && isset($_POST['user_name']) && isset($_POST['user_password']) && isset($_POST['user_type']))
    {
        $userid = $_POST['user_id'];
        $password =$_POST['user_password'];
        $uname =$_POST['user_name'];
        $utype=$_POST['user_type'];
        if($utype != "A" && $utype != "M" && $utype != "S")
        {
            echo "400:Invalid Operation.";
        }
        else
        {
            $query = "update user_master set user_password='$password',user_name='$uname',user_type='$utype' WHERE user_id = '$userid'";

            $result = mysqli_query($conn,$query);
            if($result)
            {
                echo "200:User Updated Successfully.";
            }
            else
            {   
                echo "400:Operation Failed.";
            }
        }
    }
    else
    {
        echo "400:Data Missing.";
    }
?>