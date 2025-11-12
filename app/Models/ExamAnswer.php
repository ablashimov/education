<?php

namespace App\Models;

use Illuminate\Console\View\Components\Choice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $exam_attempt_id
 * @property int $question_id
 * @property int|null $question_choice_id
 * @property string|null $answer
 * @property bool $is_correct
 * @property int|null $graded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ExamAttempt $attempt
 * @property-read \App\Models\QuestionChoice|null $choice
 * @property-read \App\Models\User|null $gradedBy
 * @property-read \App\Models\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer whereExamAttemptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer whereGradedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer whereIsCorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer whereQuestionChoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAnswer withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnswerChoice> $choices
 * @property-read int|null $choices_count
 * @mixin \Eloquent
 */
class ExamAnswer extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'exam_attempt_id',
        'question_id',
        'question_choice_id',
        'answer',
        'is_correct',
        'graded_by',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'question_choice_id' => 'array',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class, 'exam_attempt_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function choices(): HasMany
    {
        return $this->hasMany(AnswerChoice::class);
    }

    public function gradedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}
