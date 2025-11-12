<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string|null $fileable_type
 * @property int|null $fileable_id
 * @property string|null $path
 * @property string|null $name
 * @property string|null $mime_type
 * @property string|null $size
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|File newModelQuery()
 * @method static Builder|File newQuery()
 * @method static Builder|File query()
 * @method static Builder|File whereCreatedAt($value)
 * @method static Builder|File whereDescription($value)
 * @method static Builder|File whereFileableId($value)
 * @method static Builder|File whereFileableType($value)
 * @method static Builder|File whereId($value)
 * @method static Builder|File whereMimeType($value)
 * @method static Builder|File whereName($value)
 * @method static Builder|File wherePath($value)
 * @method static Builder|File whereSize($value)
 * @method static Builder|File whereUpdatedAt($value)
 * @property-read string|null $path_url
 * @property string|null $fileable_tag
 * @method static Builder|File whereFileableTag($value)
 * @property-read Model|\Eloquent|null $fileable
 * @mixin \Eloquent
 */
class File extends Model
{
    protected $fillable = [
        'fileable_type',
        'fileable_id',
        'fileable_tag',
        'path',
        'name',
        'size',
        'mime_type',
        'description',
    ];

    protected static function booted()
    {
        static::deleting(function (File $file) {
            if ($file->path && Storage::disk(config('filesystems.default'))->exists($file->path)) {
                Storage::disk(config('filesystems.default'))->delete($file->path);
            }
        });
    }
    protected $appends = ['path_url'];

    public function getPathUrlAttribute(): ?string
    {
        return !empty($this->path)
            ? Storage::disk(config('filesystems.default'))->url($this->path)
            : null;
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
