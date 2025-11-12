<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $group_id
 * @property int $exam_id
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Exam $exam
 * @property-read \App\Models\Group $group
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupExamSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupExamSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupExamSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupExamSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupExamSchedule whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupExamSchedule whereExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupExamSchedule whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupExamSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupExamSchedule whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupExamSchedule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GroupExamSchedule extends Model
{
    protected $fillable = [
        'group_id',
        'exam_id',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
//
//    public function examAssignments(): HasMany
//    {
//        return $this->hasMany(ExamAssignment::class, 'exam_schedule_id');
//    }
}
