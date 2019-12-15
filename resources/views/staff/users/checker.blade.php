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
                    <button type="submit" class="btn btn-primary">確認</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if (isset($user))
    <div class="card mb-3">
        <div class="card-body">
            
        </div>
    </div>
@endif
@endsection