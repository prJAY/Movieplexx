<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("M");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_POST['audi_id']) && isset($_POST['var_id']) && $_POST['var_id'] > 0 && isset($_POST['show_date']) && isset($_POST['show_time']))
    {
        $audi_id = $_POST['audi_id'];
        $var_id = $_POST['var_id'];
        $show_date = $_POST['show_date'];
        $show_time = $_POST['show_time'];
        $show_start = $show_date . " " . $show_time . ":00";
        $uplimit = 0;
        if(isset($_POST['repeat_date']) && $_POST['repeat_date'] != "")
        {
            
            $rpt = $_POST['repeat_date'];
            $date1 = new DateTime($show_date." 00:00:00 GMT");
            $date2 = new DateTime($rpt." 00:00:00 GMT");

            $uplimit =  $date1->diff($date2)->format("%d");
        }

        $query = "select run_time,interval_time,reset_time from movie_master,movie_variation where movie_master.movie_id = movie_variation.movie_id and var_id = $var_id";
        $get_data = mysqli_query($conn,$query);
        if(mysqli_num_rows($get_data) == 1)
        {
            while($row = mysqli_fetch_assoc($get_data))
            {
                $totaltime = $row['run_time'] + $row['interval_time'] + $row['reset_time'];
            }
        }
        $startmins = explode(":",$show_time);
        $endhours = $endmins = 0;

        $endhours = $startmins[0];
        $totaltime += $startmins[1];
        while($totaltime >= 60)
        {
            $endhours++;
            $totaltime -= 60;
        }
        $endmins = $totaltime;
        $show_end = $show_date . " " . $endhours . ":" . $endmins . ":00";
        
        $ok = $bad = 0;
        for($i = 0; $i <= $uplimit;$i++)
        {
            $date1 = new DateTime($show_date." ".$show_time.":00 GMT");
            date_add($date1,date_interval_create_from_date_string($i." days"));

            $date2 = new DateTime($show_end." GMT");
            date_add($date2,date_interval_create_from_date_string($i." days"));

            $result1 = $date1->format('Y-m-d H:i:s');
            $result2 = $date2->format('Y-m-d H:i:s');

            $query = "select * from show_master where show_start <= '$result1' and show_end >= '$result1' and audi_id = $audi_id";
            $get_data = mysqli_query($conn,$query);
            if(mysqli_num_rows($get_data) > 0)
            {
                $bad++;
            }
            else
            {
                $query = "INSERT INTO show_master (audi_id,var_id,show_start,show_end)
                    VALUES ($audi_id,$var_id,'$result1','$result2')";

                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $ok++;
                }
                else{
                    $bad++;
                }
            }
        }
        
        if($bad == 0 && $ok > 0)
        {
            $_SESSION['code'] = "200:Show Added with $ok occurances ";
            header("location: /Manager/Shows/");
        }
        else if($ok > 0)
        {
            $_SESSION['code'] = "200:$ok Succeed with $bad Failed";
            header("location: /Manager/Shows/add.php");
        }
        else
        {
            $_SESSION['code'] = "400:$bad Operations Failed";
            header("location: /Manager/Shows/add.php");
        }
    }
    else
    {
        $_SESSION['code'] = "400:Data Missing";
        header("location: /Manager/Shows/add.php");
    }
?>