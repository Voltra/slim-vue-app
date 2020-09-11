import vueRouter from "./vue-router";
import vuex from "./vuex";
import indexedDb from "./indexedDB";
import flash from "./flash";
import json from "./json";
import ls from "./localStorage";

/**
 * Installer function for the Vue plugins
 * @param {import("vue").VueConstructor} Vue
 */
export default function pluginsInstaller(Vue){
	/// PLUGINS
	const factories = [
		vueRouter,
		vuex,
		indexedDb,
		flash,
		json,
		ls,
	];

	factories.forEach(factory => factory(Vue));
}
