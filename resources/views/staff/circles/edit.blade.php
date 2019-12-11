@extends('layouts.app')

@section('title', '団体情報編集')

@section('content')
<div class="container">
    <form method="post" action="#">
        @csrf
        <div class="form-group row">
            <label for="nameInput" class="col-sm-2 col-form-label">団体名</label>
            <div class="col-sm-10">
                <input
                    id="nameInput"
                    class="form-control"
                    type="text"
                    name="name"
                    value="{{ old('name', $circle->name) }}"
                    required
                >
            </div>
        </div>

        <div class="form-group row">
            <label for="leaderInput" class="col-sm-2 col-form-label">責任者の学籍番号</label>
            <div class="col-sm-10">
                <input type="text" id="leaderInput" name="leader" value="{{ old('leader', empty($leader) ? '' : $leader->student_id) }}">
            </div>
        </div>


        <div class="form-group row">
            <label for="membersInput" class="col-sm-2 col-form-label">学園祭係(副責任者)</label>
            <div class="col-sm-10">
                <textarea id="membersInput" name="members"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="StaffNote">スタッフ用メモ</label>
            <textarea id="StaffNote" class="form-control" name="notes" rows="5">{{ $circle->notes }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">保存</button>
    </form>
</div>
@endsection
