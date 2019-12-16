<?php

declare(strict_types=1);

namespace App\Services\Emails;

use App\Eloquents\Email;

class SendEmailService
{
    private const NUMBERS_PER_EXECUTE = 60; // 1回の処理で取得するメールレコード数
    private const SEND_INTERVAL_SEC = 1; // メール送信間隔(秒)
    private const SEC_PER_JOB = 60; // プログラム強制終了まで
    private const NUM_RETRY_PER_EMAIL_ADDRESS = 3; // 送信失敗した場合，リトライする回数
    private const NUM_RETRY_PER_JOB = 10; // １回のジョブで繰り返す回数

    public function enqueue()
    {
        for ($i = 0; $i < 10; ++$i) {
            $email = new Email();
            $email->subject = "件名";
            // ...
            $email->save();
        }
    }

    public function runJob()
    {
        $start_time = now(); // 開始時刻(UNIXエポック) (秒)

        // 今期失敗回数
        // (この関数が呼び出されて以降失敗した回数)
        $count_failed_now = 0;

        $emails = Email::orderBy('id', 'ASC')
                            ->where('is_locked', false) // 排他ロックされていない
                            ->where('is_sent', false)   // かつ，未送信
                            ->where('count_failed', '<', self::NUM_RETRY_PER_EMAIL_ADDRESS) // かつ，リトライ上限に達していないレコード
                            ->take(self::NUMBERS_PER_EXECUTE)
                            ->get();           // 最新 self::NUMBERS_PER_EXECUTE 件を取得
        foreach ($emails as $email) {
            // ロック処理
            $email->is_locked = true;
            $email->save();

            try {
                // ...何らかの送信処理...

                // 送信済みフラグセット
                $email->is_sent = true;
                $email->save();
            } catch (Exception $e) {
                // 送信失敗したので失敗カウントを1つ追加
                ++$email->count_failed;
                ++$count_failed_now;

                // TODO: エラーの内容をログに残せたら良さそう

                // ロック解除
                $email->is_locked = false;
                $email->save();

                // ...今度CRONが起動したらやり直す
            }

            // 現在実行中の runJob で、失敗回数が self::NUM_RETRY_PER_JOB 回を超えたら
            // サーバー側の設定ミスなどが考えられるので、処理を中止する
            if ($count_failed_now > self::NUM_RETRY_PER_JOB) {
                // ...管理者にメールするなりログに書き込むなりする...

                // とりあえず強制終了
                break;
            }

            // 強制終了するか否か
            if (now() - $start_time > self::SEC_PER_JOB) {
                break;
            }

            // スリープ
            sleep(self::SEND_INTERVAL_SEC);
        }
    }
}
