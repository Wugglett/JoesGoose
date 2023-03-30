function CheckForm(form) {
    document.getElementById('ErrorOne').hidden=true;
    document.getElementById('ErrorTwo').hidden=true;

    if (form.content.value == "" || form.content.value == null) {
        EnableError(1);
        return false;
    }

    else return true;
}