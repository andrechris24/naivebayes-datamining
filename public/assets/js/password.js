const passform = document.getElementsByName("password"),
    confpassform = document.getElementsByName("password_confirmation");
function checkpassword() {
    for (let i = 0; i < passform.length; i++) {
        if (passform[i].value !== confpassform[i].value)
            confpassform[i].setCustomValidity("Password konfirmasi salah");
        else confpassform[i].setCustomValidity("");
    }
}
