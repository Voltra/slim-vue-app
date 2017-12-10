const path = require("path");
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const ManifestPlugin = require("webpack-manifest-plugin");
const CleanWebpackPlugin = require("clean-webpack-plugin");


const dev = (process.env["NODE_ENV"] === "dev");

const config = {};
const thisPath = __dirname;

config.target = "web";

config.resolve = {};
config.resolve.alias = {
	"@js": path.resolve(thisPath, "dev/js/"),
	"@css": path.resolve(thisPath, "dev/css/"),
	"@img": path.resolve(thisPath, "dev/resources/img/"),
	"$es-vue": "vue/dist/vue.esm.js",
	"$vue": "vue/dist/vue.min.js"
};
config.resolve.extensions = [
	".js",
	".es6",
	".vue"
];

config.entry = {};


config.output = {
	path: path.resolve(thisPath, "public_html/assets/js"),
	filename: dev ? "[name].bundle.js" : "[name].[chunkhash:8].bundle.js",
	publicPath: "/assets/js/"
};

config.devtool = dev ? "cheap-module-eval-source-map" : false;

config.modules = {};
config.modules.rules = [];
config.modules.rules.push({
	test: /\.(js|es6)$/,
	exclude: /(node_modules|bower_components)/g,
	use: [
		"babel-loader"
	]
});
config.modules.rules.push({
	test: /\.(png|jpe?g|gif|svg)$/,
	use: [
		{
			loader: "url-loader",
			options: {
				limit: 8192,
				name: "[name].[hash:8].[ext]"
			}
		},
		{
			loader: "img-loader",
			options: {
				enabled: !dev
			}
		}
	]
});
config.modules.rules.push({
	test: /\.(woff2?|eot|ttf|otf)$/,
	loader: "file-loader"
});

config.plugins = [];
if(!dev){
	config.plugins.push(new UglifyJsPlugin({
		sourceMap: false
	}));
	config.plugins.push(new ManifestPlugin());
	config.plugins.push(new CleanWebpackPlugin(["assets/js"], {
		root: path.resolve(thisPath, "./"),
		verbose: true,
		dry: false
	}));
}


module.export = config;
