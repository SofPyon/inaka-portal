@extends('layouts.single_column')

@section('title', 'お問い合わせ - ' . config('app.name'))

@section('main')
<div class="card">
    <p class="card-header">お問い合わせ</p>
    <div class="card-body">
        <form class="form-content" method="post" action="{{ isset($circle) ? route('contacts.post', ['circle' => $circle]) : route('contacts.post') }}">
            @csrf
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex">
                    名前
                    <span class="ml-auto">{{ Auth::user()->name }}</span>
                </li>
                <li class="list-group-item d-flex">
                    学籍番号
                    <span class="ml-auto">{{ Auth::user()->student_id }}</span>
                </li>
                <li class="list-group-item d-flex">
                    メールアドレス
                    <span class="ml-auto">{{ Auth::user()->email }}</span>
                </li>
                @if (isset($circle))
                    <li class="list-group-item d-flex">
                        団体名
                        <span class="ml-auto">{{ $circle->name }}</span>
                    </li>
                @endif
                <li class="list-group-item">
                    <div class="form-group">
                        <label for="contact-body">お問い合わせ内容</label>
                        <textarea name="contact-body" id="contact-body" class="form-control {{ $errors->has('contact-body') ? 'is-invalid' : '' }}" rows="5" required>{{ old('contact-body') }}</textarea>
                        @if ($errors->has('contact-body'))
                            <div class="invalid-feedback">
                                @foreach ($errors->get('contact-body') as $message)
                                    {{ $message }}
                                @endforeach
                            </div>
                        @endif
                    </div>
                </li>
            </ul>
            <small class="form-text text-muted">確認のためお問い合わせ内容をメールで送信いたします。</small>
            <div class="d-flex mt-2">
                <button type="submit" class="btn btn-primary">送信</button>
                <a href="{{ route('home') }}" class="btn btn-light ml-2" role="button">キャンセル</a>
            </div>
        </form>
    </div>
</div>

@endsection