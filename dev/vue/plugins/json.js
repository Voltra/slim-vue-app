import { $json } from "@voltra/json";

/**
 * @param {import("vue").VueConstructor} Vue
 */
export default function json(Vue){
	Object.defineProperties(Vue.prototype, {
		$json: {
			get(){
				return $json;
			},
		},
	});
}
