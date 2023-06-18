<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");

        checkusertype("M");

        if(isset($_GET['movie_id']) && $_GET['movie_id'] > 0){
            require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");
            $id = $_GET['movie_id'];
            $query = "SELECT * from movie_master where movie_id = $id";

            $get_data = mysqli_query($conn,$query);
            if(mysqli_num_rows($get_data) == 1)
            {
                while($row = mysqli_fetch_assoc($get_data))
                {
                    $movie = $row;
                }
            }
            else
            {
                header("location: /Manager/Movies");
            }
        }
        else{
            header("location: /Manager/Movies");
        }
        
    ?>
    <title>Movie Details</title>
</head>
<body ng-app="App" ng-controller="Ctrl">
    <?php require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html"); ?>
    <div class="container">
        <div class="table-responsive">
            <table style="width: 100%;" class="table table-borderless">
                <tr>
                    <td rowspan="4" style="width: 170px;"><img src="<?php echo $movie['poster']; ?>" alt="Poster" style="height: 200px;"/></td>
                    <td>
                        <h2>
                            <?php echo $movie['title']; ?>
                            <i ng-hide="editor" ng-click="editor=true" style="cursor: pointer;" class="material-icons float-end">edit</i>
                        </h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo $movie['studio']; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $movie['genres']; ?>
                    </td>
                </tr>
                <tr>
                    <td ng-hide="editor">
                        Duration : <?php echo $movie['run_time']; ?> M  <br/>
                        Interval : <?php echo $movie['interval_time']; ?> M <br/>
                        Reset : <?php echo $movie['reset_time']; ?> M   <br/>
                    </td>
                    <td ng-show="editor">
                        <form action="/api/movies/update.php" method="POST" id="form" class="row" style="width: 600px;">
                            <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>" />
                            <div class="form-group col-md-4">
                                <label class="text-muted">Interval Time</label>
                                <input type="number" class="form-control" name="interval_time" value="<?php echo $movie['interval_time']; ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="text-muted">Reset Time</label>
                                <input type="number" class="form-control" name="reset_time" value="<?php echo $movie['reset_time']; ?>" required>
                            </div>   
                            <div class="text-muted col">
                                <button type="submit" class="btn btn-primary" style="margin-top:23px ;">Save</button>
                                <button ng-click="editor=false" type="button" class="btn-close float-end" style="margin-top: 33px;"></button>
                            </div>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="container my-5">
        <h5>
            Create variations of this movie to assign it in a show.
            <button ng-hide="insertform" class="btn btn-primary float-end" ng-click="insertform=true">Add Variant</button>
        </h5>
        <br/>
        <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Variation</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td ng-show="insertform">0</td>
                    <td colspan="4" ng-show="insertform">
                        <form action="/api/movies/variations/insert.php" method="POST" class="row" style="width: 100%;">
                            <div class="col">
                                <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>" />
                                <input type="hidden" name="var_id" value="{{v.var_id}}" />
                                <input type="text" name="var_name" class="form-control form-control-sm" />
                            </div>
                            <div class="col">
                                <input type="text" name="status" class="form-control form-control-sm" list="datalistOptions"/>
                                <datalist id="datalistOptions">
                                    <option value="Now Showing">
                                    <option value="Coming Soon">
                                    <option value="Off Air">
                                </datalist>
                            </div>
                            <div class="col">
                                <input type="text" name="amount" class="form-control form-control-sm" />
                            </div>
                            <div class="col">
                                <input type="submit" value="Add" class="btn btn-primary btn-sm" />
                                <input type="button" value="Cancel" ng-click="insertform=false" class="btn btn-sm btn-outline-secondary" />
                            </div>
                        </form>
                    </td>
                </tr>
                <tr ng-repeat = "v in vars">
                    <td>{{$index + 1}}</td>
                    <td ng-hide="v.edit">{{v.var_name}}</td>
                    <td ng-hide="v.edit">{{v.status}}</td>
                    <td ng-hide="v.edit">{{v.amount}}</td>
                    <td ng-hide="v.edit">
                        <i class="material-icons" style="margin-right:10px;cursor:pointer;" ng-click="openeditor($index)" >edit</i>
                    </td>

                    <td colspan="4" ng-show="v.edit">
                        <form action="/api/movies/variations/update.php" method="POST" class="row" style="width: 100%;">
                            <div class="col">
                                <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>" />
                                <input type="hidden" name="var_id" value="{{v.var_id}}" />
                                <input type="text" name="var_name" ng-model="v.var_name" class="form-control form-control-sm" />
                            </div>
                            <div class="col">
                                <input type="text" name="status" ng-model="v.status" class="form-control form-control-sm" list="datalistOptions"/>
                                <datalist id="datalistOptions">
                                    <option value="Now Showing">
                                    <option value="Coming Soon">
                                    <option value="Off Air">
                                </datalist>
                            </div>
                            <div class="col">
                                <input type="text" name="amount" ng-model="v.amount" class="form-control form-control-sm" />
                            </div>
                            <div class="col">
                                <input type="submit" value="Save" class="btn btn-primary btn-sm" />
                                <input type="button" value="Cancel" ng-click="v.edit=false" class="btn btn-sm btn-outline-secondary" />
                            </div>
                        </form>
                    </td>
                </tr>
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
    <script src="MovieDetailsScript.js" defer></script>
</body>
</html>