const passwords = document.querySelectorAll('input[type="password"]');
for (let a = 0; a < passwords.length; a++) {
	passwords[a].addEventListener("keydown", function (e) {
		if (e.getModifierState("CapsLock")) $(".caps-lock").removeClass("d-none");
		else $(".caps-lock").addClass("d-none");
	});
}
