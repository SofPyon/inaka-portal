@extends('v2.layouts.app')

@section('title', '申請')

@section('content')
<div class="tab_strip">
    <a
        href="{{ route('forms.index') }}"
        class="tab_strip-tab{{ Route::currentRouteName() === 'forms.index' ? ' is-active' : '' }}"
    >
        受付中
    </a>
    <a
        href="{{ route('forms.closed') }}"
        class="tab_strip-tab{{ Route::currentRouteName() === 'forms.closed' ? ' is-active' : '' }}"
    >
        受付終了
    </a>
    <a
        href="{{ route('forms.all') }}"
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
                <small><span class="badge is-success">提出済</span></small>
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
    
    <p><span class="badge is-primary">primary</span></p>
    <p><span class="badge is-success">success</span></p>
    <p><span class="badge is-danger">danger</span></p>
    <p><span class="badge is-muted">muted</span></p>
</div>
@endsection