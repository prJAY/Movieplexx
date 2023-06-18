<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");

        checkusertype("S");
        date_default_timezone_set("Asia/Kolkata");

        $mydate1 = date("Y-m-d 00:00:00");
        $mydate2 = date('Y-m-d 23:59:59');

        $select2 = "Tomorrow";
        $select1 = "Today";
        if(isset($_GET['q']) && $_GET['q'] == "next" )
        {
            $date=date_create($mydate1);
            date_add($date,date_interval_create_from_date_string("1 days"));
            $mydate1 = $date->format('Y-m-d H:i:s');
            $date=date_create($mydate2);
            date_add($date,date_interval_create_from_date_string("1 days"));
            $mydate2 = $date->format('Y-m-d H:i:s');

            $select1 = "Tomorrow";
            $select2 = "Today";
        }
    ?>
    <title>Shows</title>
</head>
<body>
    <?php require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html"); ?>
    <div class="container">
        <h2>
            Select Show
            <div class="float-end" style="width: 150px;">
                <select class="form-select form-select-sm" id="dateval" onchange="changeDate()">
                    <option><?php echo $select1?></option>
                    <option><?php echo $select2?></option>
                </select>
            </div>
        </h2>
        <hr />
    </div>
    <div class="container my-3">
        <?php
            
            require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");
            

            $query = "SELECT show_id,audi_master.audi_name,movie_master.title,movie_variation.var_name,show_start,show_end 
                        FROM `show_master`,`audi_master`,`movie_variation`,`movie_master` 
                        WHERE show_master.audi_id = audi_master.audi_id 
                            AND show_master.var_id = movie_variation.var_id 
                            AND movie_variation.movie_id = movie_master.movie_id 
                            AND show_start >= '$mydate1'
                            AND show_start <= '$mydate2'
                        ORDER BY title,var_name;";

            $get_data = mysqli_query($conn,$query);
            if(mysqli_num_rows($get_data) > 0)
            {
                $current_title = $current_var = "";
                echo "<div><span class='float-end text-muted'>".substr($mydate1,0,10)."</span>";
                while($row = mysqli_fetch_assoc($get_data))
                {
                    $tt = date_create($row['show_start']);
                    $mytt = $tt->format('H:i');

                    if($current_title == $row['title'])
                    {
                        if($current_var == $row['var_name'])
                        {
                            echo "<a href='SeatSelection.php?show_id=".$row['show_id']."' class='btn btn-outline-primary btn-sm mx-1'>$mytt</a>";
                        }
                        else
                        {
                            echo "
                                <br/><br/><span>".$row['var_name']."</span><br/>
                                <a href='SeatSelection.php?show_id=".$row['show_id']."' class='btn btn-outline-primary btn-sm mx-1'>$mytt</a>
                            ";
                            $current_var = $row['var_name'];
                        }
                    }
                    else
                    {
                        echo "</div><div class='my-5'>
                        <h3><b>".$row['title']."</b></h3>
                        <span>".$row['var_name']."</span><br/>
                        <a href='SeatSelection.php?show_id=".$row['show_id']."' class='btn btn-outline-primary btn-sm mx-1'>$mytt</a>
                        
                        ";
                        $current_title = $row['title'];
                        $current_var = $row['var_name'];
                    }
                }
                echo "</div>";
            }
        ?>
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
    <script>
        function changeDate()
        {
            var dateval = $('#dateval').find(":selected").val();
            if(dateval == "Tomorrow")
            {
                window.location.replace("?q=next");
            }
            else if(dateval == "Today")
            {
                window.location.replace(window.location.origin + window.location.pathname);
            }

        }
    </script>
</body>
</html>