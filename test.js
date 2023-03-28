function ll(form) {
    if (form.value == "One Lap") window.location.replace("index.php?r=0");
    else if (form.value == "Three Lap") window.location.replace("index.php?r=1");
}

function ChangeForm(form_value) {
    if (form_value == 0) {
        document.getElementById("leaderboards").value = "One Lap";
    }
    else if (form_value == 1) {
        document.getElementById("leaderboards").value = "Three Lap";
    }
}