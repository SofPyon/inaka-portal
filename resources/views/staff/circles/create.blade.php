@extends('layouts.app')

@section('title', '団体情報新規作成')

@section('content')
<div class="container">
    <form method="post" action="{{ route('staff.circles.create') }}">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label for="nameInput" class="col-sm-2 col-form-label">団体名</label>
                    <div class="col-sm-10">
                        <input
                            id="nameInput"
                            class="form-control @if ($errors->has('name')) is-invalid @endif"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                        >
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                @foreach ($errors->get('name') as $message)
                                    {{ $message }}
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="leaderInput" class="col-sm-2 col-form-label">責任者の学籍番号</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control @if ($errors->has('leader')) is-invalid @endif" id="leaderInput" name="leader" value="{{ old('leader') }}">
                        @error('leader')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label for="membersInput" class="col-sm-2 col-form-label">学園祭係(副責任者)の学籍番号</label>
                    <div class="col-sm-4">
                        <textarea id="membersInput" class="form-control @if ($errors->has('members')) is-invalid @endif" name="members" rows="3">{{ old('members') }}</textarea>
                        @error('members')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small>学籍番号を改行して入力することで複数の学園祭係を追加できます</small>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label for="StaffNote">スタッフ用メモ</label>
                    <textarea id="StaffNote" class="form-control" name="notes" rows="5">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">保存</button>
                <a href="{{ url('/home_staff/circles') }}" class="btn btn-light" role="button">キャンセル</a>
            </div>
        </div>
    </form>
</div>
@endsection
