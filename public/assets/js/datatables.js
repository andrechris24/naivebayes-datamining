function initError(message) {
	iziToast.error({
		title: "Terjadi kesalahan fatal pada DataTables",
		displayMode: 2
	});
	console.error(message);
}
function errorDT(message) {
	console.warn(message);
	iziToast.warning({
		title: "DataTables Warning",
		message: message,
		timeout: 8000,
		displayMode: 2
	});
}
