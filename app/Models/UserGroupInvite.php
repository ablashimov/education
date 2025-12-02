<?php

namespace App\Models;

use App\Observers\UserGroupInviteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $group_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $invited_at
 * @property \Illuminate\Support\Carbon|null $accepted_at
 * @property-read \App\Models\Group $group
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGroupInvite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGroupInvite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGroupInvite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGroupInvite whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGroupInvite whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGroupInvite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGroupInvite whereInvitedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserGroupInvite whereUserId($value)
 * @mixin \Eloquent
 */
#[ObservedBy([UserGroupInviteObserver::class])]
class UserGroupInvite extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'group_id',
        'user_id',
        'invited_at',
        'accepted_at',
    ];

    protected $casts = [
        'invited_at' => 'date',
        'accepted_at' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
