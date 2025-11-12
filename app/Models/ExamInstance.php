<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $assignment_id
 * @property int $user_id
 * @property int $attempt_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ExamAssignment|null $assignment
 * @property-read \App\Models\ExamAttempt|null $attempt
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExamInstanceQuestion> $instanceQuestions
 * @property-read int|null $instance_questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance whereAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance whereAttemptNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamInstance withoutTrashed()
 * @mixin \Eloquent
 */
class ExamInstance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'assignment_id',
        'user_id',
        'attempt_number',
    ];

    protected $casts = [
        'attempt_number' => 'integer',
    ];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(ExamAssignment::class, 'assignment_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function instanceQuestions(): HasMany
    {
        return $this->hasMany(ExamInstanceQuestion::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'exam_instance_questions');
    }

    public function attempt(): HasOne
    {
        return $this->hasOne(ExamAttempt::class);
    }
}
