@extends('v2.layouts.app')

@hasSection ('twitter')
@push('js')
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endpush
@endif

@section('content')
<app-container>
    <div class="error">
        <div class="error-title">
            @yield('title')
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
