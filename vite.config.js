import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        port: 3000,
        host: 'localhost',
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/custom.js',
                'resources/css/app.css',
                'resources/js/index.js',
                'resources/css/index.css',
                'resources/js/particles.js',
                'resources/js/particles_in.js',
                'resources/css/reg.css',
                'resources/js/reg.js',
                'resources/js/common.js',
                'resources/js/auth.js',
                'resources/css/sidebars.css',
                'resources/css/main.css',
                'resources/js/script.js',
                'resources/js/menu.js',
                'resources/js/userMenu.js',
                'resources/js/color-modes.js',
                'resources/js/main.js',
                'resources/js/timeReload.js',
                'resources/js/time.js',
                'resources/css/client.css',
                'resources/js/client.js',
                'resources/css/attorney.css',
                'resources/js/Attorney.js',
                'resources/css/call.css',
                'resources/js/cool.js',
                'resources/js/check.js',
                'resources/css/check_total.css',
                'resources/js/check_total.js',
                'resources/css/company.css',
                'resources/js/CompanyCall.js',
                'resources/js/logistic.js',
                'resources/css/manager.css',
                'resources/js/ManagerController.js',
                'resources/css/profile.css',
                'resources/js/profile.js',
                'resources/js/provider.js',
                'resources/css/setting.css',
                'resources/js/setting.js',

            ],
            refresh: true,
        }),
    ],
});











