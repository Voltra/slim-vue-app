import db from "db.js"

export default function(Vue, config){
	return db.open(config).then($connection => {
		//console.log(db);
		const plugin = {
			install(Vue){
				Object.defineProperties(Vue.prototype, {
					$db: {
						get(){ return $connection; }
					}
				});
			}
		};

		Vue.use(plugin);
	});
}