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
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <?php
            session_start();
            include("header.php");
            include("helper_funcs.php");

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
                <td>%s</td>
                <td><a href=\"%s\">%s</a></td>
                <td>%s</td>
                <td>%s</td>
                <td><button class=\"btn btn-light ms-3 me-3\" onclick=\"window.location.href='approve_run.php?r=%d&&y=0'\">Yes</button>
                    <button class=\"btn btn-light\" onclick=\"window.location.href='approve_run.php?r=%d&&y=1'\">No</button>
                </td></tr>", $row[0], $row[0], Time_To_String($row[1]), $row[2], $row[2], $row[3], $row[4], $row[5], $row[5]);
                $row = $res->fetch_row();
            }

            if($table) echo("</table>");
        ?>
    </div>
    <div class="col-lg-2"></div>
    </div>
</body>
    <script src="index.js"></script>
</html>