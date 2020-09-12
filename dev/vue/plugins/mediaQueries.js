import VueMq from "vue-mq";

/**
 * @param {import("vue").VueConstructor} Vue
 */
export default function mediaQueries(Vue){
	Vue.use(VueMq, {
		xsmall: 540, // up to 540 => xsmall
		small: 900, // from 540 up to 900 => small
		medium: 1280,
		large: 1440,
		xlarge: 1920,
		xxlarge: Infinity,
	});
}
