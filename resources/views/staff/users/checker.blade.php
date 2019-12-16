@extends('layouts.single_column')

@section('title', 'ユーザー登録チェッカー - ' . config('app.name'))

@section('main')
<div class="card mb-3">
    <div class="card-header">ユーザー登録チェッカー</div>
    <div class="card-body">
        <form method="post" class="form-inline" action="{{ route('staff.users.check') }}">
            <div class="form-group">
                @csrf
                <input type="text" class="form-control" name="student_id" placeholder="学籍番号">
                <button type="submit" class="btn btn-primary ml-1">確認</button>
                <a href="{{ url('/home_staff') }}" class="btn btn-light ml-1">キャンセル</a>
            </div>
        </form>
    </div>
</div>

@if (isset($student_id))
<div class="card {{ isset($user) ? $user->areBothEmailsVerified() ? 'border-success' : 'border-warning' : 'border-danger' }}">
    <div class="card-header lead text-uppercase text-monospace">{{ $student_id }}</div>
    <div class="card-body">
        @if (isset($user))
            <h4 class="{{ $user->areBothEmailsVerified() ? 'text-success' : 'text-warning' }} mb-1 card-title">{{ $user->areBothEmailsVerified() ? '登録済み' : 'メールの認証が済んでいません' }}</h4>
            @if (!$user->hasVerifiedEmail())
                <p class="text-muted mb-1">連絡用メール未認証</p>
            @endif
            @if (!$user->hasVerifiedUnivemail())
                <p class="text-muted mb-1">学校発行のメール未認証</p>
            @endif
            <h5 class="card-title">{{ $user->name }}（{{ $user->name_yomi }}）</h5>
            <a href="{{ url('/home_staff/users/read/' . $user->id)}}" class="btn btn-primary" role="button"><i class="fa fa-eye mr-1" aria-hidden="true"></i>詳細</a>
        @else
            <p class="text-danger lead">未登録</p>
        @endif
    </div>
</div>
@endif
@endsection