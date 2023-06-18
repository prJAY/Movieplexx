<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");

        checkusertype("M");
    ?>
    <title>Add Show</title>
</head>
<body ng-app="App" ng-controller="Ctrl">
    <?php require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html"); ?>
    <div class="container">
        <h2>
            Add Show
        </h2>
        <hr />
    </div>
    <div class="container my-5">
        <form action="/api/shows/insert.php" method="POST" class="row g-3">
            <div class="col-md-6">
                <label>Select Auditorium</label>
                <select name="audi_id" class=" form-select">
                    <option ng-repeat="a in audis" value="{{a.audi_id}}">{{a.audi_id + " - " + a.audi_name}}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Select Movie</label>
                <select id="movie_id" class="form-select">
                    <option ng-repeat="m in movies" value="{{m.movie_id}}">{{m.title}}</option>
                </select>
            </div>
            <div class="col-md-12">
                <br/>
                <button type="button" class="btn btn-outline-primary" ng-click="loadvars()">Load Details</button>
                <span class="float-end text-muted">Only the movies with Now Showing status are displayed</span>
                <br/><br/>
            </div>
            <div class="col-md-12">
                <label>Select Movie Variation</label>
                <select name="var_id" class=" form-select">
                    <option ng-repeat="v in vars" value="{{v.var_id}}">{{v.var_name}}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Enter Show Date</label>
                <input type="date" name="show_date" class="form-control"/>
            </div>
            <div class="col-md-6">
                <label>Enter Show Time</label>
                <input type="time" name="show_time" class="form-control"/>
            </div>
            <div class="col-md-12">
                <br/>
                <input type="checkbox" id="rpt" ng-click="rpt?rpt=false:rpt=true;"/>
                <label for="rpt" style="cursor: pointer;">Set Repeatations</label>
                <br/><br/>
                <label ng-show="rpt">Repeat untill</label>
                <input ng-show="rpt" type="Date" name="repeat_date" class="form-control"/>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>

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
    <script src="ShowScript.js" defer></script>
</body>
</html>