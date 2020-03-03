@extends('errors.layout')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('アクセス権限がありません'))
@section('twitter', false)
