import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import { resolve } from "node:path";

export default defineConfig({
  base: "/hubdamshare/",
  server: {
    host: "0.0.0.0",
    port: 5173,
    strictPort: true,
    cors: {
      origin: "http://hubdamdigidaw.com",
      credentials: true,
    },
    hmr: {
      host: "hubdamdigidaw.com",
    },
  },
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.tsx", "resources/css/filament/admin/theme.css"],
      ssr: "resources/js/ssr.tsx",
      refresh: true,
    }),
    react(),
  ],
  resolve: {
    alias: {
      "ziggy-js": resolve("vendor/tightenco/ziggy"),
      ui: resolve("resources/js/components/ui/index.ts"),
    },
  },
});
