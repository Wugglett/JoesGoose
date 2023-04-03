<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Joe's Run Page Race</title>
    <script src="run_page.js"></script>
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
    </nav>

    <div class="row mt-4">
        <div class="col-lg-2"></div>
        <div class="col-lg-6 text-center">
            <?php
                $stmt = $mysqli->prepare("SELECT Runs.link, Users.username, Runs.run_time FROM Runs LEFT JOIN Users ON Users.id = Runs.user_id WHERE Runs.id = ?");
                $stmt->bind_param("i", $_GET["r"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_row();

                if ($row) {
                    $youtube_link = substr(strchr($row[0], "="), 1);
                    printf("<iframe width=\"600\" height=\"400\" src=\"https://www.youtube.com/embed/%s\"></iframe>", $youtube_link);
                    printf("<h1 class=\"h1 text-warning mt-2\">%s:     %s</h1>", $row[1], Time_To_String($row[2]));
                }
                else {
                    echo("<h1 class=\"h1 bg-secondary text-warning mt-2\">Something went wrong</h1>");
                }
                echo("</div>");
                
                echo("<div class=\"col-lg-4\">");
                
                echo("<h5 hidden class=\"h5 text-danger\" id=\"ErrorOne\">Cannot post blank comment</h5>");
                
                if (isset($_GET['err']) && $_GET['err'] == 1) {
                    echo("<h1 class=\"h1 text-danger text-center mt-4\">Failed to post comment</h1>");
                }

                if (isset($_GET['err']) && $_GET['err'] == 2) {
                    echo("<h1 class=\"h1 text-danger text-center mt-4\">Failed to delete comment</h1>");
                }

                if (isset($_GET["u"])) echo("<h5 class=\"h5 text-danger\" id=\"ErrorTwo\">Must be logged in to post comment</h5>");

                echo("<form OnSubmit=\"return CheckForm(this)\" action=\"comment.php\" method=\"post\" class=\"mb-5\">
                        <div class=\"form-group\">
                            <h3 class=\"h3 text-warning\">Write a comment</h1>
                            <textarea class=\"form-control\" id=\"content\" name=\"content\" rows=\"2\" placeholder=\"Write your comment here\"></textarea>");
                printf("<input type=\"hidden\" id=\"run\" name=\"run\" value=\"%d\">", $_GET["r"]);
                echo("<button type=\"submit\" class=\"btn btn-dark mt-2\">Post</button>
                        </div>
                    </form>");
                
                $stmt = $mysqli->prepare("SELECT Comments.content, Users.username, Users.id, Comments.id FROM Comments LEFT JOIN Users ON Users.id = Comments.user_id WHERE Comments.run_id = ?");
                $stmt->bind_param("i", $_GET["r"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_row();

                if ($row) {
                    echo("<h2 class=\"h2 text-warning mb-4\">Comments:</h1>");
                    while($row) {
                        echo("<div class=\"row mb-3\"><div class=\"col-lg-1 text-secondary\">");
                        echo($row[1]);
                        echo(":</div>");
                        echo("<div class=\"col-lg-11 text-light\">");
                        echo($row[0]);
                        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $row[2]) {
                            echo("<form action=\"delete_comment.php\" method=\"post\">");
                            printf("<input type=\"hidden\" id=\"comment_id\" name=\"comment_id\" value=\"%d\">", $row[3]);
                            printf("<input type=\"hidden\" id=\"run_id\" name=\"run_id\" value=\"%d\">", $_GET["r"]);
                            echo("<button type=\"submit\" class=\"btn btn-dark btn-sm text-warning\">Delete</button>
                                </form>");
                        }
                        echo("</div></div>");
                        $row = $res->fetch_row();
                    }
                }
                else {
                    echo("<h2 class=\"h2 text-light\">No Comments</h1>");
                }

                echo("</div>");
            ?>
    </div>
</body>
</html>