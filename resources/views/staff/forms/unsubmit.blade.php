@extends('v2.layouts.no_drawer')

@section('title', '未提出団体一覧 - ' . config('app.name'))

@section('content')
<app-container>
    <list-view>
        <template v-slot:title>{{ $form->name }} - 未提出団体</template>
        {{-- @foreach ()
            <list-view-item>
            </list-view-item>
        @endforeach
    </list-view> --}}
</app-container>
@endsection
