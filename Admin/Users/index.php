<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");

        checkusertype("A");
    ?>
    <script src="UserScript.js"></script>
    <title>Users</title>
</head>
<body ng-app="UserApp" ng-controller="ctrl">
    <?php require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html");?>
    <div class="container">
        <h2>
            Employees
            <button class="btn btn-primary float-end" type="button" id="toggler" ng-hide="insertform" ng-click="insertform=true">Add New</button>
        </h2>
        <hr />
        <form method="post" id="form1" ng-show="insertform" onsubmit="mysubmit()">
            <div class="row g-3">
                <div class="col-md-2">
                    <input class="form-control" type="text" name="user_id" placeholder="Enter User ID">
                </div>
                <div class="col-md-2">
                    <input class="form-control" type="text" name="user_password" placeholder="Password">
                </div>
                <div class="col-md-2">
                    <input class="form-control" type="text" name="user_name" placeholder="Full Name">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="user_type">
                        <option value="" selected>Select user type</option>
                        <option value="A" name="user_type" >Admin</option>
                        <option value="M" name="user_type" >Manager</option>
                        <option value="S" name="user_type" >Sales</option>
                    </select>
                </div>
                <div class="col">
                    <input class="btn btn-primary" type="submit" value="Save" name="submit" ng-click="insertform=false"/>
                    <input type="button" class="btn btn-outline-secondary" value="Cancle" ng-click="insertform=false"/>
                </div>
            </div>
        </form>
    </div>
    <div class="container upshadow my-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User ID</th>
                        <th>Password</th>
                        <th>Full Name</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="u in users">
                        <td>{{$index + 1}}</td>
                        <td>{{u.user_id}}</td>
                        <td>
                            <span ng-hide="u.edit" class="text-muted">&#9679;&#9679;&#9679;&#9679;</span>
                            <input ng-show="u.edit" type="text" name="user_passsword" ng-model="u.user_password" class="form-control form-control-sm">
                        </td>
                        <td>
                            <span ng-hide="u.edit">{{u.user_name}}</span>
                            <input ng-show="u.edit" type="text" name="user_name" ng-model="u.user_name" class="form-control form-control-sm">
                        </td>
                        <td>
                            <span ng-hide="u.edit">{{u.user_type}}</span>
                            <input ng-show="u.edit" type="text" name="user_type" ng-model="u.user_type" list="datalistOptions"  class="form-control form-control-sm">
                                <datalist id="datalistOptions">
                                    <option value="Admin">
                                    <option value="Manager">
                                    <option value="Sales">
                                </datalist>


                        </td>
                        <td style="text-align: center;">
                            <span ng-hide="u.edit">
                                <i ng-click="openeditor($index)" class="material-icons" style="margin-right: 10px;cursor:pointer;">edit</i>
                                <i ng-click="selected($index)" class="material-icons" style="margin-left: 10px;cursor:pointer;" data-bs-toggle="modal" data-bs-target="#deletemodal">delete_forever</i>
                            </span>
                            <span ng-show="u.edit">
                                <button class="btn btn-primary btn-sm" type="submit" ng-click="update($index)">Save</button>
                                <input type="button" class="btn btn-outline-secondary btn-sm" value="Cancel" ng-click="u.edit=false"/>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Popup elements -->
    <div class="modal fade" role="dialog" tabindex="-1" id="deletemodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--bs-danger);">
                    <h4 class="modal-title" style="color: var(--bs-light);">Alert</h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>The user data will be deleted and their access to this application will be revoked. Do you want to continue?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                    <span ng-click="delete()" class="btn btn-danger" data-bs-dismiss="modal">Delete</span>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container position-absolute bottom-0 end-0 m-3">
        <div class="toast hide align-items-center text-white " id="toast_bg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-animation="true" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body" id="toast_content">
                    //message here
                </div>
            </div>
        </div>
    </div>
</body>
</html>