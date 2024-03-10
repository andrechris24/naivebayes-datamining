const passwords = document.querySelectorAll('input[type="password"]'),
    message = document.querySelectorAll(".caps-lock");
for (let a = 0; a < passwords.length; a++) {
    passwords[a].addEventListener("keydown", function (e) {
        if (e.getModifierState("CapsLock"))
            message[a].classList.remove("d-none");
        else message[a].classList.add("d-none");
    });
}
