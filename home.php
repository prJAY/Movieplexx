<?php
    header("location: /");
    session_start();
    if(isset($_SESSION["user_type"]))
    {
        if($_SESSION["user_type"] == "A")
        {
            header("location: /Admin");
        }
        else if($_SESSION["user_type"] == "M")
        {
            header("location: /Manager");
        }
        else if($_SESSION["user_type"] == "S")
        {
            header("location: /Sales");
        }
    }
?>