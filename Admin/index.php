<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");

        checkusertype("A");
    ?>
    <title>Homepage</title>
</head>
<body>
    <?php
        require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html");
        $user_name = $_SESSION['user_name'];
    ?>
    <div class="container">
        <h2 class="text-muted">Welcome, <b class="text-dark"><?php echo $user_name;?></b>
        </h2>
        <hr class="my-5"/>

        <div class="row g-3">
            <div class="card m-3 upshadow" style="width: 18rem; border:none;">
                <img src="/assets/images/card_img_user.png" class="card-img-top" alt="Employee">
                <div class="card-body">
                    <h5 class="card-title">Manage Employees</h5>
                    <p class="card-text text-muted">Here you can manage details of the employees and also set access limitations for them.</p>
                    <a href="Users" class="btn btn-primary stretched-link">Manage</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>