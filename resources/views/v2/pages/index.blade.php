@extends('v2.layouts.app')

@section('title', 'お知らせ')

@section('content')
<list-view>
    @foreach ($pages as $page)
    <list-view-item href="{{ route('pages.show', $page) }}">
        <template v-slot:title>
            {{ $page->title }}
        </template>
        <template v-slot:meta>
            @datetime($page->updated_at)
        </template>
        @summary($page->body)
    </list-view-item>
    @endforeach
    @empty ($pages)
    <div class="listview-empty">
        <i class="fas fa-bullhorn listview-empty__icon"></i>
        <p class="listview-empty__text">お知らせはまだありません</p>
    </div>
    @endempty
</list-view>
@endsection
