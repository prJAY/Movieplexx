<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");

        checkusertype("S");

        if(isset($_POST['show_id']))
        {
            $id = $_POST['show_id'];
            $seatids = $_POST['seatids'];
            $scount= $_POST['scount'];
            $amount= $_POST['amount'];

            if($seatids == "" || $scount == "" || $amount == "")
            {
                $_SESSION['code'] = "400:No Data Received";
                header("location: /Sales/Tickets/SeatSelection.php?show_id=$id");
            }
            else
            {
                require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

                $query = "INSERT INTO ticket_master(show_id,quantity,seats,amount)
                            VALUES($id,$scount,'$seatids',$amount)";

                $res = mysqli_query($conn,$query);
                if($res)
                {
                    $query = "SELECT LAST_INSERT_ID() AS TICKET;";

                    $get_data = mysqli_query($conn,$query);

                    if(mysqli_num_rows($get_data) > 0)
                    {
                        while($row = mysqli_fetch_assoc($get_data))
                        {
                            $ticket = $row['TICKET'];

                            $query = "SELECT title,var_name,amount,audi_name,show_start,show_master.audi_id,reservations 
                                FROM show_master,movie_master,movie_variation,audi_master 
                                WHERE show_master.audi_id = audi_master.audi_id 
                                    AND show_master.var_id = movie_variation.var_id 
                                    AND movie_variation.movie_id = movie_master.movie_id 
                                    AND show_id = $id;";

                            $get_data = mysqli_query($conn,$query);

                            if(mysqli_num_rows($get_data) == 1)
                            {
                                while($row = mysqli_fetch_assoc($get_data))
                                {
                                    $result = $row;
                                }
                            }
                        }
                    }
                }                
            }
        }
        else{
            $_SESSION['code'] = "400:No Data Received";
            header("location: /Sales/Tickets/SeatSelection.php?show_id=$id");
        }
    ?>
    <title>Waiting for confirmation</title>
</head>
<body>
    <?php
        require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html");
    ?>
    <div class="container">
        <h3>
            <?php echo $result['title'];?>
            <span class="float-end"><?php echo $result['audi_name'];?></span>
        </h3>
        <span class="text-muted"><?php echo $result['var_name'];?></span>
        <span class="text-muted float-end"><?php echo $result['show_start'];?></span>
        <br/>
        <br/>
        #T<?php echo $ticket;?>
        <br/><br/>
        Seats : <?php echo str_replace(":"," ",$seatids);?>
        <br/>
        Total Amount : <?php echo $result['amount']." x $scount = $amount"; ?>
        <br/>
        <br/>
        <span class="text-muted">waiting for payment confirmation</span>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
        </div>
        <br/>
        <form action="TransactionComplete.php" method="POST">
            <input type="hidden" name="show_id" value="<?php echo $id; ?>"/>
            <input type="hidden" name="seatids" value="<?php echo $seatids; ?>"/>
            <button class="btn btn-primary">Confirm Payment</button>
            <a href="cancelticket.php?id=<?php echo $ticket; ?>" class="btn">Cancel</a>
        </form>
    </div>
</body>
</html>