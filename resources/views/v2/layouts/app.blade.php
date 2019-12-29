<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title')</title>

    @prepend('css')
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link href="{{ mix('css/v2/app.css') }}" rel="stylesheet">
    @endprepend
    @stack('css')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    @prepend('js')
        <script src="{{ mix('js/v2/app.js') }}" defer></script>
    @endprepend
    @stack('js')

    <meta name="format-detection" content="telephone=no">
</head>
</head>
<body ontouchstart="">

<div class="app" id="v2-app">
    <div
        class="drawer-backdrop"
        v-bind:class="{'is-open': isDrawerOpen}"
        v-on:click="toggleDrawer"
    ></div>
    <div class="navbar">
        <button
            v-on:click="toggleDrawer"
        >
            Toggle
        </button>
    </div>
    <div
        class="drawer"
        v-bind:class="{'is-open': isDrawerOpen}"
    >

    </div>
    <div class="content">
        @yield('content')
    </div>
</div>

</body>
</html>
