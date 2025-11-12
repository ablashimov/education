<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $question_id
 * @property string $text
 * @property bool $correct
 * @property int $scoring
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $order
 * @property-read \App\Models\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice whereCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice whereScoring($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionChoice withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionChoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'question_id',
        'text',
        'correct',
    ];

    protected $casts = [
        'correct' => 'boolean',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
