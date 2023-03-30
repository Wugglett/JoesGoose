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
    </nav>
    <div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-3 me-5"> <h1 class="h1 text-warning ms-5 mt-5 mb-5"><?php echo($_GET["u"]) ?></h1>
    <?php
        session_start();
        include("header.php");
        include("helper_funcs.php");

        $stmt = $mysqli->prepare("SELECT description, id FROM Users WHERE username = ?");
        $stmt->bind_param("s", $_GET["u"]);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_row();

        echo("<h3 class=\"h3 text-secondary ms-5\">User Description:</h3>");

        if ($row[0]) {
            if ($_SESSION["user_id"] == $row[1]) {
                echo("<form action=\"description.php\" method=\"post\"><div class=\"form-group ms-3\">");
                printf("<textarea class=\"form-control\" id=\"content\" name=\"content\" rows=\"4\" placeholder=\"Write your description here\">%s</textarea>", $row[0]);
                printf("<input type=\"hidden\" id=\"user\" name=\"user\" value=\"%s\">", $_GET["u"]);
                echo("<button type=\"submit\" class=\"btn btn-dark mt-2\">Post</button>");
                echo("</div></form>");
            }
            else printf("<h4 class=\"h4 text-secondary ms-5\">%s</h4>", $row[0]);
        }
        else {
            if ($_SESSION["user_id"] == $row[1]) {
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
                    $stmt = $mysqli->prepare("SELECT Runs.run_time, Runs.date_completed, Runs.console, Runs.approved, Runs.id
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
                        printf("<tr><th scope=\"row\"><a href=\"run_page.php?r=%d\">%s</a></th>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td></tr>", $row[4], Time_To_String($row[0]), $row[1], $row[2], $row[3]);
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