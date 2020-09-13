/* eslint-env node */



////////////////////////////////////////////////////////////////////////////////////////////////////
//// IMPORTS
////////////////////////////////////////////////////////////////////////////////////////////////////
const path = require("path");
const webpack = require("webpack");
const DotEnvPlugin = require("dotenv-webpack");
const ManifestPlugin = require("webpack-manifest-plugin");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const WebpackProgessBar = require("webpack-progress-bar");
const FriendlyErrorsWebpackPlugin = require("friendly-errors-webpack-plugin");
const CompressionPlugin = require("compression-webpack-plugin");
const FaviconsWebpackPlugin = require("favicons-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const dotenvExpand = require("dotenv-expand");
const envResult = require("dotenv-safe").config();



////////////////////////////////////////////////////////////////////////////////////////////////////
//// BASE DEFINITIONS
////////////////////////////////////////////////////////////////////////////////////////////////////
dotenvExpand(envResult);
if(envResult.error)
	throw new Error("Failed to load .env file");

const mode = process.env.NODE_ENV;
const dev = (mode === "development");

/**
 * @type {import("webpack").webpack.Configuration}
 */
const config = {
	mode,
	resolve: {
		alias: {},
		extensions: [],
	},
	entry: {},
	output: {},
	module: { rules: [] },
	plugins: [],
};

const here = src => path.resolve(__dirname, src);
const libraries = /(node_module|bower_component)s/gi;



////////////////////////////////////////////////////////////////////////////////////////////////////
//// TARGET
////////////////////////////////////////////////////////////////////////////////////////////////////
config.target = "web";



////////////////////////////////////////////////////////////////////////////////////////////////////
//// MODULE RESOLUTION
////////////////////////////////////////////////////////////////////////////////////////////////////
const { alias, extensions } = config.resolve;

alias["@"] = here("dev/");
alias["@js"] = here("dev/js/");
alias["@tests"] = here("dev/js/tests/");
alias["@e2e"] = here("dev/js/e2e/");
alias["@components"] = here("dev/vue/components/");
alias["@vplugins"] = here("dev/vue/plugins/");
alias["@css"] = here("dev/scss/");
alias["@scss"] = here("dev/scss/");
alias["@img"] = here("dev/resources/img/");

alias.$vue = "vue/dist/vue.esm";

extensions.push(
	".js",
	".vue",
	".scss",
	".css"
);



////////////////////////////////////////////////////////////////////////////////////////////////////
//// ENTRIES
////////////////////////////////////////////////////////////////////////////////////////////////////
config.entry.demo = "@js/mainDemo.js";



////////////////////////////////////////////////////////////////////////////////////////////////////
//// OUTPUTS
////////////////////////////////////////////////////////////////////////////////////////////////////
const { output } = config;
output.path = here("public_html/assets/");
output.filename = `js/[name].bundle.js`; // ${dev ? "" : "[chunkhash:8]."}
output.publicPath = "/assets/";


////////////////////////////////////////////////////////////////////////////////////////////////////
//// DEV TOOLS
////////////////////////////////////////////////////////////////////////////////////////////////////
config.stats = "minimal"; // compatibility w/ friendly errors plugin
config.devtool = dev ? "eval-cheap-module-source-map" : "source-map";



////////////////////////////////////////////////////////////////////////////////////////////////////
//// MODULES/LOADERS
////////////////////////////////////////////////////////////////////////////////////////////////////
const { rules } = config.module;
const jsRegex = /\.[jt]sx?$/i;

rules.push({
	enforce: "pre",
	test: jsRegex,
	exclude: libraries,
	loader: "eslint-loader",
	options: {
		fix: true,
		cache: true,
		quiet: true, // cf. https://webpack.js.org/loaders/eslint-loader/#quiet
		rulesdir: here("eslint-rules"),
	},
});

rules.push({
	test: jsRegex,
	exclude: libraries,
	use: ["babel-loader"],
});

rules.push({
	test: /\.(png|jpe?g|gif|svg)$/i,
	exclude: libraries,
	use: [
		{
			loader: "url-loader",
			options: {
				limit: 8192,
				name: "[name].[hash:8].[ext]",
			},
		},
		{
			loader: "img-loader",
			options: { enabled: !dev },
		},
	],
});

rules.push({
	test: /\.(woff2?|eot|ttf|otf)$/i,
	loader: "file-loader",
});

rules.push({
	test: /\.s[ac]ss$/i,
	use: [
		{
			loader: MiniCssExtractPlugin.loader,
			options: {},
		},
		{
			loader: "css-loader",
			options: {
				sourceMap: true,
				url: false,
			},
		},
		"postcss-loader",
		{
			loader: "scss-loader",
			options: { sourceMap: true },
		},
	],
});

rules.push({
	test: /\.vue$/i,
	loader: "vue-loader",
});



////////////////////////////////////////////////////////////////////////////////////////////////////
//// PLUGINS
////////////////////////////////////////////////////////////////////////////////////////////////////
const { plugins } = config;

plugins.push(new DotEnvPlugin({
	safe: true,
	expand: true,
	allowEmptyValues: false,
	systemvars: false,
}));

plugins.push(new webpack.DefinePlugin({"process.env": JSON.stringify(envResult.parsed)}));

plugins.push(new WebpackProgessBar());

plugins.push(new FriendlyErrorsWebpackPlugin({}));

plugins.push(new CompressionPlugin());

plugins.push(new VueLoaderPlugin());

plugins.push(new MiniCssExtractPlugin({
	filename: `css/[name].css`,
	chunkFilename: "css/[id].css",
}));

plugins.push(new FaviconsWebpackPlugin({
	logo: here("dev/resources/favicon.png"),
	inject: false,
	outputPath: "img/favicons/",
	mode: "webapp",
	devMode: "webapp",
	favicons: {
		appName: "[SlimVueApp] App name",
		appDescription: "[SlimVueApp] App description",
		background: "#e9ebee",
		// eslint-disable-next-line camelcase
		theme_color: "#3b5998",
		developerName: "Voltra",
		developerURL: "https://ludwigguerin.fr",

		icons: {
			favicons: [
				"favicon.ico",
				"favicon-32x32.png",
				"favicon-16x16.png",
			],
			appleIcon: ["apple-touch-icon.png"],
			//
			appleStartup: false,
			coast: false,
			android: false,
			windows: false,
			yandex: false,
			firefox: false,
		},
	},
}));

plugins.push(new CleanWebpackPlugin({
	verbose: true,
	dry: false,
	cleanOnceBeforeBuildPatterns: ["js/*"],
}));

plugins.push(new ManifestPlugin());



////////////////////////////////////////////////////////////////////////////////////////////////////
//// EXPORT
////////////////////////////////////////////////////////////////////////////////////////////////////
module.exports = config;
