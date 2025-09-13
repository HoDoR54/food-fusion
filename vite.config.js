import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/ts/main.ts",
                "resources/js/app.js",
                "resources/js/interactivity/mobile-menu.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
