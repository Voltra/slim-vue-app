import Vue from "vue";
import { sync } from "vuex-router-sync";
import pluginsInstaller from "./plugins";


pluginsInstaller(Vue);

/**
 *
 * @param {import("vue").ThisTypedComponent} options
 */
const newVueInstance = options => {
	const unsyncRouterStore = sync(
		options.store, options.router, { moduleName: "router" }
	);

	const vm = new Vue(options);

	return {
		vm,
		unsyncRouterStore,
	};
};

export {
	Vue,
	newVueInstance,
};
