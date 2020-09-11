/*eslint-env node*/

module.exports = ({ file, env }) => ({
	plugins: {
		// "postcss-cssnext": {}, // Replaced by postcss-preset-env
		autoprefixer: { remove: false }, //keep legacy prefixes
		cssnano: env === "production" ? {} : false,
		"css-mquery-packer": {}, // Group media queries
		"postcss-preset-env": {},
	},
});
