import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
  plugins: [vue()],
  base: '/',
  server: {
    port: 5173,
    host: '127.0.0.1',
    proxy: {
      '/api': {
        target: 'http://localhost/QLBH',
        changeOrigin: true,
        rewrite: (path) => path
      }
    }
  },
  build: {
    outDir: path.resolve(__dirname, '../QLBH/public/dist'),
    emptyOutDir: true,
    manifest: true
  }
})