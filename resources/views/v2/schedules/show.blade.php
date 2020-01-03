@extends('v2.layouts.app')

@section('title', $schedule->name)

@section('navbar')
<a href="{{ route('schedules.index') }}" class="navbar-back">
    <i class="fas fa-chevron-left navbar-back__icon"></i>
    スケジュール
</a>
@endsection

@section('content')
<header class="header">
    <div class="container">
        <h1 class="header__title">
            {{ $schedule->name }}
        </h1>
        <p class="header__date">
            @datetime($schedule->start_at)〜 • {{ $schedule->place }}
        </p>
    </div>
</header>
<main class="container">
    <div class="markdown">
        @markdown($schedule->description)
    </div>
</main>
@endsection
