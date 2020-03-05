@extends('errors.layout')

@section('title', 'アクセスが拒否されました')
@section('message', __($exception->getMessage() ?: '権限がないか、アクセスできないページです'))
@section('twitter', false)
