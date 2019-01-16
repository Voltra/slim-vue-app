import $ls from "$localStorage"

const plugin = {
	install(Vue){
		Object.defineProperties(Vue.prototype, {
			$localStorage: {
				get(){ return $ls; }
			},
			$ls: {
				get(){ return $ls; }
			}
		});
	}
};

if(typeof window !== "undefined" && window.Vue)
	Vue.use(plugin);

export default plugin