<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @hasSection ('title')
            @yield('title') —
        @endif
        {{ config('app.name') }}
    </title>

    @prepend('css')
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" integrity="sha384-REHJTs1r2ErKBuJB0fCK99gCYsVjwxHrSU0N7I1zl9vZbggVJXRMsv/sLlOAGb4M" crossorigin="anonymous">
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
    <global-events
        v-on:keyup.esc="closeDrawer"
    ></global-events>
    <div
        class="drawer-backdrop"
        v-bind:class="{'is-open': isDrawerOpen}"
        v-on:click="closeDrawer"
    ></div>
    <div class="navbar">
        @section('navbar')
        <button
            class="navbar-toggle"
            v-on:click="toggleDrawer"
            ref="toggle"
        >
            <img src="{{ url('img/drawerToggle.svg') }}" alt="ドロワーを開閉">
        </button>
        <div class="navbar__title">
            @yield('title', config('app.name'))
        </div>
        @show
    </div>
    <div
        class="drawer"
        v-bind:class="{'is-open': isDrawerOpen}"
        tabindex="0"
        ref="drawer"
    >
        <div class="drawer__content">
        @section('drawer')
        @include('v2.includes.drawer')
        @show
        </div>
    </div>
    <div class="content">
        @auth
            @unless (Auth::user()->areBothEmailsVerified())
                <div class="top_alert is-primary">
                    <h2 class="top_alert__title">
                        <i class="fa fa-exclamation-triangle fa-fw" aria-hidden="true"></i>
                        メール認証を行ってください
                    </h2>
                    <p class="top_alert__body">
                        {{ config('app.name') }}の全機能を利用するには、次のメールアドレス宛に送信された確認メール内のURLにアクセスしてください。
                        <strong>
                        @unless (Auth::user()->hasVerifiedUnivemail())
                            {{ Auth::user()->univemail }}
                            @unless (Auth::user()->hasVerifiedEmail())
                                •
                            @endunless
                        @endunless
                        @unless (Auth::user()->hasVerifiedEmail())
                            {{ Auth::user()->email }}
                        @endunless
                        </strong>
                    </p>
                    <form class="top_alert__body pt-spacing-sm" action="{{ route('verification.resend') }}" method="post">
                        @csrf
                        <button class="btn is-secondary is-no-border is-wide">
                            <strong>確認メールを再送</strong>
                        </button>
                    </form>
                </div>
            @endunless
        @endauth
        @if (Session::has('topAlert.title'))
            <div class="top_alert is-primary">
                <h2 class="top_alert__title">{{ session('topAlert.title') }}</h2>
                @if (Session::has('topAlert.body'))
                    <p class="top_alert__body">{{ session('topAlert.body') }}</p>
                @endif
            </div>
        @endif
        @yield('content')
    </div>
    @section('bottom_tabs')
    @include('v2.includes.bottom_tabs')
    @show
</div>

</body>
</html>
