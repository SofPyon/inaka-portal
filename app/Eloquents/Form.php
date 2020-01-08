<?php

namespace App\Eloquents;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon $open_at
 * @property Carbon $close_at
 * @property int $created_by
 * @property string $type
 * @property int $max_answers
 * @property bool $is_public
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Collection $questions
 */
class Form extends Model
{
    protected $fillable = [
        'name',
        'description',
        'open_at',
        'close_at',
        'type',
        'max_answers',
        'is_public',
    ];

    protected $dates = [
        'open_at', 'close_at',
    ];

    protected $casts = [
        'max_answers' => 'int',
        'is_public' => 'bool',
    ];

    /**
     * 公開中のものを取得
     */
    public function scopeIsPublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * 受付終了時刻の早い順で並び替え
     */
    public function scopeCloseOrder($query, $direction = 'asc')
    {
        return $query->orderBy('close_at', $direction);
    }

    /**
     * 現時点で受付中のもの
     */
    public function scopeNowOpend($query)
    {
        $now = new CarbonImmutable();
        return $query->where('open_at', '<=', $now)->where('close_at', '>=', $now);
    }

    /**
     * 現時点で受付終了しているもの
     */
    public function scopeNowClosed($query)
    {
        $now = new CarbonImmutable();
        return $query->where('close_at', '<', $now);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answered(Circle $circle)
    {
        $answer = Answer::where('form_id', $this->id)->where('circle_id', $circle->id)->first();
        return !empty($answer);
    }
}
