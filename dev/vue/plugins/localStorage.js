import $ls from "store";

/**
 * @param {import("vue").VueConstructor} Vue
 */
export default function localStorage(Vue){
	Object.defineProperties(Vue.prototype, {
		$localStorage: {
			get(){
				return $ls;
			},
		},
		$ls: {
			get(){
				return $ls;
			},
		},
	});
}
