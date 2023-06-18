<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");

        checkusertype("M");
    ?>
    <script src="AuditoriumScript.js" defer></script>
    <title>Auditoriums</title>
</head>
<body ng-app="App" ng-controller="Ctrl">
    <?php require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html"); ?>
    <div class="container">
        <h2>
            Auditoriums
            <button class="btn btn-primary float-end" type="button" ng-hide="insertform" ng-click="insertform=true">Create</button>
        </h2>
        <hr />
        <form action="/api/auditoriums/insert.php" method="POST" class="row g-3" ng-show="insertform">
            <div class="col-md-8">
                <input type="text" name="audi_name" placeholder="Auditorium Name" class="form-control" />
            </div>
            <div class="col">
                <input type="submit" class="btn btn-primary" value="Continue"/>
                <input type="button" class="btn btn-outline-secondary" value="Cancle" ng-click="insertform=false"/>
            </div>
        </form>
    </div>
    <div class="container upshadow my-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Auditorium Name</th>
                        <th>Seating Capacity</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="a in audis">
                        <td>{{a.audi_id}}</td>
                        <td>{{a.audi_name}}</td>
                        <td>{{a.capacity}}</td>
                        <td>
                            <a href="AudiSeats.php?audi_id={{a.audi_id}}" class="text-dark"><i class="material-icons" style="cursor:pointer;">edit</i></a>
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
</body>
</html>