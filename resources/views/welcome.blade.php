<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LaraVue Ticketing System</title>
    {{-- @vite(['resources/css/app.css','resources/js/app.js']) --}}
    <link rel="stylesheet" href="{{ asset('/public/css/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>
<body class="font-sans antialiased sb-nav-fixed">
    <div  id="app">
        <router-view/>
        {{-- <route-view></route-view> --}}
        {{-- <index-component></index-component> --}}
    </div>
    <script src="{{ asset('/public/js/app.js') }}"></script>
    <!-- Core plugin JavaScript-->
</body>
