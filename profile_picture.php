<?php
    include("header.php");

    if (!empty($_FILES['image']['name'])) {
        $picture_string = "pictures/".$_FILES['image']['name']."-".$_POST['username'];

        move_uploaded_file($_FILES['image']['tmp_name'], $picture_string);

        $stmt = $mysqli->prepare("UPDATE Users SET profile_pic = ? WHERE username = ?");
        $stmt->bind_param("ss", $picture_string, $_POST['username']);
        if(!$stmt->execute()) {
            header("Location: profile_page?u=".$_POST['user']."&&err=1");
        }
        echo 'worked';
    }
    else {
        //Goto user page with error for no uploaded file
        header("Location: profile_page?u=".$_POST['user']."&&err=3");
        echo 'failed';
    }

    header("Location: profile_page.php?u=".$_POST['username']);
?>