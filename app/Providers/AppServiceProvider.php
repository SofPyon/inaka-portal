<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // スタッフページかどうかを Blade 上で判断できるようにする
        // @staffpage 〜 @endstaffpage
        // の中は、スタッフページの場合のみ表示される
        Blade::if('staffpage', function () {
            return strpos(request()->path(), 'staff') !== 0;
        });

        // 渡された引数の文字列をMarkdownとして解釈し、
        // HTMLに変換した文字列を表示する
        Blade::directive('markdown', function ($expression) {
            return "<?php echo App\Services\Utils\ParseMarkdownService::render($expression); ?>";
        });

        // 渡された引数の文字列を先頭100文字のみのこし、
        // 残りを「...」で省略する
        Blade::directive('description', function ($expression) {
            return "<?php echo e(App\Services\Utils\TrimmedDescriptionService::generate($expression)); ?>";
        });
    }
}
