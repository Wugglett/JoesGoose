function CheckForm(form) {
    document.getElementById('ErrorOne').hidden=true;

    if (form.content.value == "" || form.content.value == null) {
        document.getElementById('ErrorOne').hidden=false;
        return false;
    }

    return true;
}