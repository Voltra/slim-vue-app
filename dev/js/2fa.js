import { newVueInstance } from "@/vue";
import router from "@/vue/router";
import store from "@/vue/store";
import { browserDetectorOf } from "@js/utils/BrowserDetector";
import QrCode from "@components/QrCode";

(() => {
	console.log(
		"%c VOLTRA ",
		`background: #0087b3;
		color: white;
		font-size: 17px;
		font-weight: bold;
		line-height: 36px;
		text-align: center;
		border-radius: 50vw;`,
		"www.ludwigguerin.fr"
	);

	const browserDetector = browserDetectorOf(window).bootstrapClasses();

	const vm = newVueInstance({
		el: "#app",
		router,
		store,
		components: { QrCode },
	});
})();
