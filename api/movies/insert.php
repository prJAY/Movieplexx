<?php
    require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
    checkusertype("M");
    require($_SERVER['DOCUMENT_ROOT']."/dbconfig.php");

    if(isset($_POST['tmdb']))
    {
        $title = $_POST['title'];
        $tmdb = $_POST['tmdb'];
        $overview= $_POST['overview'];
        $releasedate= $_POST['releasedate'];
        $studio= $_POST['studio'];
        $poster= $_POST['poster'];
        $banner= $_POST['banner'];
        $runtime= $_POST['runtime'];
        $genres = $_POST['genres'];

        if($title == "" || $tmdb == "" || $genres == "" || $overview == "" || $releasedate == "" || $studio == "" || $poster == "" || $banner == "" || $runtime == "" )
        {
            $_SESSION['code'] = "400:No Data Received";
            header("location: /Manager/Movies/");
        }
        else
        {
            $query = "INSERT INTO movie_master (title, tmdb, genres, overview, releasedate, studio, poster, banner, run_time)
            VALUES ('$title','$tmdb','$genres','$overview','$releasedate','$studio','$poster','$banner','$runtime')";
            $result = mysqli_query($conn,$query);
            if($result)
            {
                $_SESSION['code'] = "200:Movie Added";
                header("location: /Manager/Movies/");
            }
            else{

                $_SESSION['code'] = "400:Operation Failed";
                header("location: /Manager/Movies/");
            }
        }
    }
    else{
        $_SESSION['code'] = "400:Data Missing";
        header("location: /Manager/Movies/");
    }
?>