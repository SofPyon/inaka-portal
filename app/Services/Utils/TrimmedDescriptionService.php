<?php

declare(strict_types=1);

namespace App\Services\Utils;

class TrimmedDescriptionService
{
    public static function generate(string $text): string
    {
        return mb_strimwidth(strip_tags(ParseMarkdownService::render(mb_strimwidth($text, 0, 200))), 0, 100, "...");
    }
}
