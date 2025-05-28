<?php

// app/Models/Platform.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{

    /**
     * fillable
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'type',
        'icon',
    ];

    /**
     * @return BelongsToMany
     */

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_platform')
            ->withPivot('platform_status')
            ->withTimestamps();
    }

}