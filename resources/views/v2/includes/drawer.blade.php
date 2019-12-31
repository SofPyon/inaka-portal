<a class="drawer-header" href="{{ url('/') }}">
    {{ config('app.name') }}
</a>
<nav class="drawer-nav">
    <ul class="drawer-nav__list">
        <li class="drawer-nav__item">
            <a href="" class="drawer-nav__link{{ Request::is('') ? ' is-active' : '' }}">
                ホーム
            </a>
        </li>
        <li class="drawer-nav__item">
            <a href="" class="drawer-nav__link{{ Request::is('pages*') ? ' is-active' : '' }}">
                お知らせ
            </a>
        </li>
        <li class="drawer-nav__item">
            <a href="" class="drawer-nav__link">
                配布資料
            </a>
        </li>
        <li class="drawer-nav__item">
            <a href="" class="drawer-nav__link">
                申請
            </a>
        </li>
        <li class="drawer-nav__item">
            <a href="" class="drawer-nav__link">
                今後の予定
            </a>
        </li>
        <li class="drawer-nav__item">
            <a href="" class="drawer-nav__link">
                お問い合わせ
            </a>
        </li>
        <li class="drawer-nav__item">
            <a href="" class="drawer-nav__link">
                ユーザー設定
            </a>
        </li>
    </ul>
</nav>
<div class="drawer-user">
    @auth
    <p class="drawer-user__info">
        {{ Auth::user()->name }}としてログイン中
    </p>
    <a
        href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        class="btn is-secondary is-block is-no-border"
    >
        ログアウト
    </a>
    @else
    <p class="drawer-user__info">
        ログインしていません
    </p>
    <a href="{{ url('/') }}" class="btn is-secondary is-block is-no-border">
        <strong>ログイン</strong>
    </a>
    @endauth
    <form id="logout-form" action="{{ route('logout') }}" method="post">
        @csrf
    </form>
</div>
