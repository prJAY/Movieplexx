<?php
	require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
	checkusertype("A");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    $query = "select * from user_master";
    $get_data = mysqli_query($conn,$query);
    if(mysqli_num_rows($get_data) > 0)
    {
        $response;
        while($row = mysqli_fetch_assoc($get_data))
        {
            switch($row["user_type"])
            {
                case "A" : $row["user_type"] = "Admin"; break;
                case "M" : $row["user_type"] = "Manager"; break;
                case "S" : $row["user_type"] = "Sales"; break;
            }
            $row["edit"] = false;
            $response[] = $row;
        }
        $myJSON = json_encode($response);
        echo $myJSON;
    }
?>