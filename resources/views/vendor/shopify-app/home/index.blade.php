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
    <script>
        window.qikifyEmbeddedData = {
            key: "{{ config('shopify-app.api_key') }}",
            host: "{{$host}}",
            shop: "{{$shop}}",
            path: "{{$path}}",
            query: {{ Js::from($query) }},
            user: {{ Js::from($user) }},
        }
    </script>
    @env('local')
        <script type="module" src="{{ config('app.portal_url') }}/src/main.ts"></script>
    @endenv
</body>

</html>
