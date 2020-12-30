---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Front-end
nav_order: 3
title: CSS
---

The styles are compiled as follow:
1. Sass/SCSS pre-processing
2. PostCSS pre-processing
3. Extraction

Styles are extracted on a per entry basis.

## Sass
SCSS files are located in `dev/scss/` and have a predefined structure:
* `components` for Vue SFC stylesheets
* `libraries` for library imports and customization
* `mixins` for reusable mixins and functions

Note that it is designed to use SCSS modules.

### Hamburger

> @scss/libraries/hamburger

The [hamburgers](https://www.npmjs.com/package/hamburgers) library customized to be easy to use and embed.
By default, it only loads the emphatic hamburger. It exposes the following libraries:
* `hamburger.$height` the height of the entire hamburger component
* `hamburger.$width` the width of the entire hamburger component
* `hamburger.$padding` the padding used in the hamburger component

### Breakpoints

> @scss/libraries/mq

A small wrapper around [sass-mq](https://www.npmjs.com/package/sass-mq) to write media query dependent styles easiliy:
```scss
$mq-breakpoints: (
	xsmall: 540,
	small: 900,
	medium: 1280,
	large: 1440,
	xlarge: 1920
	// xxlarge: Infinity
);


.myStyle{
	@include breakpoint(large){ // for large and above
		// some other styles
	}
}
```

The aim is to write mobile first code without many complications.

### Browser
> @scss/mixins/browser
> @scss/mixins

Write browser/vendor specific code with no hassle:
```scss
.myStuff{
	@include browser(ie, "firefox.ios"){
		// styles for oth IE and Firefox on iOS
	}
}
```

### Margins
> @scss/mixins/margin or @scss/mixins

Margin mixins for all directions and combinations (including a center horizontally by margin).
```scss
@include centerMargin; // auto for margin-left and margin-right
@include marginTRB(1rem); // 1rem for Top Right Bottom margins
```

### Paddings
> @scss/mixins/padding or @scss/mixins

Padding mixins for all direction and combinations.
```scss
@include verticalPadding(1rem); // 1rem for Top and Bottom margins
```

### Border radius
> @scss/mixins/radius or @scss/mixins

Border radius for all combinations.
```scss
@include noRadius;
@include radiusDiagBL(100%); // 100% for top-right and bottom-left corners
@include radiusAllButBL(1rem); // 1rem for all but bottom-left corner
// etc...
```

## PostCSS

A very simple and concise setup that allows to:
* automatically prefix browser specific code
* group media queries
* minify

Thus the plugins used are:
* [autoprefixer](https://www.npmjs.com/package/autoprefixer)
* [cssnano](https://www.npmjs.com/package/cssnano)
* [css-mquery-packer](https://www.npmjs.com/package/css-mquery-packer)
* [postcss-preset-env](https://www.npmjs.com/package/postcss-preset-env)
