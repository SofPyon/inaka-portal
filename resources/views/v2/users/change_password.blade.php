@extends('v2.layouts.app')

@section('title', 'ユーザー設定')

{{-- TODO: 完全にLaravel化したら、以下のdrawerセクションは完全削除する --}}
@section('drawer')
<a class="drawer-header" href="{{ url('/') }}">
    {{ config('app.name') }}
</a>
<nav class="drawer-nav">
    <ul class="drawer-nav__list">
        <li class="drawer-nav__item">
            <a href="{{ url('/') }}" class="drawer-nav__link">
                ホームに戻る
            </a>
        </li>
    </ul>
</nav>
@endsection

@section('bottom_tabs')
{{-- TODO: 完全にLaravel化したら、このセクションは完全削除する --}}
@endsection

@section('content')
@include('v2.includes.user_settings_tab_strip')

<form method="POST" action="{{ route('change_password') }}">
    @csrf

    <list-view header-title="パスワード変更">
        <list-view-form-group label-for="password">
            <template v-slot:label>現在のパスワード</template>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
            <template v-slot:invalid>{{ $message }}</template>
            @enderror
        </list-view-form-group>
        <list-view-form-group label-for="new_password">
            <template v-slot:label>新しいパスワード</template>
            <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new-password">
            @error('new_password')
            <template v-slot:invalid>{{ $message }}</template>
            @enderror
        </list-view-form-group>
        <list-view-form-group label-for="new_password_confirmation">
            <template v-slot:label>新しいパスワード(確認)</template>
            <input id="new_password_confirmation" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password_confirmation" required autocomplete="new-password">
        </list-view-form-group>
    </list-view>

    <div class="container text-center pt-spacing-md">
        <button type="submit" class="btn is-primary is-wide">保存</button>
    </div>
</form>
@endsection
