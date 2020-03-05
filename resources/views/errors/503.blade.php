@extends('errors.layout_no_drawer')

@section('title', '現在「' . config('app.name') . '」を利用することができません')
@section('message', __($exception->getMessage() ?: '時間を開けてもう一度お試しください。'))
@section('contact', "解決しない場合は「".config('portal.admin_name')."」へお問い合わせください。")
@section('twitter', true)
