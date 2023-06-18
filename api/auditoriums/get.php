<?php
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    $query = "select * from audi_master";
    $get_data = mysqli_query($conn,$query);
    if(mysqli_num_rows($get_data) > 0)
    {
        $response;
        while($row = mysqli_fetch_assoc($get_data))
        {
            $response[] = $row;
        }
        $myJSON = json_encode($response);
        echo $myJSON;
    }
?>