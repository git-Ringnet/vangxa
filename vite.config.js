import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import mkcert from 'vite-plugin-mkcert';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/main.css',
                'resources/css/leaderboard/leaderboard.css',
                'resources/js/app.js',
                'resources/js/activity-tracker.js'
            ],
            refresh: [`resources/views/**/*`],
        }),
        tailwindcss(),
        // mkcert(),
    ],
   	server: {
  https: true,
  cors: true,
  host: '0.0.0.0',
  port: 5173,
  hrm:{
  	host:'localhost'
  }
},
});
