/*
=========================================================
* Volt Pro - Premium Bootstrap 5 Dashboard
=========================================================
* Product Page: https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard
* Copyright 2021 Themesberg (https://www.themesberg.com)
* Designed and coded by https://themesberg.com
=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. Please contact us to request a removal. Contact us if you want to remove it.
*/

"use strict";
const d = document;
d.addEventListener("DOMContentLoaded", function () {
	let themeSettingsEl = document.getElementById("theme-settings"),
		themeSettingsExpandEl = document.getElementById("theme-settings-expand");
	if (themeSettingsEl) {
		let themeSettingsCollapse = new bootstrap.Collapse(themeSettingsEl, {
			show: true,
			toggle: false,
		});
		if (window.localStorage.getItem("settings_expanded") === "true") {
			themeSettingsCollapse.show();
			themeSettingsExpandEl.classList.remove("show");
		} else {
			themeSettingsCollapse.hide();
			themeSettingsExpandEl.classList.add("show");
		}
		themeSettingsEl.addEventListener("hidden.bs.collapse", function () {
			themeSettingsExpandEl.classList.add("show");
			window.localStorage.setItem("settings_expanded", false);
		});
		themeSettingsExpandEl.addEventListener("click", function () {
			themeSettingsExpandEl.classList.remove("show");
			window.localStorage.setItem("settings_expanded", true);
			setTimeout(function () {
				themeSettingsCollapse.show();
			}, 300);
		});
	}

	// options
	const breakpoints = { sm: 540, md: 720, lg: 960, xl: 1140 };
	let sidebar = document.getElementById("sidebarMenu");
	if (sidebar && d.body.clientWidth < breakpoints.lg) {
		sidebar.addEventListener("shown.bs.collapse", function () {
			document.querySelector("body").style.position = "fixed";
		});
		sidebar.addEventListener("hidden.bs.collapse", function () {
			document.querySelector("body").style.position = "relative";
		});
	}
	let iconNotifications = d.querySelector(".notification-bell");
	if (iconNotifications) {
		iconNotifications.addEventListener("shown.bs.dropdown", function () {
			iconNotifications.classList.remove("unread");
		});
	}
	[].slice.call(d.querySelectorAll("[data-background]")).map(function (el) {
		el.style.background = "url(" + el.getAttribute("data-background") + ")";
	});
	[].slice.call(d.querySelectorAll("[data-background-lg]")).map(function (el) {
		if (document.body.clientWidth > breakpoints.lg) {
			el.style.background =
				"url(" + el.getAttribute("data-background-lg") + ")";
		}
	});
	[].slice
		.call(d.querySelectorAll("[data-background-color]"))
		.map(function (el) {
			el.style.background =
				"url(" + el.getAttribute("data-background-color") + ")";
		});
	[].slice.call(d.querySelectorAll("[data-color]")).map(function (el) {
		el.style.color = "url(" + el.getAttribute("data-color") + ")";
	});

	//Tooltips
	let tooltipTriggerList = [].slice.call(
		document.querySelectorAll('[data-bs-toggle="tooltip"]')
	);
	tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl);
	});

	// Popovers
	let popoverTriggerList = [].slice.call(
		document.querySelectorAll('[data-bs-toggle="popover"]')
	);
	popoverTriggerList.map(function (popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl);
	});

	// Datepicker
	let datepickers = [].slice.call(d.querySelectorAll("[data-datepicker]"));
	datepickers.map(function (el) {
		return new Datepicker(el, { buttonClass: "btn" });
	});

	if (d.querySelector(".input-slider-container")) {
		[].slice
			.call(d.querySelectorAll(".input-slider-container"))
			.map(function (el) {
				let slider = el.querySelector(":scope .input-slider"),
					sliderId = slider.getAttribute("id"),
					minValue = slider.getAttribute("data-range-value-min"),
					maxValue = slider.getAttribute("data-range-value-max"),
					sliderValue = el.querySelector(":scope .range-slider-value"),
					startValue = sliderValue.getAttribute("data-range-value-low"),
					c = d.getElementById(sliderId);
				noUiSlider.create(c, {
					start: [parseInt(startValue)],
					connect: [true, false],
					//step: 1000,
					range: { min: [parseInt(minValue)], max: [parseInt(maxValue)] },
				});
			});
	}

	if (d.getElementById("input-slider-range")) {
		let c = d.getElementById("input-slider-range"),
			low = d.getElementById("input-slider-range-value-low"),
			e = d.getElementById("input-slider-range-value-high"),
			f = [d, e];

		noUiSlider.create(c, {
			start: [
				parseInt(low.getAttribute("data-range-value-low")),
				parseInt(e.getAttribute("data-range-value-high")),
			],
			connect: !0,
			tooltips: true,
			range: {
				min: parseInt(c.getAttribute("data-range-value-min")),
				max: parseInt(c.getAttribute("data-range-value-max")),
			},
		});
		c.noUiSlider.on("update", function (a, b) {
			f[b].textContent = a[b];
		});
	}

	if (d.getElementById("loadOnClick")) {
		d.getElementById("loadOnClick").addEventListener("click", function () {
			let button = this,
				loadContent = d.getElementById("extraContent"),
				allLoaded = d.getElementById("allLoadedText");
			button.classList.add("btn-loading");
			button.setAttribute("disabled", "true");
			setTimeout(function () {
				loadContent.style.display = "block";
				button.style.display = "none";
				allLoaded.style.display = "block";
			}, 1500);
		});
	}
	new SmoothScroll('a[href*="#"]', {
		speed: 500,
		speedAsDuration: true,
	});
	if (d.querySelector(".current-year"))
		d.querySelector(".current-year").textContent = new Date().getFullYear();

	// Glide JS
	if (d.querySelector(".glide")) {
		new Glide(".glide", {
			type: "carousel",
			startAt: 0,
			perView: 3,
		}).mount();
	}
	if (d.querySelector(".glide-testimonials")) {
		new Glide(".glide-testimonials", {
			type: "carousel",
			startAt: 0,
			perView: 1,
			autoplay: 2000,
		}).mount();
	}
	if (d.querySelector(".glide-clients")) {
		new Glide(".glide-clients", {
			type: "carousel",
			startAt: 0,
			perView: 5,
			autoplay: 2000,
		}).mount();
	}
	if (d.querySelector(".glide-news-widget")) {
		new Glide(".glide-news-widget", {
			type: "carousel",
			startAt: 0,
			perView: 1,
			autoplay: 2000,
		}).mount();
	}
	if (d.querySelector(".glide-autoplay")) {
		new Glide(".glide-autoplay", {
			type: "carousel",
			startAt: 0,
			perView: 3,
			autoplay: 2000,
		}).mount();
	}
});
