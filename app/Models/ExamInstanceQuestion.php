<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $exam_instance_id
 * @property int $question_id
 * @property array<array-key, mixed> $choices
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ExamInstance $instance
 * @property-read \App\Models\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion whereChoices($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion whereExamInstanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion withoutTrashed()
 * @property string|null $text
 * @property string|null $correct
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion whereCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstanceQuestion whereText($value)
 * @mixin \Eloquent
 */
class ExamInstanceQuestion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'exam_instance_id',
        'question_id',
        'choices',
    ];

    protected $casts = [
        'choices' => 'array',
    ];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(ExamInstance::class, 'exam_instance_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
