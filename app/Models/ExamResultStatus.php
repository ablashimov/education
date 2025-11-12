<?php

namespace App\Models;

use App\Enums\ExamResultStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamResultStatus withoutTrashed()
 * @mixin \Eloquent
 */
class ExamResultStatus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [
        'slug' => ExamResultStatusEnum::class,
    ];
}
