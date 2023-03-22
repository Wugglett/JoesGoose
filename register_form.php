<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Joe's Register Race</title>
    <script src="register.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fw-bold">
        <a class="navbar-brand text-info fs-3 ps-3" href="index.php">Joe's Mongoose Parkour Race</a>
    </nav>
    <div class="row">
        <div hidden id="ErrorOne" class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <h1 class="h1 text-danger bg-secondary text-center mt-4">Usernames did not match</h1>
            </div>
            <div class="col-lg-4"></div>
        </div>
        <div hidden id="ErrorTwo" class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <h1 class="h1 text-danger bg-secondary text-center mt-4">Passwords did not match</h1>
            </div>
            <div class="col-lg-4"></div>
        </div>
        <div hidden id="ErrorThree" class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <h1 class="h1 text-danger bg-secondary text-center mt-4">Username already in use</h1>
            </div>
            <div class="col-lg-4"></div>
        </div>
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
        <form OnSubmit="return CheckForm(this)" action="register.php" method="post" class="mt-5 text-center bg-dark p-5">
            <h1 class="h1 text-warning mb-5">Register new user</h1>
            <div class="form-group mt-3">
            <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-group mt-3">
                <input type="text" class="form-control" name="reusername" id="reusername" placeholder="Confirm Username">
            </div>
            <div class="form-group mt-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group mt-3">
            <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Confirm Password">
            </div>
            <button type="submit" class="btn btn-primary mt-3 fs-4">Register</button>
        </form>
        </div>
        <div class="col-lg-4"></div>
        </div>
</body>
<?php
    if (isset($_GET["err"])) {
        if ($_GET["err"] == 1) {echo("<script type=\"text/javascript\">EnableError(1)</script>");}
        else if ($_GET["err"] == 2) {echo("<script type=\"text/javascript\">EnableError(2)</script>");}
        else if ($_GET["err"] == 3) {echo("<script type=\"text/javascript\">EnableError(3)</script>");}
    }
?>
</html>