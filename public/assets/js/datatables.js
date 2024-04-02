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
	notif.error("Data gagal dimuat");
	console.error(message);
}
function errorDT(message, note) {
	const err = notif.open({ type: "warning", message: message });
	if (note) {
		err.on("click", () => {
			// target: the notification being clicked
			// event: the mouseevent
			window.open("https://datatables.net/tn/" + note, "_blank");
		});
	}
	console.warn(message);
}
