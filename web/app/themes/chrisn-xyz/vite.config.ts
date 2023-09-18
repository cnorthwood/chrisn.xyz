import postcssPresetEnv from "postcss-preset-env";
import { defineConfig } from "vite";
import manifestSRI from "vite-plugin-manifest-sri";

export default defineConfig({
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
  server: {
    origin: "http://localhost:5173",
    port: 5173,
    strictPort: true,
  },
});
