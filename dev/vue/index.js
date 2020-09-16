import { sync } from "vuex-router-sync";
import { Env } from "@js/utils";
import pluginsInstaller from "./plugins";
import Vue from "$vue";

Vue.config.productionTip = Env.dev || Env.test;
pluginsInstaller(Vue);

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
