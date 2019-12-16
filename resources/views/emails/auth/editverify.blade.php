@component('mail::message')
# メール認証のお願い

{{ $userName  }} 様

「{{ config('app.name') }}」にて、ユーザー情報が変更されました。

ユーザー情報の変更手続きを完了するには、以下のボタンをクリックしてください。

@component('mail::button', ['url' => $verifyUrl, 'color' => 'primary'])
認証する（ログイン不要）
@endcomponent

@component('mail::panel')
本メールに心当たりがない場合、そのままメールを破棄してください。
@endcomponent
@endcomponent
