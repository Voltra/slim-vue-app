/**
 * @typedef {"development"|"production"|"test"} NodeEnv
 * @typedef {string|number|boolean|undefined} EnvVariable
 */


/**
 * Utility for environment variable checking
 * @type {{__: {cached: Record<string, EnvVariable>}, readonly prod: boolean, readonly dev: boolean, readonly test: boolean, get(string, EnvVariable=): EnvVariable, is(NodeEnv): boolean}}
 */
export const Env = {
	/**
	 * @private
	 */
	__: {
		/**
		 * @type {Record<string, EnvVariable>}
		 */
		cached: {},
	},

	/**
	 * Retrieve an environment variable
	 * @param {string} name - The environment variable's name
	 * @param {EnvVariable} defaultValue - The value to provide if it does not exist
	 * @returns {EnvVariable}
	 */
	get(name, defaultValue = undefined){
		if(name in this.__.cached)
			return this.__.cached[name];

		// eslint-disable-next-line no-undef
		const val = process.env?.[name] ?? defaultValue;

		if(typeof val === "string"){
			if(["true", "false"].includes(val))
				return val === "true";

			const asInt = parseInt(val, 10);
			if(isNaN(asInt)){
				this.__.cached[name] = val;
				return val;
			}

			const asFloat = parseFloat(val);
			const ret = asInt === asFloat ? asInt : asFloat;
			this.__.cached[name] = ret;
			return ret;
		}

		this.__.cached[name] = val;
		return val;
	},

	/**
	 * Determine whether or not the current mode is the provided one
	 * @param {NodeEnv} mode
	 * @returns {boolean}
	 */
	is(mode){
		return this.get("NODE_ENV") === mode;
	},

	/**
	 * Determine whether or not the current mode is development
	 * @returns {boolean}
	 */
	get dev(){
		return this.is("development");
	},

	/**
	 * Determine whether or not the current mode is production
	 * @returns {boolean}
	 */
	get prod(){
		return this.is("production");
	},

	/**
	 * Determine whether or not the current mode is test
	 * @returns {boolean}
	 */
	get test(){
		return this.is("test");
	},
};
