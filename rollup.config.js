// main plugins
import svelte from 'rollup-plugin-svelte';
import commonjs from '@rollup/plugin-commonjs';
import resolve from '@rollup/plugin-node-resolve';
import livereload from 'rollup-plugin-livereload';
import { terser } from 'rollup-plugin-terser';
import path from 'path';
import sveltePreprocess from 'svelte-preprocess';

// path aliases
import alias from '@rollup/plugin-alias';

// typescript
import typescript from '@rollup/plugin-typescript';

// styles
import scss from 'rollup-plugin-scss';
import postcss from 'postcss';
import postcssrc from 'postcss-load-config';

// production flag (true = production)
const production = !process.env.ROLLUP_WATCH;

function serve() {
    let server;

    function toExit() {
        if (server) server.kill(0);
    }

    return {
        writeBundle() {
            if (server) return;
            server = require('child_process').spawn('npm', ['run', 'start', '--', '--dev'], {
                stdio: ['ignore', 'inherit', 'inherit'],
                shell: true
            });

            process.on('SIGTERM', toExit);
            process.on('exit', toExit);
        }
    };
}

export default {
    input: 'src/main.js',
    output: {
        sourcemap: true,
        format: 'iife',
        name: 'app',
        file: 'public/build/bundle.js'
    },
    plugins: [

        // svelte preprocessing (typescript, scss, etc)
        svelte({
            compilerOptions: {
                // enable run-time checks when not in production
                dev: !production
            },
            ...(production && { emitCss: false }),
            preprocess: sveltePreprocess({
                scss: {
                    includePaths: ['src/scss'],
                    processor: css => {
                        return postcss(postcssrc({ config: path.resolve(__dirname, 'postcss.config.js') }).plugins).process(css).css;
                    }
                },
                postcss: true,
            }),
        }),

        // aliases for paths
        alias({
            entries: {
                "$lib": path.resolve(__dirname, "src/lib"),
                "$routes": path.resolve(__dirname, "src/routes"),
                "$stores": path.resolve(__dirname, "src/stores"),
                "$scss": path.resolve(__dirname, "src/scss"),
            }
        }),

        // scss styles
        scss({
            processor: async () => {
                // compile the code with PostCSS by using the config at `postcss.config.js`
                const { plugins, options } = await postcssrc({
                    env: production ? 'production' : 'development',
                });
                return postcss(plugins);
            },
            output: 'public/build/bundle.css',
            outputStyle: production ? 'compressed' : null,
            include: ['/**/*.css', '/**/*.scss', '/**/*.sass'],
            sourceMap: true,
        }),

        // If you have external dependencies installed from
        // npm, you'll most likely need these plugins. In
        // some cases you'll need additional configuration -
        // consult the documentation for details:
        // https://github.com/rollup/plugins/tree/master/packages/commonjs
        resolve({
            browser: true,
            dedupe: ['svelte']
        }),
        commonjs(),

        //typescript support
        typescript(),

        // In dev mode, call `npm run start` once
        // the bundle has been generated
        !production && serve(),

        // Watch the `public` directory and refresh the
        // browser on changes when not in production
        !production && livereload('public'),

        // If we're building for production (npm run build
        // instead of npm run dev), minify
        production && terser()
    ],
    watch: {
        clearScreen: false
    }
};
