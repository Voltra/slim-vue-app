import Vue from "vue"
import Demo from "@components/Demo"

(() => {
	document.addEventListener("DOMContentLoaded", () => {
		new Vue({
			el: "#app",
			components: [Demo]
		});
	});
})();
