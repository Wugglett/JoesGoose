function CheckForm(form) {
    document.getElementById('ErrorOne').hidden=true;
    document.getElementById('ErrorTwo').hidden=true;
    document.getElementById('ErrorThree').hidden=true;

    if (form.username.value != form.reusername.value) {
        EnableError(1);
        return false;
    }
    else if (form.password.value != form.repassword.value) { 
        EnableError(2);
        return false;
    }
    else return true;
}

function EnableError(error) {
    if (error == 1) {
        document.getElementById('ErrorOne').hidden=false;
    }
    else if (error == 2) {
        document.getElementById('ErrorTwo').hidden=false;
    }
    else if (error == 3) {
        document.getElementById('ErrorThree').hidden=false;
    }
}