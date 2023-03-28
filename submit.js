function CheckForm(form) {
    document.getElementById('ErrorOne').hidden=true;
    document.getElementById('ErrorTwo').hidden=true;
    document.getElementById('ErrorThree').hidden=true;

    // Make sure that link and run time fields are not left empty
    if (form.runlink.value == "" || form.runlink.value == null) {
        EnableError(1);
        return false;
    }
    else if (form.runtime.value == "" || form.runtime.value == null) { 
        EnableError(2);
        return false;
    }
    // Using regular expression to check for correct formatting of Run Time
    else if(!/^\d\d:\d\d:\d\d$/.test(form.runtime.value)) {
        EnableError(3);
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