const setTableColor = () => {
	document
		.querySelectorAll(".dataTables_paginate .pagination")
		.forEach((dt) => {
			dt.classList.add("pagination-primary");
		});
};
function removeBtn() {
	$("#spare-button").addClass("d-none");
}
function initError(message) {
	Notiflix.Notify.failure("Data gagal dimuat");
	console.error(message);
}
function errorDT(message, note) {
	Notiflix.Notify.warning(message);
	console.warn(message);
	if(note) console.info("%chttps://datatables.net/tn/" + note);
}
