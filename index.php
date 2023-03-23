<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Joe's Mongoose Parkour Race Speedruns</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fw-bold">
        <a class="navbar-brand text-info fs-3 ps-3" href="">Joe's Mongoose Parkour Race</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo0" aria-controls="navbarTogglerDemo0" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo0">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-5 ms-5 fs-4">
                    <a class="nav-link text-warning login-link" href="">Leaderboards</a>
                </li>
                <?php
                    if (!isset($_SESSION["token"])) {
                        echo("                <li class=\"nav-item me-5 ms-5 fs-4\">
                        <a class=\"nav-link text-warning login-link\" href=\"login_form.php\">Login</a>
                    </li>");
                    }
                    
                    else {
                        echo("                <li class=\"nav-item me-5 ms-5 fs-4\">
                        <a class=\"nav-link text-warning\" href=\"submit.html\">Submit</a>
                    </li>");
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
        <div class="col-lg-8 pt-5 ps-5 pe-5">
            <table class="table table-dark table-bordered table-striped fs-3">
                <thead>
                    <tr class="text-warning">
                      <th scope="col">Place</th>
                      <th scope="col">Name</th>
                      <th scope="col">Time</th>
                      <th scope="col">Date</th>
                      <th scope="col">Platform</th>
                    </tr>
                  </thead>
                  <?php
                    include("header.php");
                    $stmt = $mysqli->prepare("SELECT Users.username, Runs.link, Runs.run_time, Runs.date_completed, Runs.console 
                                            FROM Runs LEFT JOIN Users ON Users.id = Runs.user_id 
                                            WHERE Runs.approved = 'Yes'
                                            ORDER BY Runs.run_time ASC");
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $row = $res->fetch_row();

                    $count = 1;
                    while($row) {
                        $time = $row[2];
                        $hour = (int)($time/60/60);
                        $time -= $hour*60*60;
                        $minute = (int)($time/60);
                        $time -= $minute*60;
                        $second = (int)$time;

                        $hour_string = $hour;
                        if ($hour<10) $hour_string = "0".$hour;
                        
                        $minute_string = $minute;
                        if ($minute<10) $minute_string = "0".$minute;

                        $second_string = $second;
                        if ($second<10) $second_string = "0".$second;

                        $time_string = $hour_string.":".$minute_string.":".$second_string;

                        $color = "";
                        if ($count == 1) $color = "text-warning";
                        else if ($count == 2) $color = "text-info";
                        else if ($count == 3) $color = "text-success";
                        else $color = "text-white";

                        printf("<tr><th scope=\"row\" class=\"%s\">#%d</th>
                        <td><a href=\"\">%s</a></td>
                        <td><a href=\"%s\">%s</a></td>
                        <td>%s</td>
                        <td>%s</td></tr>", $color, $count, $row[0], $row[1], $time_string, $row[3], $row[4]);
                        $count++;
                        $row = $res->fetch_row();
                    }
                  ?>
            </table>
        </div>
        <div class="col-lg-2"></div>
    </div>
</body>
    <script src="index.js"></script>
</html>