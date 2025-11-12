<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $exam_id
 * @property int $group_id
 * @property int $user_id
 * @property int|null $exam_result_status_id
 * @property int $attempts_allowed
 * @property bool $is_control
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExamAttempt> $attempts
 * @property-read int|null $attempts_count
 * @property-read \App\Models\Exam $exam
 * @property-read \App\Models\Group $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExamInstance> $instances
 * @property-read int|null $instances_count
 * @property-read \App\Models\ExamResultStatus|null $resultStatus
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereAttemptsAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereExamResultStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereIsControl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExamAssignment withoutTrashed()
 * @mixin \Eloquent
 */
class ExamAssignment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'exam_id',
        'group_id',
        'user_id',
        'exam_result_status_id',
        'is_control',
        'attempts_allowed',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'attempts_allowed' => 'integer',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /**
     * Retrieve the model for a bound value.
     *
     * @param mixed $value
     * @param string|null $field
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $groupId = request()->route()->group->id;

        return $this->with(['resultStatus', 'instances.attempt'])
            ->where('group_id', $groupId)
            ->where('id', $value)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resultStatus(): BelongsTo
    {
        return $this->belongsTo(ExamResultStatus::class, 'exam_result_status_id');
    }

    public function instances(): HasMany
    {
        return $this->hasMany(ExamInstance::class, 'assignment_id');
    }

    public function attempts(): HasManyThrough
    {
        return $this->hasManyThrough(
            ExamAttempt::class,
            ExamInstance::class,
            'assignment_id',
            'exam_instance_id',
            'id',
            'id'
        );
    }
}
