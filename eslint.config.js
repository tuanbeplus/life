import globals from "globals";
import pluginJs from "@eslint/js";
import pluginVue from "eslint-plugin-vue";
import { FlatCompat } from "@eslint/eslintrc";
import path from "path";
import { fileURLToPath } from "url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const compat = new FlatCompat({
  baseDirectory: __dirname,
});


export default [
  { files: ["**/*.{js,mjs,cjs,vue}"] },
  pluginJs.configs.recommended,
  ...pluginVue.configs['flat/essential'],
  ...compat.extends('plugin:vue/base'),
  ...compat.extends('plugin:vue/essential'),
  ...compat.extends('plugin:vue/strongly-recommended'),
  ...compat.extends('plugin:vue/recommended'),
  {
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: "module",
      globals: {
        ...globals.browser,
      },
    },
    rules: {
      'no-unused-vars': 'off',
      'no-constant-condition': 'off',
      'no-empty': 'off',
      'no-case-declarations': 'off',
      'no-fallthrough': 'off',
      'vue/no-mutating-props': 'off',
      'vue/html-self-closing': 'off',
      'vue/no-multiple-template-root': 'off',
      'vue/require-v-for-key': 'off',
      'vue/no-template-key': 'off',
      'vue/valid-v-for': 'off',
      'comma-dangle': ['error', {
        objects: 'always-multiline',
        arrays: 'always-multiline',
      }],
      indent: [2, 2, { SwitchCase: 1 }],
      'object-curly-spacing': [
        'error',
        'always',
      ],
      'space-before-function-paren': [
        'error',
        'never',
      ],
      'space-before-blocks': [
        'error',
        'always',
      ],
      'vue/no-v-html': 'off',
    },
  },
]
