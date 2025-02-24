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
                // CSS файлы
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/css/index.css',
                'resources/css/reg.css',
                'resources/css/sidebars.css',
                'resources/css/main.css',
                'resources/css/client.css',
                'resources/css/attorney.css',
                'resources/css/call.css',
                'resources/css/check_total.css',
                'resources/css/helper.css',
                'resources/css/company.css',
                'resources/css/manager.css',
                'resources/css/profile.css',
                'resources/css/setting.css',
                'resources/css/filemanager.css',
                'resources/css/provider.css',
                'resources/css/check.css',
                'resources/css/logistics.css',

                // JS файлы
                'resources/js/app.js',
                'resources/js/custom.js',
                'resources/js/index.js',
                'resources/js/particles.js',
                'resources/js/particles_in.js',
                'resources/js/reg.js',
                'resources/js/common.js',
                'resources/js/auth.js',
                'resources/js/script.js',
                'resources/js/menu.js',
                'resources/js/userMenu.js',
                'resources/js/color-modes.js',
                'resources/js/main.js',
                'resources/js/timeReload.js',
                'resources/js/time.js',
                'resources/js/client.js',
                'resources/js/Attorney.js',
                'resources/js/cool.js',
                'resources/js/check.js',
                'resources/js/check_total.js',
                'resources/js/CompanyCall.js',
                'resources/js/logistic.js',
                'resources/js/ManagerController.js',
                'resources/js/profile.js',
                'resources/js/provider.js',
                'resources/js/setting.js',
                'resources/js/filemanager.js',
                'resources/js/sidebars.js',
            ],
            refresh: true,
        }),
    ],
});











