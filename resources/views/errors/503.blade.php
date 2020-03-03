@extends('errors.layout_no_drawer')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'サービスを利用できません。'))
@section('contact', "しばらく経ってから再度お試しください。解決しない場合は「".config('portal.admin_name')."」へお問い合わせください。")
@section('twitter', true)
