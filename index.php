<?php
    session_start();
    $_SESSION['user_id'] = $_SESSION['user_name'] = $_SESSION['user_type'] = "";
    $err_msg = $msg_class = "";
    
    if(isset($_GET['q']) && $_GET['q'] == "logout")
    {
        $msg_class = "success";
        $err_msg = "You have logged out successfully.";   
    }
    if(isset($_POST['user_id']) && isset($_POST['user_password']))
    {        
        $userid = $pass = "";
        if(empty(trim($_POST["user_id"])) || empty(trim($_POST["user_password"])))
        {
            $msg_class = "danger";
            $err_msg = "Please provide User ID and Password.";
        }
        else
        {
            $userid = trim($_POST["user_id"]);
            $pass = trim($_POST["user_password"]);

            require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");
            $query = "select * from user_master where user_id = '$userid' and user_password = '$pass'";
            $get_data = mysqli_query($conn,$query);
            if(mysqli_num_rows($get_data) == 1)
            {
                while($row = mysqli_fetch_assoc($get_data))
                {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_name'] = $row['user_name'];
                    $_SESSION['user_type'] = $row['user_type'];

                    switch($_SESSION["user_type"])
                    {
                        case "A" : $destination = "Admin"; break;
                        case "M" : $destination = "Manager"; break;
                        case "S" : $destination = "Sales"; break;
                    }
                    header("location: /$destination");
                }
            }
            else
            {
                $msg_class = "danger";
                $err_msg = "Please enter valid User ID / Password";
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php require($_SERVER['DOCUMENT_ROOT']."/_Header.html");?>
    <title>Movieplexx - The Smart Solution For Theatre Management</title>
    <style>
        .creds td{
            width: 50%;
            text-align: right;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="z-index: 1; background-color: #fff;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/home.php">&nbsp;Movieplexx</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    </li>
                </ul>
                <span>
                    <form action="" method="post" style="display:flex;">
                        <input type="text" class="form-control mx-1" placeholder="User ID" name="user_id" required>
                        <input type="password" class="form-control mx-1" placeholder="Password" name="user_password" required>
                        <button type="submit" class="btn btn-outline-dark mx-1" name="login" >Login</button>
                    </form>
                </span>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <div class="row g-3">
            <div class="col-md-4">
                <img src="/assets/images/logo2.png" alt="auditorios" style="width: 100%;"/>
            </div>
            <div class="col my-auto p-5">
                <h1><b>Experience vision of film maker with industry leading picture and sound quality.</b></h1>
            </div>
        </div>
    </div>
    <div class="container">
        <h2 style="text-align: center;"><bd>Credits</bd></h2>
        <br/>
        <table class="table table-borderless creds">
        <tr>
            <td>Guide / Mentor</td>
            <th>Mr. Sohil Pandya Sir</th>
        </tr>
        <tr>
            <td></td>
            <th></th>
        </tr>
        <tr>
            <td>Development Team</td>
            <th>20MCA065 - Hemit Patel</th>
        </tr>
        <tr>
            <td></td>
            <th>20MCA075 - Kishan Patel</th>
        </tr>
        <tr>
            <td></td>
            <th>20MCA076 - Kishankumar Patel</th>
        </tr>
        <tr>
            <td></td>
            <th>20MCA144 - Jay Prajapati</th>
        </tr>
        </table>
    </div>

    <div class="toast-container position-absolute bottom-0 end-0 m-3">
        <div class="toast hide align-items-center text-white bg-<?php echo $msg_class;?>" role="alert" aria-live="assertive" aria-atomic="true" data-bs-animation="true" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $err_msg;?>
                </div>
            </div>
        </div>
    </div>

    <script>
        if("<?php echo $err_msg;?>" != "")
        {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
                var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl)
                });
            toastList.forEach(toast => toast.show());
        }
    </script>
</body>
</html>