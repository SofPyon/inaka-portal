@extends('v2.layouts.app')

@section('title', 'お問い合わせ')

{{-- TODO: 完全にLaravel化したら、以下のdrawerセクションは完全削除する --}}
@section('drawer')
<a class="drawer-header" href="{{ url('/') }}">
    {{ config('app.name') }}
</a>
<nav class="drawer-nav">
    <ul class="drawer-nav__list">
        <li class="drawer-nav__item">
            <a href="{{ url('/') }}" class="drawer-nav__link">
                ホームに戻る
            </a>
        </li>
    </ul>
</nav>
@endsection

@section('bottom_tabs')
{{-- TODO: 完全にLaravel化したら、このセクションは完全削除する --}}
@endsection

@section('content')
<form method="post" action="{{ route('contacts.post') }}">
    @csrf

    <list-view header-title="お問い合わせ">
        <list-view-form-group label-for="recipient">
            <template v-slot:label>宛先</template>
            <input type="text" id="recipient" readonly value="{{ config('portal.admin_name') }}" class="form-control is-plaintext">
        </list-view-form-group>
        <list-view-form-group label-for="name">
            <template v-slot:label>名前</template>
            <input type="text" id="name" readonly value="{{ Auth::user()->name }}" class="form-control is-plaintext">
        </list-view-form-group>
        <list-view-form-group label-for="student_id">
            <template v-slot:label>学籍番号</template>
            <input type="text" id="student_id" readonly value="{{ Auth::user()->student_id }}" class="form-control is-plaintext">
        </list-view-form-group>
        <list-view-form-group label-for="email">
            <template v-slot:label>メールアドレス</template>
            <template v-slot:description>
                メールアドレスの変更は<a href="{{ route('user.edit') }}">ユーザー設定</a>で行えます。
            </template>
            <input type="email" id="email" readonly value="{{ Auth::user()->email }}" class="form-control is-plaintext">
        </list-view-form-group>
        @unless (empty($circles) || count($circles) < 1)
            <list-view-form-group label-for="circle_id">
                <template v-slot:label>団体名</template>
                <template v-slot:description>どの団体としてお問い合わせするのか選択してください。</template>
                <select name="circle_id" id="circle_id" class="form-control">
                    @foreach ($circles as $circle)
                        @if (!empty(old('circle_id')) && old('circle_id') === $circle->id)
                            <option value="{{ $circle->id }}" selected>{{ $circle->name }}</option>
                        @else
                            <option value="{{ $circle->id }}">{{ $circle->name }}</option>
                        @endif
                    @endforeach
                </select>
            </list-view-form-group>
        @endunless
        <list-view-form-group label-for="contact_body">
            <template v-slot:label>お問い合わせ内容</template>
            <template v-slot:description>確認のため、お問い合わせ内容をメールで送信いたします。</template>
            <textarea name="contact_body" id="contact_body" class="form-control {{ $errors->has('contact_body') ? 'is-invalid' : '' }}" rows="10" required>{{ old('contact_body') }}</textarea>

            @if ($errors->has('contact_body'))
                <template v-slot:invalid>
                @foreach ($errors->get('contact_body') as $message)
                    {{ $message }}<br>
                @endforeach
                </template>
            @endif
        </list-view-form-group>
    </list-view>

    <div class="container text-center pt-spacing-md">
        <button type="submit" class="btn is-primary is-wide">送信</button>
    </div>
</form>
@endsection
