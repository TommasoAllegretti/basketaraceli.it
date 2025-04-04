<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    @vite('resources/css/app.css')
  </head>
  <body>
    <x-navbar></x-navbar>
    @yield('content')
  </body>
</html>