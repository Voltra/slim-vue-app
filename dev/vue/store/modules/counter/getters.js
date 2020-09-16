import { make } from "vuex-pathify";
import state from "./state";

/**
 * @type {import("vuex").GetterTree}
 */
export default{
	...make.getters(state),
	/**
	 * @property {import("vuex").Getter} next
	 * @param {typeof state} state - The current state
	 */
	next(state){
		return state.count;
	},
};
