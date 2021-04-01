<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Todo</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">        
        <link rel="stylesheet" href="/css/app.css">
        <script src="/js/app.js" defer></script>
    </head>
    <body>
        <div id="app">

            <tod-do></tod-do>
            
        </div>
    </body>
</html>
