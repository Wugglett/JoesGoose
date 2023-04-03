<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Joe's Mongoose Parkour Race Speedruns</title>
    <script src="test.js"></script>
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
            </ul>
        </div>
    </nav>
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="row mb-3 mt-3">
                <div class="col-lg-5"></div>
                <div class="col-lg-5"></div>
                <div class="col-lg-2">
                    <select OnChange="ll(this)" class="form-select bg-dark text-warning border-dark" name="leaderboards" id="leaderboards">
                        <option selected>Leaderboard</option>
                        <option value="One Lap">One Lap</option>
                        <option value="Three Lap">Three Lap</option>
                    </select>
                </div>
            </div>
                  <?php
                    $runtype = "One Lap";
                    if (isset($_GET["r"])){
                        if ($_GET["r"] == 0) {
                            $runtype = "One Lap";
                            echo("<script type=\"text/javascript\">ChangeForm(0)</script>");
                        }
                        else if ($_GET["r"] == 1) {
                            $runtype = "Three Lap";
                            echo("<script type=\"text/javascript\">ChangeForm(1)</script>");
                        }
                    }
                    $stmt = $mysqli->prepare("SELECT Users.username, Runs.id, Runs.run_time, Runs.date_completed, Runs.console 
                                            FROM Runs LEFT JOIN Users ON Users.id = Runs.user_id 
                                            WHERE Runs.approved = 'Yes' && Runs.run_type = ?
                                            ORDER BY Runs.run_time ASC");
                    $stmt->bind_param("s", $runtype);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $row = $res->fetch_row();

                    if ($row) {
                        echo("<table class=\"table table-dark table-bordered table-striped fs-3\">
                        <thead>
                            <tr class=\"text-warning\">
                              <th scope=\"col\">Place</th>
                              <th scope=\"col\">Name</th>
                              <th scope=\"col\">Time</th>
                              <th scope=\"col\">Date</th>
                              <th scope=\"col\">Platform</th>
                            </tr>
                          </thead>");

                        $count = 1;
                        while($row) {
                            $color = "";
                            if ($count == 1) $color = "text-warning";
                            else if ($count == 2) $color = "text-info";
                            else if ($count == 3) $color = "text-success";
                            else $color = "text-white";
    
                            printf("<tr><th scope=\"row\" class=\"%s\">#%d</th>
                            <td><a href=\"profile_page.php?u=%s\">%s</a></td>
                            <td><a href=\"run_page.php?r=%d\">%s</a></td>
                            <td>%s</td>
                            <td>%s</td></tr>", $color, $count, $row[0], $row[0], $row[1], Time_To_String($row[2]), $row[3], $row[4]);
                            $count++;
                            $row = $res->fetch_row();
                        }

                        echo("</table>");
                    }
                    else {
                        echo("<h1 class=\"h1 text-warning bg-dark text-center mt-4 p-5\">No runs found</h1>");
                    }
                  ?>
        </div>
        <div class="col-lg-2"></div>
    </div>
</body>
</html>