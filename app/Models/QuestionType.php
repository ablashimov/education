<?php

namespace App\Models;

use App\Enums\QuestionTypeEnum;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionType withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [
        'slug' => QuestionTypeEnum::class,
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
