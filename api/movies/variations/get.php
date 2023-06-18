<?php

if(isset($_GET['movie_id']) && $_GET['movie_id'] > 0){
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");
    $id = $_GET['movie_id'];
    $query = "SELECT * from movie_variation where movie_id = $id AND status = 'Now Showing'";

    $get_data = mysqli_query($conn,$query);
    if(mysqli_num_rows($get_data) > 0)
    {
        $response;
        while($row = mysqli_fetch_assoc($get_data))
        {
            $row['edit'] = false;
            $response[] = $row;
        }
        $myJSON = json_encode($response);
        echo $myJSON;
    }
}

?>