<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");

        checkusertype("M");
    ?>
    <title>Movies</title>
</head>
<body>
    <?php require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html"); ?>
    <div class="container">
        <h2>
            Manage Movies
            <a href="add.php" class="btn btn-primary float-end">Import</a>
        </h2>
        <hr />
    </div>
    <div class="container upshadow my-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th>Movie ID</th>
                    <th>Title</th>
                    <th>Variations</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php

                        require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

                        $query = "SELECT movie_master.movie_id,movie_master.title, COUNT(movie_variation.var_id) AS variations
                                        FROM movie_master
                                        LEFT OUTER JOIN movie_variation ON movie_master.movie_id = movie_variation.movie_id
                                        GROUP BY title ORDER BY movie_master.movie_id;";

                        $get_data = mysqli_query($conn,$query);
                        if(mysqli_num_rows($get_data) > 0)
                        {
                            while($row = mysqli_fetch_assoc($get_data))
                            {
                                echo "
                                <tr>
                                    <td>".$row['movie_id']."</td>
                                    <td>".$row['title']."</td>
                                    <td>".$row['variations']."</td>
                                    <td><a href='details.php?movie_id=".$row['movie_id']."'><i class='material-icons'>edit</i></a></td>
                                </tr>
                                ";
                            }
                        }
                        else
                        {
                            echo "<tr><td colspan='4' class='text-muted'>No movies found</td></tr>";
                        }
                    ?>
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