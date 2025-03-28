import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
  base: "/hubdamshare/",
  server: {
    hmr: {
      // host: "0.0.0.0",
    },
  },
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.tsx", "resources/css/filament/admin/theme.css"],
      refresh: true,
    }),
    react(),
  ],
});
