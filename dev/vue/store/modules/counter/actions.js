import { make } from "vuex-pathify";
import state from "./state";

/**
 * @type {import("vuex").ActionTree}
 */
export default{
	...make.actions(state),

	/**
	 * @property {import("vuex").Action} loadCount
	 */
	loadCount({ commit }){
		fetch("https://google.fr")
			.then(() => commit("setCount", 200))
			.catch(() => commit("setCount", -1));
	},
};
