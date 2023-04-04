<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Joe's Run Approval Race</title>
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
                include("token.php");

                if (isset($_SESSION['token']) && !Validate_Token($_SESSION['token'])) {
                    Remove_Token($_SESSION['token']);
                    $_SESSION['token'] = null;
                    $_SESSION['user_id'] = null;
                    header("Location: login_form.php?err=4");
                }

                if (!isset($_SESSION["token"])) {
                    header("Location: login_form.php?err=3");
                }
                else {
                    echo("                <li class=\"nav-item me-5 ms-5 fs-4\">
                    <a class=\"nav-link text-warning\" href=\"submit_form.php\">Submit</a>
                    </li>");

                    echo("                <li class=\"nav-item me-5 ms-5 fs-4\">
                    <a class=\"nav-link text-warning login-link\" href=\"logout.php\">Logout</a>
                    </li>");
                }     
            ?>
    </nav>
    <div class="row h-100 mw-100">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <?php
            if (isset($_GET['err']) && $_GET['err'] == 1) {
                echo("<h1 class=\"h1 text-danger text-center mt-4\">Failed to update run</h1>");
            }

            $stmt = $mysqli->prepare("SELECT Users.username, Runs.run_time, Runs.link, Runs.date_completed, Runs.console, Runs.id 
                                    FROM Runs LEFT JOIN Users ON Users.id = Runs.user_id
                                    WHERE Runs.approved = 'Maybe' AND Runs.user_id != ?");
            $stmt->bind_param("i", $_SESSION["user_id"]);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_row();

            $table = false;
            if($row) {
                echo("<table class=\"table table-dark table-bordered table-striped fs-3 mt-5\">
                <thead>
                    <tr class=\"text-warning\">
                              <th scope=\"col\">Name</th>
                              <th scope=\"col\">Time</th>
                              <th scope=\"col\">Link</th>
                              <th scope=\"col\">Date</th>
                              <th scope=\"col\">Platform</th>
                              <th scope=\"col\">Approve</th>
                            </tr>
                          </thead>");
                          $table = true;
            }
            else {
                echo("<h1 class=\"h1 text-warning bg-dark text-center mt-4 p-5\">No unapproved runs</h1>");
            }

            while($row) {
                printf("<tr><th scope=\"row\"><a href=\"profile_page.php?u=%s\">%s</a></th>
                <td><a href=\"run_page.php?r=%d\">%s</a></td>
                <td><a href=\"%s\">%s</a></td>
                <td>%s</td>
                <td>%s</td>
                <td><button class=\"btn btn-light ms-3 me-3\" onclick=\"window.location.href='approve_run.php?r=%d&&y=0'\">Yes</button>
                    <button class=\"btn btn-light\" onclick=\"window.location.href='approve_run.php?r=%d&&y=1'\">No</button>
                </td></tr>", $row[0], $row[0], $row[5], Time_To_String($row[1]), $row[2], $row[2], $row[3], $row[4], $row[5], $row[5]);
                $row = $res->fetch_row();
            }

            if($table) echo("</table>");
        ?>
    </div>
    <div class="col-lg-1"></div>
    </div>
</body>
    <script src="index.js"></script>
</html>