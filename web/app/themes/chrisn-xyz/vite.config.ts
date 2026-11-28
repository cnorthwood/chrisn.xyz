import postcssPresetEnv from "postcss-preset-env";
import { defineConfig } from "vitest/config";
import manifestSRI from "vite-plugin-manifest-sri";

export default defineConfig({
  base: "./",
  build: {
    manifest: true,
    rollupOptions: {
      input: {
        main: "./assets/main.ts",
      },
    },
  },
  plugins: [manifestSRI()],
  css: {
    postcss: {
      plugins: [postcssPresetEnv({ browsers: "defaults" })],
    },
  },
  test: {
    environment: "jsdom",
    globals: true,
  },
  server: {
    origin: "http://localhost:5173",
    port: 5173,
    strictPort: true,
  },
});
