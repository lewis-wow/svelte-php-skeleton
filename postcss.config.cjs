const postcssCustomMedia = require('postcss-custom-media');
const autoprefixer = require('autoprefixer');
const purgecss = require('@fullhuman/postcss-purgecss');
const postcssNested = require('postcss-nested');

module.exports = ({ env }) => {
    // production flag (true = production)
    const production = env === "production";

    return {
        plugins: [
            // custom media props
            postcssCustomMedia({
                importFrom: 'src/scss/breakpoints.css',
            }),

            // nested css
            postcssNested(),

            // autoprefixer
            production && autoprefixer(),

            // purge unused css
            production && purgecss({
                content: ['./dist/*.html', '.src/**/*.{svelte|html|js}'],
                //css: ['public/build/bundle.css'],
                whitelistPatterns: [/svelte-/],
                defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
            }),
        ]
    };
};
