<?php

namespace App\Eloquents;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $form_id
 * @property-read Form $form
 * @property string $name
 * @property string $description
 * @property string $type
 * @property bool $is_required
 * @property int $number_min
 * @property int $number_max
 * @property string $allowed_types
 * @property array $allowed_types_array
 * @property int $max_size
 * @property int $max_width
 * @property int $max_height
 * @property int $min_width
 * @property int $min_height
 * @property int $priority
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Question extends Model
{
    protected $casts = [
        'is_required' => 'bool',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('priority', function (Builder $builder) {
            $builder->orderBy('priority', 'asc');
        });
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function getAllowedTypesArrayAttribute()
    {
        return explode('|', $this->allowed_types);
    }

    public function setAllowedTypesArrayAttribute(array $value)
    {
        $this->attributes['allowed_types'] = implode('|', $value);
    }
}