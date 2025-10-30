import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';
import { visualizer } from 'rollup-plugin-visualizer';
import viteCompression from 'vite-plugin-compression';

export default defineConfig(({ command, mode }) => {
    // Load env file based on `mode` in the current working directory.
    const env = loadEnv(mode, process.cwd(), '');
    const isProduction = mode === 'production';
    const isDevelopment = mode === 'development';

    return {
        // Modern build target for better performance
        build: {
            target: 'es2020',
            cssTarget: 'chrome80',
            
            // Optimize build performance
            minify: 'esbuild',
            sourcemap: isProduction ? 'hidden' : 'inline',
            
            // Enable CSS code splitting
            cssCodeSplit: true,
            
            // Advanced chunk optimization
            rollupOptions: {
                output: {
                    // More sophisticated chunk splitting
                    manualChunks: (id) => {
                        // Node modules vendor chunks
                        if (id.includes('node_modules')) {
                            // Vue ecosystem
                            if (id.includes('vue') || id.includes('@vueuse')) {
                                return 'vue-vendor';
                            }
                            // UI libraries
                            if (id.includes('@headlessui') || id.includes('@heroicons')) {
                                return 'vue-ui';
                            }
                            // Utility libraries
                            if (id.includes('axios') || id.includes('lodash') || id.includes('date-fns')) {
                                return 'utils';
                            }
                            // State management
                            if (id.includes('pinia')) {
                                return 'store';
                            }
                            // Small vendor chunks for better caching
                            return 'vendor';
                        }
                        
                        // Application chunks for better code splitting
                        if (id.includes('resources/js/components')) {
                            return 'components';
                        }
                        if (id.includes('resources/js/composables')) {
                            return 'composables';
                        }
                        if (id.includes('resources/js/utils')) {
                            return 'app-utils';
                        }
                    },
                    
                    // Better file naming for caching
                    chunkFileNames: 'js/[name]-[hash].js',
                    entryFileNames: 'js/[name]-[hash].js',
                    assetFileNames: ({ name }) => {
                        if (/\.(gif|jpe?g|png|svg)$/.test(name ?? '')) {
                            return 'images/[name]-[hash][extname]';
                        }
                        if (/\.css$/.test(name ?? '')) {
                            return 'css/[name]-[hash][extname]';
                        }
                        return 'assets/[name]-[hash][extname]';
                    }
                },
                
                // External dependencies (if needed)
                external: [],
                
                // Rollup plugins for additional optimizations
                plugins: []
            },
            
            // Enhanced asset handling optimization
            assetsInlineLimit: 4096, // 4KB threshold for inlining
            chunkSizeWarningLimit: 1000, // 1MB warning threshold
            
            // Enhanced reporting for production
            reportCompressedSize: isProduction,
            emptyOutDir: true,
            
            // Enhanced CSS optimization
            cssMinify: isProduction ? 'esbuild' : false,
            
            // Enhanced tree shaking for Vanilla JS + Vue hybrid
            treeshake: {
                preset: 'recommended',
                manualPureFunctions: [
                    'console.log', 'console.info', 'console.debug',
                    'console.warn', 'console.trace'
                ],
                // Better support for Vue components and Vanilla JS modules
                moduleSideEffects: (id, external) => {
                    // Keep side effects for Vue components and CSS
                    return id.includes('.vue') || id.includes('.css') || id.includes('.scss');
                },
            },
            
            // Enhanced module preload for hybrid architecture
            modulePreload: {
                polyfill: true,
                resolveDependencies: (url, deps, context) => {
                    // Intelligent preloading strategy
                    if (context.hostType === 'html') {
                        return deps; // Preload all deps for HTML entry
                    }
                    // For JS modules, filter based on usage patterns
                    return deps.filter(dep => {
                        // Always preload critical utilities
                        if (dep.includes('axios') || dep.includes('lodash')) return true;
                        // Conditionally preload Vue deps based on context
                        if (dep.includes('vue')) return url.includes('admin') || url.includes('leads');
                        return true;
                    });
                },
            },
            
            // Enhanced build output optimization
            write: true,
            watch: isDevelopment ? {} : null,
        },

        // Enhanced esbuild optimizations for Vanilla JS
        esbuild: {
            target: 'es2020',
            legalComments: 'none',
            // Remove console and debugger in production
            drop: isProduction ? ['console', 'debugger'] : [],
            // Better tree shaking for vanilla JS
            treeShaking: true,
            // Optimize for modern browsers
            format: 'esm',
            // Enable advanced optimizations
            minifyIdentifiers: isProduction,
            minifySyntax: isProduction,
            minifyWhitespace: isProduction,
        },

        // Advanced plugins configuration
        plugins: [
            laravel({
                input: [
                    // Main application entry points
                    'resources/css/app.css',
                    'resources/js/app.js',
                    
                    // Admin-specific entry points for better code splitting
                    'resources/js/admin-management.js',
                    'resources/js/modules/admin-management.js',
                    
                    // Vue.js application entry points
                    'resources/js/admin/leads/vue/LeadAssignmentApp.js',
                    
                    // Additional CSS entry points for better organization
                    'resources/css/admin/leads-table.css',
                ],
                refresh: [
                    'resources/views/**/*.blade.php',
                    'resources/js/**/*.js',
                    'resources/css/**/*.css',
                ],
                
                // Enhanced build configuration
                buildDirectory: 'build',
                hotFile: 'public/hot',
                
                // Multiple entry points with conditional loading
                detectTls: env.APP_URL?.startsWith('https://'),
            }),
            
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                    // Enhanced template optimization
                    compilerOptions: {
                        isCustomElement: (tag) => tag.startsWith('tw-'),
                        // Production optimizations
                        hoistStatic: isProduction,
                        cacheHandlers: isProduction,
                    },
                },
                
                // Enhanced Vue optimization options for Vue 3.3+
                script: {
                    defineModel: true,
                    propsDestructure: true,
                },
                
                // Enhanced compilation options for admin leads system
                include: [/\.vue$/, /\.md$/],
                
                // Custom blocks support
                customElement: true,
            }),

            // Bundle analyzer - sadece production build'de
            ...(isProduction ? [
                visualizer({
                    filename: 'public/build/stats.html',
                    open: false,
                    gzipSize: true,
                    brotliSize: true,
                    template: 'treemap',
                }),
            ] : []),

            // Compression plugin - sadece production'da
            ...(isProduction ? [
                viteCompression({
                    algorithm: 'gzip',
                    ext: '.gz',
                    threshold: 1024, // 1KB üzerindeki dosyaları sıkıştır
                    deleteOriginFile: false,
                    verbose: false,
                }),
                viteCompression({
                    algorithm: 'brotliCompress',
                    ext: '.br',
                    threshold: 1024,
                    deleteOriginFile: false,
                    verbose: false,
                }),
            ] : []),
        ],

        // Enhanced resolve configuration
        resolve: {
            alias: {
                '@': resolve(__dirname, 'resources/js'),
                'components': resolve(__dirname, 'resources/js/components'),
                'composables': resolve(__dirname, 'resources/js/composables'),
                'stores': resolve(__dirname, 'resources/js/stores'),
                'utils': resolve(__dirname, 'resources/js/utils'),
                'assets': resolve(__dirname, 'resources'),
                'images': resolve(__dirname, 'resources/images'),
                'styles': resolve(__dirname, 'resources/css'),
            },
            
            // Speed up resolving - prioritize vanilla JS extensions
            extensions: ['.js', '.mjs', '.ts', '.jsx', '.tsx', '.json', '.vue'],
            
            // Optimize module resolution
            mainFields: ['browser', 'module', 'main'],
            conditions: ['import', 'module', 'browser', 'default'],
        },

        // Enhanced development server for Vanilla JS + Vue hybrid
        server: {
            host: '0.0.0.0',
            port: 5173,
            strictPort: true,
            
            // Enhanced HMR configuration with faster rebuild
            hmr: {
                host: 'localhost',
                port: 5173,
                overlay: {
                    warnings: false,
                    errors: true,
                },
                // Optimize HMR for both Vanilla JS and Vue
                clientPort: 5173,
            },
            
            // Enhanced CORS configuration for Laravel
            cors: {
                origin: [
                    'http://localhost:8000',
                    'http://127.0.0.1:8000',
                    'http://localhost:3000',  // For frontend dev
                    env.APP_URL || 'http://localhost:8000'
                ],
                credentials: true,
                methods: ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],
                allowedHeaders: ['Content-Type', 'Authorization', 'X-Requested-With'],
            },
            
            // Enhanced development proxy
            proxy: {
                '/api': {
                    target: env.APP_URL || 'http://localhost:8000',
                    changeOrigin: true,
                    secure: false,
                    configure: (proxy, options) => {
                        proxy.on('error', (err, req, res) => {
                            console.log('proxy error', err);
                        });
                        proxy.on('proxyReq', (proxyReq, req, res) => {
                            console.log('Sending Request to the Target:', req.method, req.url);
                        });
                        proxy.on('proxyRes', (proxyRes, req, res) => {
                            console.log('Received Response from the Target:', proxyRes.statusCode, req.url);
                        });
                    },
                },
                // Additional Laravel routes proxy
                '/admin': {
                    target: env.APP_URL || 'http://localhost:8000',
                    changeOrigin: true,
                    secure: false,
                },
                '/storage': {
                    target: env.APP_URL || 'http://localhost:8000',
                    changeOrigin: true,
                    secure: false,
                },
            },
            
            // Enhanced performance optimizations
            fs: {
                strict: true,
                allow: ['..', './resources', './public'],
                deny: ['.env', '.env.*', '*.{pem,crt}'],
            },
            
            // Enhanced HTTPS configuration
            https: env.VITE_HTTPS === 'true' ? {
                // SSL configuration can be added here
                // cert: fs.readFileSync('path/to/cert.pem'),
                // key: fs.readFileSync('path/to/key.pem'),
            } : false,
            
            // Enhanced development optimizations
            warmup: {
                // Pre-transform these files for faster development
                clientFiles: ['./resources/js/app.js', './resources/css/app.css'],
            },
            
            // Better error handling
            middlewareMode: false,
        },

        // Preview server configuration
        preview: {
            host: '0.0.0.0',
            port: 4173,
            strictPort: true,
            cors: true,
        },

        // CSS processing optimization
        css: {
            devSourcemap: true,
            
            // PostCSS configuration
            postcss: './postcss.config.js',
            
            // CSS modules configuration
            modules: {
                localsConvention: 'camelCase',
            },
            
            // CSS preprocessing options
            preprocessorOptions: {
                scss: {
                    // additionalData: `@import "@/styles/variables.scss";`, // Enable if variables.scss exists
                },
            },
        },

        // Enhanced environment variables for Vue + Vanilla JS hybrid
        define: {
            // Vue-specific optimizations
            __VUE_PROD_DEVTOOLS__: !isProduction,
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: !isProduction,
            
            // Performance optimizations
            __VUE_PROD_DEVTOOLS_TREE__: !isProduction,
            
            // Custom app constants
            __APP_VERSION__: JSON.stringify(process.env.npm_package_version || '1.0.0'),
            __BUILD_TIME__: JSON.stringify(new Date().toISOString()),
        },

        // Enhanced dependency optimization for Vanilla JS + Vue hybrid
        optimizeDeps: {
            include: [
                // Vue ecosystem (for admin leads system)
                'vue',
                '@vueuse/core',
                'pinia',
                '@headlessui/vue',
                '@heroicons/vue',
                
                // Vanilla JS utilities
                'axios',
                'lodash-es',
                'date-fns',
            ],
            exclude: [
                'vue-demi'
            ],
            
            // Enhanced optimization settings
            force: false,
            holdUntilCrawlEnd: false,
            
            // ESBuild options optimized for both Vanilla JS and Vue
            esbuildOptions: {
                target: 'es2020',
                // Better tree shaking for vanilla JS
                treeShaking: true,
                // Module format optimization
                format: 'esm',
                // Platform-specific optimizations
                platform: 'browser',
                // Support for both CJS and ESM
                mainFields: ['browser', 'module', 'main'],
                conditions: ['import', 'module', 'browser', 'default'],
            },
        },

        // Enhanced worker configuration for better Vanilla JS support
        worker: {
            format: 'es',
            plugins: [],
            rollupOptions: {
                output: {
                    format: 'es',
                    inlineDynamicImports: false,
                },
            },
        },

        // Logging configuration
        logLevel: isDevelopment ? 'info' : 'warn',
        clearScreen: false,

        // Enhanced cache configuration
        cacheDir: 'node_modules/.vite',

        // JSON configuration optimized for Vanilla JS
        json: {
            namedExports: true,
            stringify: false,
        },

        // Enhanced experimental features for better Vanilla JS support
        experimental: {
            renderBuiltUrl(filename, { hostType }) {
                // Optimize asset URLs for production
                if (hostType === 'js') {
                    return { js: `window.__assetsPath('${filename}')` };
                } else {
                    return { relative: true };
                }
            },
        },
    };
});