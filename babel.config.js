/*eslint-env node*/

/**
 * @type {import("@babel/core").TransformOptions}
 */
module.exports = {
	exclude: [
		/\bcore-js\b/i,
		/\bwebpack\b/,
		/\bregenerator-runtime\b/,
	],
	presets: [
		[
			"@babel/preset-env",
			/** @type {typeof import("@babel/preset-env")._default} */
			{
				useBuiltIns: "usage", // polyfills on use
				corejs: 3, // use core-js@3
				modules: "umd",
			},
		],
		[
			"@vue/babel-preset-jsx",
			{
				functional: true,
				injectH: true,
				vModel: true,
				vOn: true,
			},
		],
	],
	plugins: [
		"@babel/plugin-proposal-function-bind", // array.map(::this.myMethod)
		"@babel/plugin-proposal-class-properties", // class { myMember = 10; }
		"@babel/plugin-proposal-object-rest-spread", // {...myObj}
		"@babel/plugin-proposal-do-expressions", // const two = do{ if(false) 0; else 2; }
		"@babel/plugin-proposal-numeric-separator", // const twoK = 2_000;
		"@babel/plugin-proposal-nullish-coalescing-operator", // const stuff = null ?? "stuff";
		"@babel/plugin-proposal-optional-chaining", // window?.might?.have?.that?.property?.doStruff();
		"@babel/plugin-proposal-throw-expressions", // onError(() => throw new TypeError("OnO"));
		[
			"@babel/plugin-proposal-pipeline-operator", { // '1' |> parseFloat |> timesTwo |> plusFourty
				proposal: "fsharp",
			},
		],
		"@babel/plugin-proposal-partial-application", // doStuff(?, 42) is the new (x => doStuff(x, 42))
		"@babel/plugin-syntax-dynamic-import", // import("myComponent.vue").then(...)
		//
		"@babel/plugin-syntax-jsx",
		"babel-plugin-transform-jsx",
		"babel-plugin-jsx-v-model",
	],
};
