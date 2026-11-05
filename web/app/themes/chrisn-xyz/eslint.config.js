import eslint from "@eslint/js";
import jestDom from "eslint-plugin-jest-dom";
import eslintPluginPrettierRecommended from "eslint-plugin-prettier/recommended";
import tseslint from "typescript-eslint";

export default tseslint.config(
  { files: ["assets/**/*.{js,jsx,ts,tsx}", "__tests__/**/*.{js,jsx,ts,tsx}"] },
  eslint.configs.recommended,
  ...tseslint.configs.recommended,
  jestDom.configs["flat/recommended"],
  eslintPluginPrettierRecommended,
);
