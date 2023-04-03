<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Joe's Run Submit Race</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fw-bold">
        <a class="navbar-brand text-info fs-3 ps-3" href="index.php">Joe's Mongoose Parkour Race</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo0" aria-controls="navbarTogglerDemo0" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo0">
            <ul class="navbar-nav ms-auto">
            <?php
                session_start();
                include("header.php");
                include("helper_funcs.php");

                if (!isset($_SESSION["token"])) {
                    header("Location: login_form.php?err=2");
                }
                else {
                    echo("                <li class=\"nav-item me-5 ms-5 fs-4\">
                    <a class=\"nav-link text-warning login-link\" href=\"logout.php\">Logout</a>
                    </li>");
                }     
            ?>
    </nav>
    <div class="row">
        <div hidden id="ErrorOne" class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <h1 class="h1 text-danger text-center mt-4">Link field cannot be empty</h1>
            </div>
            <div class="col-lg-4"></div>
        </div>
        <div hidden id="ErrorTwo" class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <h1 class="h1 text-danger text-center mt-4">Run Time field cannot be empty</h1>
            </div>
            <div class="col-lg-4"></div>
        </div>
        <div hidden id="ErrorThree" class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <h1 class="h1 text-danger text-center mt-4">Run time format incorrect</h1>
            </div>
            <div class="col-lg-4"></div>
        </div>
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
    <form OnSubmit="return CheckForm(this)" action="submit.php" method="post" class="mt-5 text-center bg-dark p-5">
        <h1 class="h1 text-warning mb-5">Run Submission</h1>
        <div class="form-group mt-3">
            <input type="url" class="form-control" name="runlink" id="runlink" placeholder="Link to run (youtube or other)">
        </div>
        <div class="form-group mt-3">
            <input type="text" class="form-control" name="runtime" id="runtime" placeholder="Run Time (HH:MM:SS)">
        </div>
        <div class="form-group mt-3">
            <select class="form-select form-select-md" name="console" id="console">
              <option value="Xbox One">Xbox One</option>
              <option value="Xbox Series X/S">Xbox Series X/S</option>
              <option value="PC">PC</option>
            </select>
        </div>
        <div class="form-group mt-3">
            <select class="form-select form-select-md" name="runtype" id="runtype">
              <option value="One Lap">One Lap</option>
              <option value="Three Lap">Three Lap</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3 fs-4">Submit Run</button>
    </form>
    </div>
    <div class="col-lg-4"></div>
    </div>
</body>
    <script src="submit.js"></script>
</html>