<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");

        checkusertype("M");
    ?>
    <title>Homepage</title>
</head>
<body>
    <?php
        require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html");
        $user_name = $_SESSION['user_name'];
    ?>
    <div class="container">
        <h2 class="text-muted">Welcome, <b class="text-dark"><?php echo $user_name;?></b></h2>
        <hr class="my-5"/>

        <div class="row g-3">
            <div class="card m-3 upshadow" style="width: 18rem; border:none;">
                <img src="/assets/images/card_img_audi.png" class="card-img-top" alt="Auditoriums">
                <div class="card-body">
                    <h5 class="card-title">Auditoriums</h5>
                    <p class="card-text text-muted">Here you can set up your auditoriums and configure seating arrangements.</p>
                    <a href="Auditoriums" class="btn btn-primary stretched-link">Manage</a>
                </div>
            </div>
            <div class="card m-3 upshadow" style="width: 18rem;border:none;">
                <img src="/assets/images/card_img_movie.png" class="card-img-top" alt="Movies">
                <div class="card-body">
                    <h5 class="card-title">Movies</h5>
                    <p class="card-text text-muted">Now manage which movies should be displayed along with multiple variations.</p>
                    <a href="Movies" class="btn btn-primary stretched-link">Manage</a>
                </div>
            </div>
            <div class="card m-3 upshadow" style="width: 18rem;border:none;">
                <img src="/assets/images/card_img_show.png" class="card-img-top" alt="Shows">
                <div class="card-body">
                    <h5 class="card-title">Shows</h5>
                    <p class="card-text text-muted">Create shows and assign auditoriums for bookings with active movies.</p>
                    <a href="Shows" class="btn btn-primary stretched-link">Manage</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>