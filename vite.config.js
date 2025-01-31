import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { path  } from 'path';


export default defineConfig({
	plugins: [
		laravel({
			input: [
				'resources/css/app.css',
				'resources/scss/app.scss',
				'resources/js/app.js'
			],
			refresh: true,
		}),
	],
//	resolve: {
//		alias: {
//			'jquery-ui': 'jquery-ui/dist/jquery-ui.js'
//		}
//	},
	build: {
			chunkSizeWarningLimit: 1600,
		},
});
