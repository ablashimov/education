<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $exam_instance_id
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon $submitted_at
 * @property int $elapsed_seconds
 * @property int|null $score
 * @property int|null $graded_by
 * @property array<array-key, mixed> $client_info
 * @property string $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExamAnswer> $answers
 * @property-read int|null $answers_count
 * @property-read \App\Models\User|null $gradedBy
 * @property-read \App\Models\ExamInstance $instance
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereClientInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereElapsedSeconds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereExamInstanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereGradedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAttempt withoutTrashed()
 * @property-read int $correct_answers_count
 * @property-read string $result_status
 * @property-read string $time_spent
 * @property-read int $total_questions
 * @mixin \Eloquent
 */
class ExamAttempt extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'exam_instance_id',
        'started_at',
        'submitted_at',
        'elapsed_seconds',
        'score',
        'graded_by',
        'client_info',
        'ip',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'elapsed_seconds' => 'integer',
        'score' => 'integer',
        'client_info' => 'array',
    ];

    public function instance(): BelongsTo
    {
        return $this->belongsTo(ExamInstance::class, 'exam_instance_id');
    }

    public function gradedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class, 'exam_attempt_id');
    }

    public function isPassing(): bool
    {
        $passingScore = $this->instance->assignment->exam->passing_score ?? 70;

        return $this->score >= $passingScore;
    }

    public function getCorrectAnswersCountAttribute(): int
    {
        return $this->answers()->where('is_correct', true)->count();
    }
}
