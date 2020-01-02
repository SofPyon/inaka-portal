@extends('v2.layouts.app')

@section('title', 'お問い合わせ')

@section('content')
<main class="container">
    <form class="form" method="post" action="{{ route('contacts.post') }}">
        @csrf
            <div class="form-group">
                <p class="form-label">名前</p>
                {{ Auth::user()->name }}
            </div>
            <div class="form-group">
                <p class="form-label">学籍番号</p>
                {{ Auth::user()->student_id }}
            </div>
            <div class="form-group">
                <p class="form-label">メールアドレス</p>
                {{ Auth::user()->email }}
            </div>
            @unless (empty($circles))
                <div class="form-group">
                    <label class="form-label">団体名</label>
                    <select name="circle_id" class="form-control">
                        @foreach ($circles as $circle)
                            @if (!empty(old('circle_id')) && old('circle_id') === $circle->id)
                                <option value="{{ $circle->id }}" selected>{{ $circle->name }}</option>
                            @else
                                <option value="{{ $circle->id }}">{{ $circle->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if (count($circles) > 1)
                        <small class="form-text text-muted">どの団体としてお問い合わせするのか選択してください。</small>
                    @endif
                </div>
            @endunless
            <div class="form-group">
                <label class="form-label" for="contact-body">お問い合わせ内容</label>
                <textarea name="contact-body" id="contact-body" class="form-control {{ $errors->has('contact-body') ? 'is-invalid' : '' }}" rows="5" required>{{ old('contact-body') }}</textarea>
                @if ($errors->has('contact-body'))
                    <div class="invalid-feedback">
                        @foreach ($errors->get('contact-body') as $message)
                            {{ $message }}
                        @endforeach
                    </div>
                @endif
                <small class="form-text text-muted">確認のため、お問い合わせ内容をメールで送信いたします。</small>
            </div>
        <button type="submit" class="btn is-primary">送信</button>
    </form>
</main>
@endsection
