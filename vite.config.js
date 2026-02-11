import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { path  } from 'path';

export default defineConfig({
	plugins: [
		laravel({
			input: [
				'resources/scss/app.scss',
				'resources/css/app.css',
				'resources/js/app.js'
			],
			refresh: true,
		}),
	],
	build: {
		chunkSizeWarningLimit: 4000,
    sourcemap: true,        // full source map
    // sourcemap: 'inline', // embed in JS file
    // sourcemap: 'hidden', // generate but don't expose in devtools
	},
});
