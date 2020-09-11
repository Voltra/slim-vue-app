
import Vuex from "vuex";
import pathify from "vuex-pathify";
import counter from "./modules/counter";

/**
 * @type {import("vuex").StoreOptions}
 */
const store = { modules: { counter } };

export default new Vuex({
	...store,
	plugins: [pathify.plugin],
});
