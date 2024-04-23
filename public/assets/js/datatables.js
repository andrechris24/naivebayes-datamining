function removeBtn() {
	$("#spare-button").addClass("d-none");
}
function initError(message) {
	Notiflix.Notify.failure(
		"Terjadi kesalahan fatal pada saat memuat data", { timeout: 5000 }
	);
	console.error(message);
}
function errorDT(message, note) {
	Notiflix.Notify.warning(message, { timeout: 10000 });
	console.warn(message);
	if (note) console.info("https://datatables.net/tn/" + note);
}
