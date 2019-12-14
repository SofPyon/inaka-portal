<?php

return [
    // ポータル管理者の組織名
    // ポータルを管理している実行委員会名などを指定します。
    'admin_name' => env('PORTAL_ADMIN_NAME'),
    // 連絡先メールアドレス
    // ここで設定したメールアドレスが、運営者の連絡先として表示されるほか、お問い合わせフォームの送信先として使用されます。
    'contact_email' => env('PORTAL_CONTACT_EMAIL'),
    // 大学提供メールアドレスのドメイン
    // @ より後ろの文字列を指定
    'univemail_domain' => env('PORTAL_UNIVEMAIL_DOMAIN'),
];
