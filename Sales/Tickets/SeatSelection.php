<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        checkusertype("S");

        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");
        require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

        if(isset($_GET['show_id']) && $_GET['show_id'] >= 0)
        {
            $show = $_GET['show_id'];
            $query = "SELECT title,var_name,amount,audi_name,show_start,show_master.audi_id,reservations 
                        FROM show_master,movie_master,movie_variation,audi_master 
                        WHERE show_master.audi_id = audi_master.audi_id 
                            AND show_master.var_id = movie_variation.var_id 
                            AND movie_variation.movie_id = movie_master.movie_id 
                            AND show_id = $show;";

            $get_data = mysqli_query($conn,$query);

            if(mysqli_num_rows($get_data) == 1)
            {
                while($row = mysqli_fetch_assoc($get_data))
                {
                    $result = $row;
                }
                $reserves = explode(":",$result['reservations']);

                $query = "select * from seat_row where audi_id=".$result['audi_id'];
                $get_data = mysqli_query($conn,$query);
                $rows = $len = $sp = array();
                if(mysqli_num_rows($get_data) > 0)
                {
                    while($row = mysqli_fetch_assoc($get_data))
                    {
                        $rows[] = $row;
                        $len[] = $row['sr_length'];
                        $sp[] = $row['sr_spacer'];
                    }
                    $flag = 1;
                }
                else{
                    $flag = 0;
                }
            }
            else
            {
                header("location: /Sales/Tickets");
            }
        }
        else
        {
            header("location: /Sales/Tickets");
        }
    ?>
    <title>Select Seats</title>
</head>
<body>
    <?php require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html"); ?>
    
    <div class="container">
        <h3>
            <?php echo $result['title'];?>
            <span class="float-end"><?php echo $result['audi_name'];?></span>
        </h3>
        <span class="text-muted"><?php echo $result['var_name'];?></span>
        <span class="text-muted float-end"><?php echo $result['show_start'];?></span>
    </div>
    <div class="container my-3">
        <form action="/Sales/Tickets/ConfirmTicket.php" method="POST" class="row">
            <input type="hidden" name="show_id" value="<?php echo $show; ?>"/>
            <input type="hidden" name="seatids" id="seatids"/>
            <div class="col-md-3">
                <label>Amount</label>
                <input type="text" id="amt" value="<?php echo $result['amount'];?>" class="form-control" disabled/>
            </div>
            <br/>
            <div class="col-md-3">
                <label>Seats selected</label>
                <input type="text" name="scount" id="scount" value="0" class="form-control" readonly/>
            </div>
            <br/>
            <div class="col-md-3">
                <label>Total</label>
                <input type="text" name="amount" id="amount" value="0" class="form-control" readonly/>
            </div>
            <br/>
            <div class="col-md-3">
                <br/>
                <button class="btn btn-primary">continue</button>
            </div>
        </form>
    </div>
    <div class="container bg-dark my-3 py-5">
        <div class="table-responsive">
        <table class="table" style="text-align: center;">
            <thead>
                <tr>
                    <th colspan="3">
                        <span class="text-light">Screen This Way</span>
                        <hr class="bg-danger mx-auto" style="height: 25px; width:80%;"/>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $cap = 0;
                    foreach($rows as $r){   $cap += $r['sr_length'];
                        echo "
                            <tr>
                                <td class='text-muted' style='width: 10px;'>".$r['sr_prefix']."1</td>
                                <td>";
                        
                        for($i = 1; $i <= $r['sr_length']; $i++){
                            $seatid = $r['sr_prefix'].$i;
                            $chk = "";

                            if (in_array($seatid, $reserves))
                            {
                                $chk = "disabled";
                            }

                            echo "<input class='form-check-input seats' type='checkbox' id ='$seatid' onChange='updateBill(this.id)' $chk>";
                            
                            if($i == $r['sr_spacer'])
                            {
                                echo "<span style='margin:0 50px;'></span>";
                            }

                        }

                        echo "
                                </td>
                                <td class='text-muted' style='width: 10px;'>".$r['sr_prefix'].$r['sr_length']."</td>
                            </tr>
                        ";
                    }
                    if($flag == 0){
                        echo "<tr><td colspan='3' class='text-muted'>No Rows Added</td></tr>";
                    }
                
                ?>
            </tbody>
        </table>
        </div>
        
    </div>
    <script src="SeatSelection.js" defer></script>
</body>
</html>