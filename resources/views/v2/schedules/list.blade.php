@extends('v2.layouts.app')

@section('title', 'スケジュール')

@section('content')
@foreach ($schedules as $month => $group)
<div class="listview">
    <div class="listview-header">
        {{ $month }}
    </div>
    @foreach ($group as $schedule)
    <a class="listview-item" href="{{ route('schedules.show', $schedule) }}">
        <div class="listview-item__day_calendar">
            @include('v2.includes.day_calendar', ['date' => $schedule->start_at])
        </div>
        <div class="listview-item__body">
            <p class="listview-item__title">
                {{ $schedule->name }}
            </p>
            <p class="listview-item__meta">
                @datetime($schedule->start_at)〜 • {{ $schedule->place }}
            </p>
            <p class="listview-item__summary">
                @summary($schedule->description)
            </p>
        </div>
    </a>
    @endforeach
</div>
@endforeach
@endsection
