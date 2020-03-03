@extends('v2.layouts.app')

@section('head')
@hasSection ('twitter')
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endif
@endsection

@section('content')
<app-container>
    <div class="error">
        <div class="error-code">
            @yield('code')
        </div>
        <div class="error-message">
            @yield('message')
        </div>
        @hasSection ('contact')
            <div class="error-contact">
                @yield('contact')
            </div>
        @endif
        @hasSection ('twitter')
        <div class="error-twitter">
            <a class="twitter-timeline" data-height="100%" data-chrome="noscrollbar noborders" href="https://twitter.com/{{ config('portal.admin_twitter') }}?ref_src=twsrc%5Etfw">
                Tweets by {{ config('portal.admin_twitter') }}
            </a>
        </div>
        @endif
    </div>
</app-container>
@endsection
