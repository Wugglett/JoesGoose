<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Joe's Admin Race</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fw-bold">
        <a class="navbar-brand text-info fs-3 ps-3" href="index.php">Joe's Mongoose Parkour Race</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo0" aria-controls="navbarTogglerDemo0" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo0">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-5 ms-5 fs-4"><a class="nav-link text-warning login-link" href="submit_form.php">Submit</a></li>
                <li class="nav-item me-5 ms-5 fs-4"><a class="nav-link text-warning login-link" href="approve.php">Approve Runs</a></li>
                <li class="nav-item me-5 ms-5 fs-4"><a class="nav-link text-warning login-link" href="logout.php">Logout</a></li>
            </ul>
    </nav>
    <div class="row h-100 mw-100">
        <div class="col-lg-1"></div>
        <div class="col-lg-4">
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
                else if (!isset($_SESSION["token"])) {
                    header("Location: login_form.php?err=3");
                }

                $stmt = $mysqli->prepare("SELECT mod_status FROM Users WHERE id = ?");
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                if ($row['mod_status'] != 'ADMIN') {
                    header("Location: index.php");
                }

                $stmt = $mysqli->prepare("SELECT username, mod_status FROM Users WHERE id != ?");
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                
                $table = false;

                if (isset($_GET['err']) && $_GET['err'] == 1) echo("<h1 class=\"h1 text-danger text-center mt-4\">Failed to update mod status user</h1>");

                if (isset($_GET['err']) && $_GET['err'] == 3) echo("<h1 class=\"h1 text-danger text-center mt-4\">Failed to ban user</h1>");

                if($row) {
                    echo("<h3 class=\"h3 text-warning text-center mt-4 mb-3\">Users</h3>");
                    echo("<table class=\"table table-dark table-bordered table-striped fs-3\">
                    <thead>
                        <tr class=\"text-warning\">
                                  <th scope=\"col\">Name</th>
                                  <th scope=\"col\">Mod Status</th>
                                  <th scope=\"col\">Ban User</th>
                                </tr>
                              </thead>");
                    $table = true;
                }
                else {
                    echo("<h1 class=\"h1 text-warning bg-dark text-center mt-4 p-5\">No users found</h1>");
                }

                while($row) {
                    $mod1 = "";
                    switch($row['mod_status']) {
                        case 'NON-MOD':
                            $mod1 = 'MOD';
                            break;
                        case 'MOD':
                            $mod1 = 'NON-MOD';
                            break;
                        default:
                            $mod1 = 'NON-MOD';
                            break;
                    }
                    printf("<tr><th scope=\"row\"><a href=\"profile_page.php?u=%s\">%s</a></th>
                    <td>
                        <form action=\"mod_user.php\" class=\"text-center\" method=\"post\"><div class=\"form-group mb-1\">
                            <select class=\"form-select bg-secondary text-warning border-dark\" name=\"mod_status\" id=\"mod_status\">
                                <option selected>%s</option>
                                <option value=\"%s\">%s</option>
                            </select></div>
                            <input type=\"hidden\" name=\"username\" id=\"username\" value=\"%s\">
                            <input type=\"submit\" class=\"btn btn-secondary btn-small\" value=\"Update Status\">
                        </form>
                    </td>
                    <td class=\"text-center\"><button class=\"btn btn-secondary ms-3 me-3\" onclick=\"window.location.href='ban_user.php?u=%s\">Ban</button>
                    </td></tr>", $row['username'], $row['username'], $row['mod_status'], $mod1, $mod1, $row['username'], $row['username']);
                    $row = $res->fetch_assoc();
                }

                if ($table) echo("</table>");
            ?>
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-5">
            <?php
                if (isset($_GET['err']) && $_GET['err'] == 2) echo("<h1 class=\"h1 text-danger text-center mt-4\">Failed to delete run</h1>");
                
                $stmt = $mysqli->prepare("SELECT Users.username AS username, Runs.run_time AS runtime, Runs.link AS link, 
                                                Runs.date_completed AS date_completed, Runs.console AS console, Runs.id AS run_id, Runs.approved AS approved
                                        FROM Runs LEFT JOIN Users ON Users.id = Runs.user_id
                                        ORDER BY Users.username, Runs.date_completed");
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();

                $table = false;
                if($row) {
                    echo("<h3 class=\"h3 text-warning text-center mt-4 mb-3\">Runs</h3>");
                    echo("<table class=\"table table-dark table-bordered table-striped fs-3\">
                    <thead>
                        <tr class=\"text-warning\">
                                <th scope=\"col\">Name</th>
                                <th scope=\"col\">Time</th>
                                <th scope=\"col\">Date</th>
                                <th scope=\"col\">Platform</th>
                                <th scope=\"col\">Approved</th>
                                <th scope=\"col\">Delete</th>
                        </tr>
                    </thead>");
                             $table = true;
                }
                else { //need to figure out how to redirect back to admin page after run deletion
                  echo("<h1 class=\"h1 text-warning bg-dark text-center mt-4 p-5\">No runs found</h1>");
                }

                while($row) {
                    printf("<tr><th scope=\"row\"><a href=\"profile_page.php?u=%s\">%s</a></th>
                        <td><a href=\"run_page.php?r=%d\">%s</a></td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td><button class=\"btn btn-secondary ms-3 me-3\" onclick=\"window.location.href='delete_runs.php?r=%d&&u=%s&&l=a'\">Delete</button>
                        </td></tr>", $row['username'], $row['username'], $row['run_id'], Time_To_String($row['runtime']), 
                                    $row['date_completed'], $row['console'], $row['approved'], $row['run_id'], $row['run_id'], $row['username']);
                   $row = $res->fetch_assoc();
                }

                if($table) echo("</table>");
            ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
</body>
</html>