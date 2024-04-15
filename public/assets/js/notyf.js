const notif = new Notyf({
	duration: 5000,
	position: {
    x: 'right',
    y: 'top'
  }, types: [
		{
			type: "warning",
			background: "orange",
			duration: 10000,
			icon: {
				className: "fas fa-triangle-exclamation",
				tagName: "span",
				text: ""
			}
		}, {
			type: "info",
			background: "blue",
			icon: {
				className: "fas fa-circle-info",
				tagName: "span",
				text: ""
			}
		}
	]
});
