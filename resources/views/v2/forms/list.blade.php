@extends('v2.layouts.app')

@section('title', '申請')

@section('content')
@if(empty($circle))
    <header class="header">
        <div class="container">
            <h1 class="header__title">
                手続きが完了していません
            </h1>
        </div>
    </header>
    <div class="container">
        <p>団体参加登録が済んでいないため、申請を行うことができません</p>
        <p>詳細については「{{ config('portal.admin_name') }}」までお問い合わせください</p>
        <p>※ すでに団体参加登録を行った場合でも反映に時間がかかることがあります</p>
        <p><a href="{{ url('/') }}" class="btn is-primary is-block" role="button">ホームに戻る</a></p>
    </div>
@else
    <div class="tab_strip">
        <a
            href="{{ route('forms.index', ['circle' => $circle]) }}"
            class="tab_strip-tab{{ Route::currentRouteName() === 'forms.index' ? ' is-active' : '' }}"
        >
            受付中
        </a>
        <a
            href="{{ route('forms.closed', ['circle' => $circle]) }}"
            class="tab_strip-tab{{ Route::currentRouteName() === 'forms.closed' ? ' is-active' : '' }}"
        >
            受付終了
        </a>
        <a
            href="{{ route('forms.all', ['circle' => $circle]) }}"
            class="tab_strip-tab{{ Route::currentRouteName() === 'forms.all' ? ' is-active' : '' }}"
        >
            全て
        </a>
    </div>

    <div class="listview">
        @foreach ($forms as $form)
        <a class="listview-item" href="/applications/{{ $form->id }}/answers/create?circle_id={{ $circle->id }}">
            <div class="listview-item__body">
                <p class="listview-item__title">
                    {{ $form->name }}
                    @if($form->answered($circle))
                        <small class="badge is-success">提出済</small>
                    @endif
                    @if($form->open_at > $now)
                        <small><span class="badge is-muted">受付開始前</span></small>
                    @endif
                </p>
                <p class="listview-item__meta">
                    @datetime($form->close_at) まで受付
                </p>
                <p class="listview-item__summary">
                    @summary($form->description)
                </p>
            </div>
        </a>
        @endforeach
    </div>
@endif
@endsection
