<?php
require($_SERVER['DOCUMENT_ROOT']."/authuser.php");

checkusertype("S");

if(isset($_POST['show_id']))
{
    $id = $_POST['show_id'];
    $seatids = $_POST['seatids'];

    if($seatids == "" || $id == "")
    {
        $_SESSION['code'] = "400:No Data Received";
    }
    else
    {
        require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

        $query = "SELECT reservations from show_master where show_id=$id";

        $get_data = mysqli_query($conn,$query);

        if(mysqli_num_rows($get_data) == 1)
        {
            while($row = mysqli_fetch_assoc($get_data))
            {
                $reservs = $row['reservations'];
                $newres = $reservs.$seatids;
                $query = "UPDATE show_master set reservations = '$newres' where show_id=$id";

                $res = mysqli_query($conn,$query);
                if($res)
                {
                    $_SESSION['code'] = "200:Ticket Created";
                }
                else
                {
                    $_SESSION['code'] = "400:Ticket Creation Failed";
                }
            }
        }
    }
}
header("location: /Sales/Tickets/");
?>