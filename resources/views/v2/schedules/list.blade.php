@extends('v2.layouts.app')

@section('title', 'スケジュール')

@section('content')
<div class="tab_strip">
    <a
        href="{{ route('schedules.index') }}"
        class="tab_strip-tab{{ Route::currentRouteName() === 'schedules.index' ? ' is-active' : '' }}"
    >
        今後の予定
    </a>
    <a
        href="{{ route('schedules.ended') }}"
        class="tab_strip-tab{{ Route::currentRouteName() === 'schedules.ended' ? ' is-active' : '' }}"
    >
        過去の予定
    </a>
</div>
@foreach ($schedules as $month => $group)
<list-view header-title="{{ $month }}">
    @foreach ($group as $schedule)
    <list-view-item
        href="{{ route('schedules.show', $schedule) }}"
        title="{{ $schedule->name }}"
        meta="@datetime($schedule->start_at)〜 • {{ $schedule->place }}"
    >
        @summary($schedule->description)
    </list-view-item>
    @endforeach
</list-view>
@endforeach
@empty ($schedules)
<list-view>
    <div class="listview-empty">
        <i class="far fa-calendar-alt listview-empty__icon"></i>
        <p class="listview-empty__text">予定はありません</p>
    </div>
</list-view>
@endempty
@endsection
