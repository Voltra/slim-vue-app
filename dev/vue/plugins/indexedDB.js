import db from "db.js";

/**
 * @var {DbJs.OpenOptions} config - The database connection options
 */
const config = {
	server: "MyDB",
	version: 1,
	schema: {
		people: {
			key: {
				keyPath: "id",
				autoIncrement: true,
			},
			indexes: {
				firstName: {},
				answer: { unique: true },
			},
		},
	},
};

/**
 * Factory installer for the indexed DB client
 * @param {import("vue").VueConstructor} Vue
 */
export default async function indexedDb(Vue){
	const $connection = await db.open(config);

	const plugin = {
		install(/* Vue */){
			Object.defineProperties(Vue.prototype, {
				$db: {
					get(){
						return $connection;
					},
				},
			});
		},
	};

	Vue.use(plugin);
}
