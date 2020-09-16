/**
 * Make a module from its definition
 * @param {import("vuex").Module} options - The options for the module
 * @returns {import("vuex").Module}
 */
const makeModule = options => ({
	...options,
	namespaced: true,
});

export { makeModule };
