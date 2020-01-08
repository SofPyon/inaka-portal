@extends('v2.layouts.app')

@section('title', '申請')

@section('content')
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
    <a class="listview-item" href="#">
        <div class="listview-item__body">
            <p class="listview-item__title">
                {{ $form->name }}
                @if($form->answered($circle))
                    <small><span class="badge is-success">提出済</span></small>
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
@endsection