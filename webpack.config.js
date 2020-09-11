/* eslint-env node */



////////////////////////////////////////////////////////////////////////////////////////////////////
//// IMPORTS
////////////////////////////////////////////////////////////////////////////////////////////////////
const path = require("path");
const ManifestPlugin = require("webpack-manifest-plugin");
const CleanWebpackPlugin = require("clean-webpack-plugin");
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const WebpackProgessBar = require("webpack-progress-bar");
const FriendlyErrorsWebpackPlugin = require("friendly-errors-webpack-plugin");
const CompressionPlugin = require("compression-webpack-plugin");
const FaviconsWebpackPlugin = require("favicons-webpack-plugin");
// const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const envLoaded = require("dotenv").load();



////////////////////////////////////////////////////////////////////////////////////////////////////
//// BASE DEFINITIONS
////////////////////////////////////////////////////////////////////////////////////////////////////
if(envLoaded.error)
	throw new Error("failed to load .env file");

const mode = process.env.NODE_ENV;
const dev = (mode === "development");
const config = {
	resolve: {
		alias: {},
		extensions: [],
	},
	entry: {},
	output: {},
	module: { rules: [] },
	plugins: [],
	mode,
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

// alias["@vue"] = here("dev/vue/");
alias["@components"] = here("dev/vue/components/");
alias["@vplugins"] = here("dev/vue/plugins/");

alias["@css"] = here("dev/sass/");
alias["@img"] = here("dev/resources/img/");

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
output.path = here("public_html/assets/js/");
output.filename = dev ? "[name].bundle.js" : "[name].[chunkhash:8].bundle.js";
output.publicPath = "/assets/js/";



////////////////////////////////////////////////////////////////////////////////////////////////////
//// DEV TOOLS
////////////////////////////////////////////////////////////////////////////////////////////////////
config.stats = "minimal"; // compatibility w/ friendly errors plugin
config.devtool = dev ? "source-map" : false;



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
		/* {
			loader: MiniCssExtractPlugin.loader,
			options: {},
		}, */
		{
			loader: "css-loader",
			options: {
				sourceMap: true,
				url: false,
			},
		},
		"postcss-loader",
		{
			loader: "sass-loader",
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

plugins.push(new WebpackProgessBar());

plugins.push(new FriendlyErrorsWebpackPlugin({}));

plugins.push(new CompressionPlugin());

plugins.push(new VueLoaderPlugin());

plugins.push(new FaviconsWebpackPlugin({
	logo: here("dev/resources/favicon.png"),
	inject: false,
	outputPath: here("public_html/assets/img/favicons/"), //TODO: Output path
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


if(!dev){
	plugins.push(new CleanWebpackPlugin(["assets/js"], {
		root: here("public_html/"),
		verbose: true,
		dry: false,
		exclude: [
			"globals",
			"globals/*",
			"globals/*.*",
		],
	}));

	plugins.push(new ManifestPlugin());
}



////////////////////////////////////////////////////////////////////////////////////////////////////
//// EXPORT
////////////////////////////////////////////////////////////////////////////////////////////////////
module.exports = config;
