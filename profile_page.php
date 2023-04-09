<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Joe's User Profile Race</title>
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
                    echo("                <li class=\"nav-item me-5 ms-5 fs-4\">
                    <a class=\"nav-link text-warning login-link\" href=\"login_form.php\">Login</a>
                    </li>");                    
                }
                else {
                    echo("                <li class=\"nav-item me-5 ms-5 fs-4\">
                    <a class=\"nav-link text-warning\" href=\"submit_form.php\">Submit</a>
                    </li>");

                    $stmt = $mysqli->prepare("SELECT mod_status FROM Users WHERE id = ?");
                    $stmt->bind_param("i", $_SESSION["user_id"]);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $row = $res->fetch_row();
                    if ($row[0] == 'MOD') {
                        echo("                <li class=\"nav-item me-5 ms-5 fs-4\">
                        <a class=\"nav-link text-warning login-link\" href=\"approve.php\">Approve Runs</a>
                        </li>");
                    }
                    
                    echo("                <li class=\"nav-item me-5 ms-5 fs-4\">
                    <a class=\"nav-link text-warning login-link\" href=\"logout.php\">Logout</a>
                    </li>");
                }     
            ?>
    </nav>
    <div class="row h-100 mw-100">
    <div class="col-lg-1"></div>
    <div class="col-lg-3 me-5 text-center">
        <div class="row mt-3 mb-4">
            <div class="col-lg-6 mt-5">
    <?php

       if (isset($_GET['err']) && $_GET['err'] == 1) {
            echo("<h1 class=\"h1 text-danger text-center mt-4\">Failed to upload picture</h1>");
        }

        if (isset($_GET['err']) && $_GET['err'] == 2) {
            echo("<h1 class=\"h1 text-danger text-center mt-4\">Failed to update description</h1>");
        }

        if (isset($_GET['err']) && $_GET['err'] == 3) {
            echo("<h1 class=\"h1 text-danger text-center mt-4\">Did not receive picture file</h1>");
        }        

        $stmt = $mysqli->prepare("SELECT profile_pic, id FROM Users WHERE username = ?");
        $stmt->bind_param("s", $_GET["u"]);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_row();

        $picture_set = "Upload";
        if ($row[0] != NULL) {
            printf("<img height=\"150\" width=\"150\" src=\"%s\"/>", $row[0]);
            $picture_set = "Change";
        }
        else {
            echo("<h3 class\"h3 text-warning\">User has no profile picture</h3>");
        }

        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $row[1]) {
            printf("<div class=\"text-light\"><form action=\"profile_picture.php\" method=\"post\" enctype=\"multipart/form-data\">
            <label>%s Profile Picture:</label>
            <input type=\"file\" name=\"image\" id=\"image\">
            <input type=\"hidden\" name=\"username\" id=\"username\" value=\"%s\">
            <input type=\"submit\" name=\"submit\" value=\"Upload\">
            </form></div>",$picture_set, $_GET["u"]);
        }
    ?>
            </div>
            <div class="col-lg-6">
                <h1 class="h1 text-warning ms-5 mt-5 mb-5"><?php echo($_GET["u"]) ?></h1>
            </div>
        </div>
    <?php
        $stmt = $mysqli->prepare("SELECT description, id FROM Users WHERE username = ?");
        $stmt->bind_param("s", $_GET["u"]);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_row();

        echo("<h3 class=\"h3 text-secondary ms-5\">User Description:</h3>");

        if ($row[0]) {
            if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $row[1]) {
                echo("<form action=\"description.php\" method=\"post\"><div class=\"form-group ms-3\">");
                printf("<textarea class=\"form-control\" id=\"content\" name=\"content\" rows=\"4\" placeholder=\"Write your description here\">%s</textarea>", $row[0]);
                printf("<input type=\"hidden\" id=\"user\" name=\"user\" value=\"%s\">", $_GET["u"]);
                echo("<button type=\"submit\" class=\"btn btn-dark mt-2\">Post</button>");
                echo("</div></form>");
            }
            else printf("<h4 class=\"h4 text-secondary ms-5\">%s</h4>", $row[0]);
        }
        else {
            if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $row[1]) {
                echo("<form action=\"description.php\" method=\"post\"><div class=\"form-group ms-3\">");
                echo("<textarea class=\"form-control\" id=\"content\" name=\"content\" rows=\"4\" placeholder=\"Write your description here\"></textarea>");
                printf("<input type=\"hidden\" id=\"user\" name=\"user\" value=\"%s\">", $_GET["u"]);
                echo("<button type=\"submit\" class=\"btn btn-dark mt-2\">Post</button>");
                echo("</div></form>");
            }
            else echo("<h4 class=\"h4 text-secondary ms-5\">No user description</h4>");
        }
    ?>
    </div>
    <div class="col-lg-7">
        <h1 class="h1 text-warning text-center mt-5">Runs</h1>
                  <?php

                    if (isset($_GET['err']) && $_GET['err'] == 3) {
                        echo("<h1 class=\"h1 text-danger text-center mt-4\">Failed to delete run</h1>");
                    }

                    $stmt = $mysqli->prepare("SELECT Runs.run_time, Runs.date_completed, Runs.console, Runs.approved, Runs.id, Users.id
                                            FROM Runs LEFT JOIN Users ON Users.id = Runs.user_id 
                                            WHERE Users.username = ?
                                            ORDER BY Runs.date_completed ASC");
                    $stmt->bind_param("s", $_GET["u"]);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $row = $res->fetch_row();

                    $table = false;
                    if($row) {
                        echo("<table class=\"table table-dark table-bordered table-striped fs-3\">
                        <thead>
                            <tr class=\"text-warning\">
                              <th scope=\"col\">Time</th>
                              <th scope=\"col\">Date</th>
                              <th scope=\"col\">Platform</th>
                              <th scope=\"col\">Approved</th>");
                              if (isset($_SESSION['user_id']) && $row[5] == $_SESSION['user_id']) echo("<th scope=\"col\">Delete Run</th>");
                          echo("</tr></thead>");
                          $table = true;
                    }
                    else {
                        echo("<h1 class=\"h1 text-warning bg-dark text-center mt-4 p-5\">This user has no runs submitted</h1>");
                    }

                    while($row) {
                        printf("<tr>
                        <th scope=\"row\"><a href=\"run_page.php?r=%d\">%s</a></th>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>", $row[4], Time_To_String($row[0]), $row[1], $row[2], $row[3]);
                        if (isset($_SESSION['user_id']) && $row[5] == $_SESSION['user_id']) printf("<td class=\"text-center\"><button class=\"btn btn-muted text-warning\" onclick=\"window.location.href='delete_runs.php?r=%d&&u=%s'\">Delete</button></td>", $row[4], $_GET['u']);
                        echo("</tr>");
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