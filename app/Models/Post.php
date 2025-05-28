<?php

// app/Models/Post.php
namespace App\Models;

use App\Enums\Status;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{

    use SoftDeletes, LogsActivity;
    
    /**
     * fillable
     *
     * @var array
     */

    protected $fillable = [
        'title',
        'content',
        'scheduled_time',
        'status',
        'scheduled_at',
        'published_at',
    ];


    /**
     * casts
     *
     * @var array
     */
    protected $casts = [
        'scheduled_time' => 'datetime',
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
        'status' => Status::class
    ];

    /**
     * @return BelongsTo
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'post_platform')
            ->withPivot('platform_status')
            ->withTimestamps();
    }


    /**
     * getActivitylogOptions
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'text']);
    }
}