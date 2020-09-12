import { newVueInstance } from "@/vue";
import router from "@/vue/router";
import store from "@/vue/store";
import Demo from "@components/Demo";
import { browserDetectorOf } from "@js/utils/BrowserDetector";

(() => {
	const browserDetector = browserDetectorOf(window).bootstrapClasses();

	const vm = newVueInstance({
		el: "#app",
		router,
		store,
		components: { Demo },
	});
})();
