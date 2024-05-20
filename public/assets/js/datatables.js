function removeBtn() {
	$("#spare-button").addClass("d-none");
}
function initError(message) {
	Notiflix.Notify.failure("Terjadi kesalahan fatal pada DataTables", {
		timeout: 5000
	});
	console.error(message);
}
function errorDT(message) {
	console.warn(message);
	Notiflix.Notify.warning(message, { timeout: 8000 });
}
