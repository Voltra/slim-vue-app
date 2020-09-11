/* eslint-env node */
//cf. https://eslint.org/docs/rules/
//cf. https://github.com/benmosher/eslint-plugin-import#rules
//cf. https://www.npmjs.com/package/eslint-plugin-rulesdir
const rulesDir = require("eslint-plugin-rulesdir");
rulesDir.RULES_DIR = "eslint-rules";


const minItems = 3;
const maxDepth = 4;
const maxNest = 3;
const maxParams = 4;
const tabWidth = 4;
const maxLineNr = 80;

module.exports = {
	parser: "babel-eslint",
	extends: "eslint:recommended",
	env: { browser: true },
	parserOptions: {
		ecmaVersion: 2020,
		sourceType: "module",
		ecmaFeatures: {
			jsx: true,
			impliedStrict: true, // act as if strict mode is enabled everywhere
		},
	},
	plugins: [ "rulesdir", "import" ],
	rules: {
		//// PLUGIN: import
		"import/named": "error",
		"import/namespace": "error",
		"import/default": "error",
		"import/no-dynamic-require": "off",
		"import/no-webpack-loader-syntax": "off",
		"import/no-self-import": "error",
		"import/no-cycle": "error",
		"import/no-useless-path-segments": "error",
		"import/export": "error",
		"import/no-named-as-default": "error",
		"import/no-named-as-default-member": "error",
		"import/first": "error",
		"import/no-duplicates": "error",
		"import/extensions": [
			"error", "never", {
				css: "always",
				scss: "always",
				svg: "always",
				png: "always",
				jpg: "always",
			},
		],
		"import/order": "error",
		"import/dynamic-import-chunkname": "off",


		//// POSSIBLE ERRORS
		"no-console": "off",
		"no-extra-parens": "off",
		"no-promise-executor-return": "error",
		"no-prototype-builtins": "off",
		// "no-template-curly-in-string": "off",
		"no-unreachable-loop": "error",
		"no-useless-backreference": "error",
		"require-atomic-updates": "error",



		//// BEST PRACTICES
		"array-callback-return": [
			"error", {
				checkForEach: false,
				allowImplicit: true,
			},
		],
		"block-scoped-var": "error",
		curly: ["error", "multi-or-nest"],
		"default-case": "error",
		"default-case-last": "error",
		"default-param-last": "error",
		"dot-location": ["error", "property"],
		"dot-notation": "error",
		eqeqeq: "error",
		"grouped-accessor-pairs": "error",
		"no-alert": "error",
		"no-caller": "off",
		"no-constructor-return": "error",
		"no-div-regex": "error",
		"no-eq-null": "error",
		"no-eval": "error",
		"no-extra-label": "error",
		"no-floating-decimal": "error",
		"no-implicit-coercion": "off",
		"no-implicit-globals": "error",
		"no-implied-eval": "error",
		"no-iterator": "error",
		"no-labels": "error",
		"no-lone-blocks": "error",
		"no-loop-func": "error",
		"no-magic-numbers": "warn",
		"no-multi-spaces": "error",
		"no-new": "error",
		"no-new-func": "error",
		"no-new-wrappers": "error",
		"no-octal-escape": "error",
		"no-param-reassign": "error", // negotiatable
		"no-proto": "error",
		"no-return-assign": "error",
		"no-return-await": "error",
		"no-script-url": "error",
		"no-self-compare": "error", // isNaN
		"no-sequences": "error",
		"no-throw-literal": "error",
		"no-unmodified-loop-condition": "error", // cannot be certain that it changes
		"no-useless-call": "error",
		"no-useless-concat": "error",
		"no-useless-return": "error",
		"no-void": "error",
		"prefer-promise-reject-errors": "off",
		"prefer-regex-literals": "warn",
		radix: "warn",
		"require-await": "off", // allow async lift
		"wrap-iife": "error",
		yoda: "warn",



		//// VARIABLES
		"init-declarations": "error",
		"no-label-var": "error",
		"no-shadow": [
			"warn", {
				builtinGlobals: true,
				hoist: "never",
			},
		],
		"no-unused-vars": "warn",
		"no-use-before-define": "warn",



		//// STYLISTIC ISSUES
		"array-bracket-newline": [
			"error", {
				minItems,
				multiline: true,
			},
		],
		"array-bracket-spacing": "off",
		"array-element-newline": "off",
		"block-spacing": ["error", "always"],
		"brace-style": [
			"error", "stroustrup", { allowSingleLine: false },
		],
		camelcase: [
			"error", {
				properties: "always",
				ignoreDestructuring: true,
				ignoreImports: true,
				ignoreGlobals: true,
			},
		],
		"capitalized-comments": "off",
		"comma-dangle": [
			"error", {
				arrays: "always-multiline",
				objects: "always-multiline",
				imports: "always-multiline",
				exports: "always-multiline",
				functions: "never",
			},
		],
		"comma-spacing": [
			"error", {
				before: false,
				after: true,
			},
		],
		"comma-style": ["error", "last"],
		"computed-property-spacing": ["error", "never"],
		"eol-last": ["error", "always"],
		"func-call-spacing": ["error", "never"],
		"func-name-matching": "off",
		"func-names": "off", // do not requier names for anonymous functions
		"func-style": "off", // might want to set to ["error", "expression"]
		"function-call-argument-newline": ["error", "consistent"],
		"function-paren-newline": ["error", { minItems }],
		"implicit-arrow-linebreak": ["error", "beside"],
		indent: ["error", "tab"],
		"jsx-quotes": ["error", "prefer-double"],
		"key-spacing": [
			"error", {
				beforeColon: false,
				afterColon: true,
				mode: "strict",
			},
		],
		"keyword-spacing": [
			"error", {
				before: false, // }else
				after: false, // else{, if()
				overrides: {
					return: { after: true },
					const: { after: true },
					let: { after: true },
					import: { after: true },
					export: { after: true },
					from: {
						before: true,
						after: true,
					},
				},
			},
		],
		"lines-between-class-members": ["error", "always"],
		"max-depth": ["error", maxDepth],
		"max-len": [
			"warn", {
				code: maxLineNr,
				tabWidth,
				ignoreComments: true,
			},
		],
		"max-nested-callbacks": ["error", maxNest],
		"max-params": ["warn", maxParams],
		"max-statements-per-line": ["error", { max: 1 }],
		"new-cap": "error", // class names start with a capital letter
		"new-parens": ["error", "always"], // use parenthesis even if constructor takes no arguments
		"newline-per-chained-call": ["error", { ignoreChainWithDepth: 2 }],
		"no-array-constructor": "warn",
		"no-lonely-if": "error", // restructure as else if
		"no-multi-assign": "warn", // const foo = bar = 42 doesn't make bar const
		"no-nested-ternary": "error",
		"no-new-object": "error",
		"no-trailing-spaces": "error",
		"no-unneeded-ternary": "error", // e.g. answer == 1 ? false : true
		"no-whitespace-before-property": "error", // e.g.  foo. bar.baz
		"nonblock-statement-body-position": ["error", "below"],
		"object-curly-newline": [
			"error", {
				minProperties: minItems,
				multiline: true,
			},
		],
		"object-curly-spacing": ["error", "always"], // always except {}
		"object-property-newline": ["error", { allowAllPropertiesOnSameLine: false }],
		"one-var": [
			"error", {
				var: "consecutive",
				let: "never",
				const: "never",
			},
		],
		"operator-assignment": ["error", "always"], // replace x=x+y by x+=y
		"operator-linebreak": "off",
		"padded-blocks": ["error", "never"],
		"prefer-exponentiation-operator": "warn",
		"prefer-object-spread": "warn",
		"quote-props": ["error", "as-needed"],
		quotes: [
			"error", "double", {
				avoidEscape: true,
				allowTemplateLiterals: true,
			},
		],
		semi: ["error", "always"], //TODO: Come back to this once there's an option to omit them for import/export statements
		"semi-spacing": [
			"error", {
				before: false,
				after: true,
			},
		],
		"semi-style": ["error", "last"],
		"space-before-blocks": ["error", "never"],
		"space-before-function-paren": ["error", "never"],
		"space-in-parens": ["error", "never"],
		"space-infix-ops": [
			// allows bar|0 for conversion to integer (instead of bar | 0)
			"error", { int32Hint: true },
		],
		"space-unary-ops": [
			"error", {
				words: true,
				nonwords: false,
				overrides: { "*": true }, // function* gen
			},
		],
		"template-tag-spacing": ["error", "never"],
		"unicode-bom": ["error", "never"],
		"wrap-regex": "off",



		//// ES6
		"arrow-parens": ["warn", "as-needed"],
		"generator-star-spacing": [
			"error", {
				before: false,
				after: true,
			},
		],
		"no-confusing-arrow": "error",
		"no-duplicate-imports": "error",
		"no-useless-computed-key": "error",
		"no-useless-constructor": "error",
		"no-useless-rename": "error",
		"no-var": "error",
		"object-shorthand": ["error", "always"],
		"prefer-const": "error",
		"prefer-destructuring": [
			"error", {
				array: true,
				object: true,
			}, { enforceForRenamedProperties: false },
		],
		"prefer-numeric-literals": "error",
		"prefer-rest-params": "error",
		"prefer-spread": "warn",
		"prefer-template": "error",
		"rest-spread-spacing": ["error", "never"],
		"symbol-description": "error",
		"template-curly-spacing": ["error", "never"],
		"yield-star-spacing": ["error", "after"],
	},
};
