<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property int $course_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExamAssignment> $examAssignments
 * @property-read int|null $exam_assignments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupExamSchedule> $examSchedules
 * @property-read int|null $exam_schedules_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereStartDate($value)
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserGroupInvite> $invites
 * @property-read int|null $invites_count
 * @mixin \Eloquent
 */
class Group extends Model
{
    protected $fillable = [
        'name',
        'course_id',
        'description',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $with = ['users'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_groups')->withPivot(['joined_at']);
    }

    public function examSchedule(): HasOne
    {
        return $this->hasOne(GroupExamSchedule::class);
    }

//    public function examSchedules(): HasMany
//    {
//        return $this->hasMany(GroupExamSchedule::class);
//    }

    public function invites(): HasMany
    {
        return $this->hasMany(UserGroupInvite::class);
    }

    public function invitedUsers(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserGroupInvite::class, 'group_id', 'id', 'id', 'user_id');
    }
    public function examAssignments(): HasMany
    {
        return $this->hasMany(ExamAssignment::class);
    }
}
