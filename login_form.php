<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Joe's Login Race</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fw-bold">
        <a class="navbar-brand text-info fs-3 ps-3" href="index.php">Joe's Mongoose Parkour Race</a>
    </nav>
    <?php
        if (isset($_GET["err"])) {
            echo("<div class=\"row\">");
            echo("<div class=\"col-lg-4\"></div>");
            echo("<div class=\"col-lg-4\">");
            echo("<h1 class=\"h1 text-danger text-center mt-4\">Incorrect Username or Password</h1>");
            echo("</div>");
            echo("<div class=\"col-lg-4\"></div>");
            echo("</div>");
        }
    ?>
    <div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
    <form action="login.php" method="post" class="mt-5 text-center bg-dark p-5">
        <h1 class="h1 text-warning mb-5">Login existing user</h1>
        <div class="form-group mt-3">
        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
        </div>
        <div class="form-group mt-3">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary mt-3 fs-4">Login</button>
        <div class="form-group mt-4 fs-5"><a href="register_form.php">or Register an account</a></div>
    </form>
    </div>
    <div class="col-lg-4"></div>
    </div>
</body>
    <script src="index.js"></script>
</html>