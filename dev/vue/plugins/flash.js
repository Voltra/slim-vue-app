import { flash } from "vanilla_flash";

/**
 * @param {import("vue").VueConstructor} Vue
 */
export default function vanillaFlash(Vue){
	Object.defineProperties(Vue.prototype, {
		$flash: {
			get(){
				return flash;
			},
		},
	});
}
