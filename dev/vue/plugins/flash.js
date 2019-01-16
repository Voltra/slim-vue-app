import { flash } from "vanilla_flash"

const plugin = {
	install(Vue){
		Object.defineProperties(Vue.prototype, {
			"$flash": {
				get(){ return flash; }
			}
		})
	}
};

if(typeof window != "undefined" && window.Vue)
	Vue.use(plugin);


export default plugin