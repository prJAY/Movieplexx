<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");

        checkusertype("M");
    ?>
    <title>Shows</title>
</head>
<body>
    <?php require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html"); ?>
    <div class="container">
        <h2>
            Upcoming Shows
            <a href="add.php" class="btn btn-primary float-end">Create</a>
        </h2>
        <hr />
    </div>
    <div class="container upshadow my-3">
        <div class="table-responsive">
        <table class="table">
            <thead>
                <th>Show ID</th>
                <th>Title</th>
                <th>Variation</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Time</th>
                <th></th>
            </thead>
            <tbody>
                <?php

                    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

                    date_default_timezone_set("Asia/Kolkata");

                    $mydate = date("Y-m-d H:i:s");
                    
                    $date = date_add(date_create(),date_interval_create_from_date_string("1 days"));
                    $date_tomorrow = $date->format('Y-m-d');

                    $query = "SELECT show_id,audi_master.audi_name,movie_master.title,movie_variation.var_name,show_start,show_end,amount 
                                FROM `show_master`,`audi_master`,`movie_variation`,`movie_master` 
                                WHERE show_master.audi_id = audi_master.audi_id 
                                    AND show_master.var_id = movie_variation.var_id 
                                    AND movie_variation.movie_id = movie_master.movie_id 
                                    AND show_start >= '$mydate'
                                ORDER BY show_start;";

                    $get_data = mysqli_query($conn,$query);
                    if(mysqli_num_rows($get_data) > 0)
                    {
                        while($row = mysqli_fetch_assoc($get_data))
                        {
                            $start = explode(" ",$row['show_start']);
                            $end = explode(" ",$row['show_end']);
                            $show_date = $start[0];

                            echo "
                            <tr>
                                <td>".$row['show_id']."</td>
                                <td>".$row['title']."</td>
                                <td>".$row['var_name']."</td>
                                <td>".$row['amount']."</td>
                                <td>$show_date</td>
                                <td>".substr($start[1],0,5)."</td>
                                <td>";

                                if($date_tomorrow < $show_date)
                                {
                                    echo "<a href='/api/shows/delete.php?id=".$row['show_id']."'><i class='material-icons text-danger'>delete_forever</i></a>";
                                }
                                
                            echo "</td></tr>";
                        }
                    }
                    else
                    {
                        echo "<tr><td colspan='4' class='text-muted'>No shows found</td></tr>";
                    }
                ?>
            </tbody>
        </table>
        </div>
        
    </div>
    <div class="toast-container position-absolute bottom-0 end-0 m-3">
        <div class="toast hide align-items-center text-white " id="toast_bg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-animation="true" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body" id="toast_content">
                    <input type="hidden" id="msg" value="<?php if(isset($_SESSION['code'])){ echo $_SESSION['code']; $_SESSION['code']=""; } ?>" />
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/toast.js" defer></script>
</body>
</html>