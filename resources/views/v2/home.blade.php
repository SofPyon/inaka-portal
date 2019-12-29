@extends('v2.layouts.app')

@section('content')
<div class="listview">
    <div class="listview-header">
        お知らせ
    </div>
    <div class="listview-item" v-for="i in 11">
        <p class="listview-item__title">食品衛生講習会について</p>
        <p class="listview-item__summary">これはテストです。これはテストです。これはテストです。</p>
    </div>
</div>
<div class="listview">
    <div class="listview-header">
        お知らせ
    </div>
    <div class="listview-item" v-for="i in 11">
        <p class="listview-item__date">
            2019/11/21
        </p>
        <p class="listview-item__title">食品衛生講習会について</p>
        <p class="listview-item__summary">これはテストです。これはテストです。これはテストです。</p>
    </div>
</div>
@endsection
