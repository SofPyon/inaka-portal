@extends('errors.layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('申し訳ございません。エラーが発生しました。'))
@section('contact', '何度も発生する場合は「' . config('app.name') . '」までお問い合わせください。')
@section('twitter', true)
