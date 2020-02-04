@extends('v2.layouts.app')

@section('content')

@auth
@if (Auth::user()->areBothEmailsVerified() && count($my_circles) < 1)
<top-alert type="primary">
    <template v-slot:title>
        <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
        参加登録をしましょう！
    </template>

    まだ参加登録がお済みでないようですね。まずは参加登録からはじめましょう！
    <template v-slot:cta>
        <a href="#" class="btn is-primary-inverse is-no-border is-wide">
            <strong>参加登録をはじめる</strong>
        </a>
    </template>
</top-alert>
@endif
@endauth

@guest
<header class="jumbotron">
    <div class="container is-narrow">
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
                </div>
            </div>

            <p>
                <a href="{{ route('password.request') }}">
                    パスワードをお忘れの場合はこちら
                </a>
            </p>

            <div class="form-group">
                <button type="submit" class="btn is-primary is-block">
                    <strong>ログイン</strong>
                </button>
            </div>
            <p>
                <a class="btn is-secondary is-block" href="{{ route('register') }}">
                    はじめての方は新規ユーザー登録
                </a>
            </p>
        </form>
    </div>
</header>
@endguest
@isset($next_schedule)
<list-view header-title="次の予定">
    <list-view-item
        title="{{ $next_schedule->name }}"
        meta="@datetime($next_schedule->start_at)〜 • {{ $next_schedule->place }}"
    >
        @isset ($next_schedule->description)
        <div class="markdown">
            <hr>
            @markdown($next_schedule->description)
        </div>
        @endisset
    </list-view-item>
    <list-view-action-btn href="{{ route('schedules.index') }}">
        他の予定を見る
    </list-view-action-btn>
</list-view>
@endisset
<list-view header-title="お知らせ">
    @foreach ($pages as $page)
    <list-view-item
        title="{{ $page->title }}"
        meta="@datetime($page->updated_at)"
        href="{{ route('pages.show', $page) }}"
    >
        @summary($page->body)
    </list-view-item>
    @endforeach
    @if ($remaining_pages_count > 0)
    <list-view-action-btn href="{{ route('pages.index') }} ">
        残り {{ $remaining_pages_count }} 件のお知らせを見る
    </list-view-action-btn>
    @endif
    @empty ($pages)
    <div class="listview-empty">
        <i class="fas fa-bullhorn listview-empty__icon"></i>
        <p class="listview-empty__text">お知らせはまだありません</p>
    </div>
    @endempty
</list-view>

<list-view header-title="最近の配布資料">
    @foreach ($documents as $document)
    <list-view-item
        title="{{ $page->title }}"
        meta="@datetime($page->updated_at)"
        href="{{ url("uploads/documents/{$document->id}") }}"
        newtab
    >
        @summary($page->body)
    </list-view-item>
    <a

    >
        <div class="listview-item__body">
            <p class="listview-item__title{{ $document->is_important ? ' text-danger' : '' }}">
                @if ($document->is_important)
                <i class="fas fa-exclamation-circle"></i>
                @else
                <i class="far fa-file-alt fa-fw"></i>
                @endif
                {{ $document->name }}
            </p>
            <p class="listview-item__meta">
                @datetime($document->updated_at) 更新
                @isset($document->schedule)
                •
                {{ $document->schedule->name }}で配布
                @endisset
            </p>
            <p class="listview-item__summary">{{ $document->description }}</p>
        </div>
    </a>
    @endforeach
    @if ($remaining_documents_count > 0)
    <a class="listview-item is-action-btn" href="{{ route('documents.index') }}">
        残り {{ $remaining_documents_count }} 件の配布資料を見る
    </a>
    @endif
    @empty ($documents)
    <div class="listview-empty">
        <i class="far fa-file-alt listview-empty__icon"></i>
        <p class="listview-empty__text">配布資料はまだありません</p>
    </div>
    @endempty
</list-view>
@endsection
