---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Front-end
nav_order: 1
title: Webpack
---

This project comes with a fully configured webpack setup that includes:
* progress bar
* friendly error messages
* .env usage
* aliases for important directories
* [Babel]({{ "frontend/babel" | relative_url }}) support
* Vue SFC support
* [Sass/SCSS]({{ "frontend/css#sass" | relative_url }}) support
* [PostCSS]({{ "frontend/css#postcss" | relative_url }}) support
* ESLint support
* assets management loaders
* bundle compression
* favicons generation
* bundle manifest

Generated assets are published under `public_html/assets`:
* `public_html/assets/manifest.json` for the bundles manifest
* `public_html/assets/css/` for stylesheets
* `public_html/assets/fonts/` for fonts
* `public_html/assets/img/` for images
* `public_html/assets/js/` for scripts
