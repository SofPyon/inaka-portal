<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Page extends Model
{
    /**
     * モデルの「初期起動」メソッド
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('updated_at', function (Builder $builder) {
            $builder->orderBy('updated_at', 'desc');
        });
    }

    public function getIsNewAttribute()
    {
        $moded_time = $this->created_at->add('3days');
        return $moded_time->gte(now());
    }

    public function getIsUpdatedAttribute()
    {
        $moded_time = $this->updated_at->add('3days');
        return $moded_time->gte(now()) && !$this->is_new;
    }
}
