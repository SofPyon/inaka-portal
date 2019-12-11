@extends('layouts.app')

@section('title', '団体情報編集')

@section('content')
<body>
<div class="container">


<form method="post" action="#">
@csrf
<div class="form-group row">
    <label for="nameInput" class="col-sm-2 col-form-label">団体名</label>
    <div class="col-sm-10">
        <input id="nameInput" class="form-control" type="text" name="name" placeholder="団体名 を入力" value="{{ $circle->name }}" require>
    </div>
</div>

<div class="form-group row">
    <label for="leaderInput" class="col-sm-2 col-form-label">責任者</label>
    <div class="col-sm-10">
        <select id="leaderInput" class="custom-select" name="leaders" multiple>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" >{{ $user->student_id }} {{ $user->name_family }} {{ $user->name_given }}</option>
            @endforeach
        </select>
    </div>
</div>


<div class="form-group row">
    <label for="festivalInput" class="col-sm-2 col-form-label">学園祭係</label>
    <div class="col-sm-10">
        <select id="festivalInput" class="custom-select" name="festivals" multiple>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" >{{ $user->student_id }} {{ $user->name_family }} {{ $user->name_given }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label for="StaffNote">スタッフ用メモ</label>
    <textarea id="StaffNote" class="form-control" name="notes" rows="5">{{ $circle->notes }}</textarea>
</div>
<button type="submit" class="btn btn-primary">保存</button>
</form>

</div>
</body>
@endsection