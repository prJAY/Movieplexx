<?php
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_GET['audi_id']) && $_GET['audi_id'] >= 0)
    {
        $query = "select * from seat_row where audi_id=".$_GET['audi_id'];
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
    }
?>