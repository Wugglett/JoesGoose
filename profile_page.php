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
    <div class="row">
    <div class="col-lg-4"> <h1 class="h1 text-warning ms-5 mt-5"><?php echo($_GET["u"]) ?></h1>
    </div>
    <div class="col-lg-4">
        <h1 class="h1 text-warning text-center mt-5">Runs</h1>
                  <?php
                    include("header.php");
                    $stmt = $mysqli->prepare("SELECT Runs.link, Runs.run_time, Runs.date_completed, Runs.console, Runs.approved
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
                              <th scope=\"col\">Approved</th>
                            </tr>
                          </thead>");
                          $table = true;
                    }
                    else {
                        echo("<h1 class=\"h1 text-warning bg-dark text-center mt-4 p-5\">This user has no runs submitted</h1>");
                    }

                    while($row) {
                        $time = $row[1];
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

                        printf("<tr><th scope=\"row\"><a href=\"%s\">%s</a></th>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td></tr>", $row[0], $time_string, $row[2], $row[3], $row[4]);
                        $row = $res->fetch_row();
                    }

                    if($table) echo("</table>");

                  ?>
    </div>
    <div class="col-lg-4"></div>
    </div>
</body>
    <script src="index.js"></script>
</html>