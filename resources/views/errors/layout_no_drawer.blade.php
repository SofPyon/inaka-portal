@extends('v2.layouts.no_drawer')

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
                <br/>
                <a href="mailto:{{ config('portal.contact_email') }}">{{ config('portal.contact_email') }}</a>
            </div>
        @endif
        @hasSection ('twitter')
            @if (config('portal.admin_twitter'))
                <div class="error-twitter">
                    <a class="twitter-timeline" data-height="100%" data-chrome="noscrollbar noborders" href="https://twitter.com/{{ config('portal.admin_twitter') }}?ref_src=twsrc%5Etfw">
                        Tweets by {{ config('portal.admin_twitter') }}
                    </a>
                </div>
            @endif
        @endif
    </div>
</app-container>
@endsection
