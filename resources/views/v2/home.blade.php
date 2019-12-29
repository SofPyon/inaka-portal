@extends('v2.layouts.app')

@section('content')
@guest
<header class="jumbotron">
    <div class="jumbotron__content">
        <h1 class="jumbotron__title">
            {{ config('app.name') }}
        </h1>
        <p class="jumbotron__lead">
            {{ config('portal.admin_name') }}
        </p>
        <form method="post" action="{{ route('login') }}">
            @csrf

            @if ($errors->any())
                <div class="text-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="form-group">
                <label for="login_id" class="sr-only">学籍番号・連絡先メールアドレス</label>
                <input id="login_id" type="text" class="form-control" name="login_id" value="{{ old('login_id') }}" required autocomplete="username" autofocus placeholder="学籍番号・連絡先メールアドレス">
            </div>

            <div class="form-group">
                <label for="password" class="sr-only">パスワード</label>
                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="パスワード">
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        ログインしたままにする
                    </label>

                    —

                    <a href="{{ route('password.request') }}">
                        パスワードをお忘れの場合はこちら
                    </a>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn is-primary">
                    ログイン
                </button>
            </div>
            <p>
                <a class="btn is-secondary" href="{{ route('register') }}">
                    はじめての方は新規ユーザー登録
                </a>
            </p>
        </form>
    </div>
</header>
@endguest
<div class="listview">
    <div class="listview-header">
        お知らせ
    </div>
    <div class="listview-item" v-for="i in 11">
        <p class="listview-item__title">食品衛生講習会について</p>
        <p class="listview-item__summary">これはテストです。これはテストです。これはテストです。</p>
    </div>
</div>
<div class="listview">
    <div class="listview-header">
        最近の配布資料 — 第1回 理大祭参加説明書い最近の配布資料 — 第1回 理大祭参加説明書い最近の配布資料 — 第1回 理大祭参加説明書い最近の配布資料 — 第1回 理大祭参加説明書い
    </div>
    <div class="listview-item" v-for="i in 11">
        <p class="listview-item__date">
            2019/11/21
        </p>
        <p class="listview-item__title">食品衛生講習会について</p>
        <p class="listview-item__summary">これはテストです。これはテストです。これはテストです。</p>
    </div>
</div>
@endsection
