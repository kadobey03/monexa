const mix = require('laravel-mix');
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Main application assets
mix.js('resources/js/app.js', 'public/js')
   .vue({ version: 3 })
   .sass('resources/sass/app.scss', 'public/css');

// Leads Management System no longer uses Vue.js - replaced with Alpine.js

// Admin management assets (if exists)
if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps();
    mix.options({
        hmrOptions: {
            host: 'localhost',
            port: 8080
        }
    });
}

// Additional configuration for production
mix.options({
    processCssUrls: false,
    postCss: [
        require('tailwindcss'),
        require('autoprefixer'),
    ]
});

// Copy additional assets
mix.copy('resources/images', 'public/images')
   .copy('resources/fonts', 'public/fonts');

// Notifications for build completion
if (!mix.inProduction()) {
    mix.disableNotifications();
}

// Browser sync for development
if (process.env.MIX_DEV_SERVER_URL) {
    mix.browserSync({
        proxy: process.env.MIX_DEV_SERVER_URL,
        files: [
            'resources/views/**/*.php',
            'resources/js/**/*.js',
            'resources/js/**/*.vue',
            'resources/css/**/*.css',
            'public/js/**/*.js',
            'public/css/**/*.css'
        ],
        watchOptions: {
            ignored: /node_modules/
        }
    });
}

// Webpack configuration override
mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            'components': path.resolve('resources/js/components'),
            'composables': path.resolve('resources/js/composables'),
            'assets': path.resolve('resources')
        }
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    compilerOptions: {
                        isCustomElement: tag => tag.startsWith('ion-')
                    }
                }
            }
        ]
    }
});