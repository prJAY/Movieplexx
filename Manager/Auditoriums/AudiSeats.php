<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        checkusertype("M");

        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");
        require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

        if(isset($_GET['audi_id']) && $_GET['audi_id'] >= 0)
        {
            $audi = $_GET['audi_id'];
            $query = "select audi_name from audi_master where audi_id=$audi";
            $get_data = mysqli_query($conn,$query);

            if(mysqli_num_rows($get_data) == 1)
            {
                while($row = mysqli_fetch_assoc($get_data))
                {
                    $audi_name = $row['audi_name'];
                }
                $query = "select * from seat_row where audi_id=$audi";
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
                header("location: /Manager/Auditoriums");
            }
        }
        else
        {
            header("location: /Manager/Auditoriums");
        }
    ?>
    <script src="AuditoriumScript.js" defer></script>
    <title>Auditoriums</title>
</head>
<body ng-app="App" ng-controller="Ctrl">
    <?php require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html"); ?>
    
    <div class="container">
        <h2>
            <b><?php echo $audi_name; ?></b>
            <span class="btn text-danger float-end">
                <i class="material-icons" data-bs-toggle="modal" data-bs-target="#deletemodal">delete_forever</i>
            </span>
            <button class="btn btn-primary float-end" type="button" ng-hide="insertform" ng-click="insertform=true">Add Row</button>
        </h2>
        <hr />
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
                                echo "<input class='form-check-input seats' type='checkbox' disabled>";
                                
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
                    <tr ng-show="insertform">
                        <td colspan="3">
                            <form action="/api/auditoriums/rows/insert.php" method="POST" class="row" style="width: 100%;">
                                <input type="hidden" name="audi_id" value="<?php echo $audi;?>" />
                                <input type="hidden" name="cap" value="<?php echo $cap;?>" />
                                <input type="text" class="form-control col m-1" placeholder="Row Prefix" name="sr_prefix"/>
                                <input type="text" class="form-control col m-1" placeholder="Row Length" name="sr_length"/>
                                <input type="text" class="form-control col m-1" placeholder="Spacer Location" name="sr_spacer"/>
                                <input type="submit" class="col-md-1 m-1 btn btn-primary" value="Add"/>
                                <input type="button" class="col-md-1 m-1 btn btn-outline-secondary" value="Cancel" ng-click="insertform=false"/>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="deletemodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--bs-danger);">
                    <h4 class="modal-title" style="color: var(--bs-light);">Alert</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-dark">
                    <p>This Auditorium will be deleted along with all the configurations. Do you want to continue?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                    <a href="/api/auditoriums/delete.php?id=<?php echo $audi;?>" class="btn btn-danger">Delete</a>
                </div>
            </div>
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