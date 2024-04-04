const notif = new Notyf({
	duration: 5000,
	types: [
		{
			type: "warning",
			background: "orange",
			duration: 10000,
			icon: {
				className: "fa-solid fa-triangle-exclamation",
				tagName: "i"
			}
		},
		{
			type: "info",
			background: "blue",
			icon: {
				className: "fa-solid fa-circle-info",
				tagName: "i"
			}
		}
	]
});
