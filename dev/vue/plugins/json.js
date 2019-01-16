import { $json } from "@voltra/json"

const plugin = {
	install(Vue){
		Object.defineProperties(Vue.prototype, {
			"$json": {
				get() { return $json; }
			}
		})
	}
};

if(typeof window != "undefined" && window.Vue)
	Vue.use(plugin);

export default plugin;