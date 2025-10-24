import { defineConfig, loadEnv } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import { fileURLToPath } from 'url'

const __dirname = path.dirname(fileURLToPath(import.meta.url))


// https://vitejs.dev/config/
export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, __dirname, '')
  const VITE_TEST_TEST_SCORE = 'VITE_TEST_TEST_SCORE' in env ? JSON.stringify(env.VITE_TEST_TEST_SCORE) : null
  const VITE_CONTACT_AUTO_FILL = 'VITE_CONTACT_AUTO_FILL' in env ? (!!env.VITE_CONTACT_AUTO_FILL) : false
  const vitePort = env.VITE_PORT || 5173
  return {
    plugins: [
      vue(),
    ],
    root: 'src',
    base: env.APP_ENV === 'production' ? '/wp-content/themes/life/dist/' : '/',
    build: {
      // minify: false,
      outDir: '../public/dist',
      emptyOutDir: true,
      manifest: true,
      rollupOptions: {
        input: {
          app: './src/app.js',
        },
      },
    },
    define: {
      __APP_ENV__: JSON.stringify(env.APP_ENV),
      VITE_TEST_TEST_SCORE,
      VITE_CONTACT_AUTO_FILL,
    },
    css: {
      devSourcemap: true,
    },
    resolve: {
      alias: {
        '@': path.resolve(__dirname, './src/js'),
        '~': path.resolve(__dirname, './src/js/components'),
        '#': path.resolve(__dirname, './src/js/composables'),
      },
    },
    server: {
      port: vitePort,
      hmr: {
        host: 'localhost',
        port: vitePort,
        protocol: 'ws',
      },
    },
  }
})

