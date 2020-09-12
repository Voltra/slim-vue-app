import vueRouter from "./vue-router";
import vuex from "./vuex";
import indexedDb from "./indexedDB";
import flash from "./flash";
import json from "./json";
import ls from "./localStorage";
import mediaQueries from "./mediaQueries";

/**
 * Installer function for the Vue plugins
 * @param {Vue | VueConstructor} Vue
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
		mediaQueries,
	];

	factories.forEach(factory => factory(Vue));
}
