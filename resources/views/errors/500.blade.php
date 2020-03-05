@extends('errors.layout')

@section('title', 'サーバーエラーが発生しました')
@section('message', '恐れ入りますが、もう一度同じ操作をお試しください')
@section('contact', '何度も発生する場合は「' . config('app.name') . '」までお問い合わせください。')
@section('twitter', true)
