<?php
require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

$query = "SELECT * from movie_variation,movie_master where movie_master.movie_id=movie_variation.movie_id and status='Now Showing' GROUP BY movie_variation.movie_id";

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

?>