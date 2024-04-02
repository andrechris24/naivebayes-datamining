const passwords = document.querySelectorAll('input[type="password"]'),
	message = document.querySelector(".caps-lock");
for (let a = 0; a < passwords.length; a++) {
	passwords[a].addEventListener("keydown", function (e) {
		if (e.getModifierState("CapsLock")) message.classList.remove("d-none");
		else message.classList.add("d-none");
	});
}
