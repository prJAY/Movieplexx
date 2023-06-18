<?php
    session_start();
    function checkusertype($req_type)
    {
        if($_SESSION["user_type"] != $req_type)
        {
            header("location: /");
            exit;
        }
    }

?>