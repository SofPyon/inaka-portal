@extends('layouts.single_column')

@section('title', 'メール認証のお願い - ' . config('app.name'))

@section('main')
    <div class="card mb-3">
        <div class="card-header">メール認証のお願い</div>
        <div class="card-body">
            <p class="text-center text-danger lead">
                <strong>{{ Auth::user()->is_verified ? 'まだユーザー情報の変更は完了していません！' : 'まだユーザー登録は完了していません！' }}</strong>
            </p>
            <p>以下のメールアドレスに確認メールを送信しました。<strong>メール送信から {{ config('auth.verification.expire', 60) }} 分以内に、</strong>確認メールに記載されている URL にアクセスしてください。</p>

            <div class="row">
                {{-- 大学提供メールアドレス --}}
                <div class="col-sm-6 pr-sm-2">
                    <div class="card mb-3 mb-sm-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ Auth::user()->univemail }}</h5>
                            @if (Auth::user()->hasVerifiedUnivemail())
                                <p class="card-text text-success">
                                    <i class="fas fa-check"></i>
                                    認証完了
                                </p>
                            @else
                                <p class="card-text text-danger">
                                    <i class="fas fa-exclamation-circle"></i>
                                    メールを確認してください
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- 連絡先メールアドレス --}}
                @if (Auth::user()->email !== Auth::user()->univemail)
                    <div class="col-sm-6 pl-sm-2">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ Auth::user()->email }}</h5>
                                @if (Auth::user()->hasVerifiedEmail())
                                    <p class="card-text text-success">
                                        <i class="fas fa-check"></i>
                                        認証完了
                                    </p>
                                @else
                                    <p class="card-text text-danger">
                                        <i class="fas fa-exclamation-circle"></i>
                                        メールを確認してください
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">確認メールの再送</div>
        <div class="card-body">
            <p>確認メールが見つからない場合・確認メールの URL にアクセスするとエラーになる場合、以下のボタンより確認メールを再送できます。</p>
            <form action="{{ route('verification.resend') }}" method="post">
                @csrf
                <button class="btn btn-primary">
                    確認メールを再送
                </button>
            </form>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">誤った情報でユーザー登録してしまった場合</div>
        <div class="card-body">
            <p>
                <a href="{{ route('user.edit') }}" class="btn btn-primary" role="button" target="_blank">登録情報の変更</a>
                <a href="{{ route('change_password') }}" class="btn btn-primary" role="button" target="_blank">パスワードの変更</a>
                <a href="{{ route('user.delete') }}" class="btn btn-danger">アカウントの削除</a>
            </p>
        </div>
    </div>
@endsection
