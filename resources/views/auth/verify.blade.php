@extends('layouts.single_column')

@section('main')
    <div class="card mb-3">
        <div class="card-header">メール認証のお願い</div>
        <div class="card-body">
            <p class="text-center text-danger lead">
                まだユーザー登録は完了していません！
            </p>
            <p>以下のメールアドレスに確認メールを送信しました。<strong>メール送信から {{ config('auth.verification.expire', 60) }} 分以内に、</strong>確認メールに記載されている URL にアクセスしてください。</p>

            <hr>

            <p><strong class="text-danger">認証が完了していないメールアドレス一覧 :</strong></p>
            <ul>
                @unless (Auth::user()->hasVerifiedEmail())
                    <li>{{ Auth::user()->email }}</li>
                @endunless
                @unless (Auth::user()->hasVerifiedUnivemail())
                    <li>{{ Auth::user()->univemail }}</li>
                @endunless
            </ul>

            <hr>

            <p><strong class="text-success">認証が完了したメールアドレス一覧 :</strong></p>
            <ul>
                @if (Auth::user()->hasVerifiedEmail())
                    <li>{{ Auth::user()->email }}</li>
                @endif
                @if (Auth::user()->hasVerifiedUnivemail() && Auth::user()->email !== Auth::user()->univemail)
                    <li>{{ Auth::user()->univemail }}</li>
                @endif
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-header">確認メールが見つからない場合・確認メールの URL にアクセスするとエラーになる場合</div>
        <div class="card-body">
            <p>確認メールを再送するには、以下のボタンを選んでください。</p>
            <form action="{{ route('verification.resend') }}" method="post">
                @csrf
                <button class="btn btn-primary">
                    確認メールを再送する
                </button>
            </form>
        </div>
    </div>
@endsection
