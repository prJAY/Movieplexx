<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("S");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_GET['id']))
    {
        $id = trim($_GET["id"]);
        $query = "delete from ticket_master where ticket_id = $id";
        $result = mysqli_query($conn,$query);

        if($result)
        {
            $_SESSION['code'] = "200:Transaction Cancelled";
            header("location: /Sales/Tickets/");
        }
        else{
            $_SESSION['code'] = "400:Operation Failed!";
            header("location: /Sales/Tickets/");
        }  
    }
    else{
        $_SESSION['code'] = "400:No Data Received";
        header("location: /Sales/Tickets/");
    }
?>