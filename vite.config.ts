import { defineConfig } from 'vite'
import { svelte } from '@sveltejs/vite-plugin-svelte'

import alias from '@rollup/plugin-alias';
import path from 'path';

const production = process.env.NODE_ENV === 'production';

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        svelte(),
        alias({
            entries: {
                "$lib": path.resolve(__dirname, "src/lib"),
                "$routes": path.resolve(__dirname, "src/routes"),
                "$stores": path.resolve(__dirname, "src/stores"),
                "$scss": path.resolve(__dirname, "src/scss"),
            }
        })
    ]
})
