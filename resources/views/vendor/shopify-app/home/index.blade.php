<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scaffolding</title>
</head>

<body>
    <div id="app"></div>
    <script type="text/plain" id="shop_key">{{ config('shopify-app.api_key') }}</script>
    <script type="text/plain" id="shop_name">{{ Request::input('shop') }}</script>
    <script type="text/plain" id="host">{{ Request::input('host') }}</script>
    <script> console.log(window.location)</script>
    @env('local')
        <script type="module" src="{{ config('app.portal_url') }}/src/main.ts"></script>
    @endenv
</body>

</html>
