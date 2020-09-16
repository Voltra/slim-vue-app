/**
 * Create a lazy loaded component wrapper
 * @param {string} path - The path to the SFC (relative to the components root)
 * @returns {function(): (Promise<*>|*)}
 */
const lazyc = path => () => import(`@components/${path}.vue`);

export { lazyc };
