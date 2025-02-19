import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js',],
            refresh: true,
            manifest: true,  // Включаем манифест
            manifestPath: 'public/build/manifest.json',  // Задаем путь вручную
        }),
    ],
    build: {
        outDir: 'public/build',  // Выходная директория
        emptyOutDir: true,  // Очищает перед билдом
        rollupOptions: {
            output: {
                assetFileNames: 'assets/[name]-[hash][extname]',
                entryFileNames: 'assets/[name]-[hash].js',
            },
        },
    }
});
