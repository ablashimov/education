<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumCategory extends Model
{
    use Sluggable;

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'title']];
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'order',
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(ForumTopic::class);
    }
}
