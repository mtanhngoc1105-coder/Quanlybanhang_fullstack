<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>QLBH - Quản lý bán hàng</title>
    @if (file_exists(public_path('dist/manifest.json')))
        @vite('resources/js/main.js')
    @else
        <script>
            console.warn('Vue dist not found. Run: npm run build in qlbh-frontend folder');
        </script>
    @endif
  </head>
  <body>
    <div id="app"></div>
  </body>
</html>
