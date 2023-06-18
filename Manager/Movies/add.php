<!DOCTYPE html>
<html>
<head>
    <?php 
        require($_SERVER['DOCUMENT_ROOT']."/authuser.php");
        require($_SERVER['DOCUMENT_ROOT']."/_Header.html");

        checkusertype("M");
    ?>
    <title>Movies</title>
    <link href="MovieStyle.css" rel="stylesheet">
</head>
<body>
    <?php require($_SERVER['DOCUMENT_ROOT']."/_Navbar.html"); ?>
    <div class="container">
        <form id="form" class="row g-3">
            <div class="form-group col-md-7">
                <input type="text" class="form-control" id="name" placeholder="Movie Name" required>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" id="year" placeholder="Release Year">
            </div>
            <button type="submit" class="btn btn-primary col-md-1">Search</button>
        </form>
        <main id="main" class="my-5">

        </main>
        <script src="MovieScript.js"></script>
    </div>
</body>
</html>