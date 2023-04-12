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
                    $row = $res->fetch_assoc();
                    if ($row['mod_status'] == 'MOD') {
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

    <div class="row mt-4 h-100 mw-100">
        <div class="col-lg-2"></div>
        <div class="col-lg-6 text-center">
            <?php
                $stmt = $mysqli->prepare("SELECT Runs.link AS link, Users.username AS username, Runs.run_time AS run_time, Runs.approved AS approved
                                        FROM Runs LEFT JOIN Users ON Users.id = Runs.user_id 
                                        WHERE Runs.id = ?");
                $stmt->bind_param("i", $_GET["r"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();

                if ($row) {
                    $youtube_link = substr(strchr($row['link'], "="), 1);
                    printf("<iframe width=\"600\" height=\"400\" src=\"https://www.youtube.com/embed/%s\"></iframe>", $youtube_link);
                    printf("<h1 class=\"h1 text-warning mt-2\">%s:     %s</h1>", $row['username'], Time_To_String($row['run_time']));
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
                
                $stmt = $mysqli->prepare("SELECT Comments.content AS content, Users.username AS username, Users.id AS user_id, 
                                        Comments.id AS comment_id, Users.profile_pic AS profile_pic, Comments.time_posted AS time_posted 
                                        FROM Comments LEFT JOIN Users ON Users.id = Comments.user_id 
                                        WHERE Comments.run_id = ?");
                $stmt->bind_param("i", $_GET["r"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();

                if ($row) {
                    echo("<h2 class=\"h2 text-warning mb-4\">Comments:</h1>");
                    while($row) {
                        echo("<div class=\"row mb-1\"><div class=\"col-lg-3 text-secondary pe-0\">");
                        printf("<img alt=\"profile picture\" class=\"me-2\" height=\"25\" width=\"25\" src=\"%s\"/>", $row['profile_pic']);
                        echo($row['username']);
                        echo(":</div>");
                        echo("<div class=\"col-lg-9 text-light ps-0\">");
                        echo($row['content']);
                        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $row['user_id']) {
                            echo("<form action=\"delete_comment.php\" method=\"post\">");
                            printf("<input type=\"hidden\" id=\"comment_id\" name=\"comment_id\" value=\"%d\">", $row['comment_id']);
                            printf("<input type=\"hidden\" id=\"run_id\" name=\"run_id\" value=\"%d\">", $_GET["r"]);
                            echo("<button type=\"submit\" class=\"btn btn-dark btn-sm text-warning\">Delete</button>
                                </form>");
                        }
                        echo("</div></div>");
                        printf("<div class=\"row mb-4 text-secondary\">%s</div>", TimeSince($row['time_posted'])." ago");
                        $row = $res->fetch_assoc();
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