<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'start', 'end', 'description', 'price', 'public', 'status_id', 'user_id'];

    public function status() : BelongsTo
    {

        return $this->belongsTo(Status::class);

    }

    public function stops(): HasMany
    {

        return $this->hasMany(Stop::class);

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
