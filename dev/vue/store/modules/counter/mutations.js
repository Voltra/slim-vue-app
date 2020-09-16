import { make } from "vuex-pathify";
import state from "./state";

/**
 * @type {import("vuex").MutationTree}
 */
export default{
	...make.mutations(state),

	/**
	 * @property {import("vuex").Mutation} INCREMENT
	 * @param {typeof state} state - The current state
	 */
	INCREMENT(state){
		state.count += 1;
	},

	/**
	 * @property {import("vuex").Mutation} DECREMENT
	 * @param {typeof state} state - The current state
	 */
	DECREMENT(state){
		state.count -= 1;
	},

	/**
	 * @property {import("vuex").Mutation} RESET
	 * @param {typeof state} state - The current state
	 */
	RESET(state){
		state.count = state.defaultCount;
	},
};
