@extends('v2.layouts.app')

@section('title', '配布資料')

@section('content')
<list-view>
    @foreach ($documents as $document)
    <list-view-item
        href="{{ url("uploads/documents/{$document->id}") }}"
        newtab
    >
        <template v-slot:title>
            @if ($document->is_important)
            <i class="fas fa-exclamation-circle fa-fw text-danger"></i>
            @else
            <i class="far fa-file-alt fa-fw"></i>
            @endif
            {{ $document->name }}
        </template>
        <template v-slot:meta>
            @datetime($document->updated_at) 更新
            @isset($document->schedule)
            •
            {{ $document->schedule->name }}で配布
            @endisset
        </template>
        @summary($document->description)
    </list-view-item>
    @endforeach
    @empty ($documents)
    <div class="listview-empty">
        <i class="far fa-file-alt listview-empty__icon"></i>
        <p class="listview-empty__text">配布資料はまだありません</p>
    </div>
    @endempty
</list-view>
@endsection
