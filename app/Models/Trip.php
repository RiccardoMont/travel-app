<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'start', 'end', 'description', 'price', 'public', 'status_id'];

    public function status() : BelongsTo
    {

        return $this->belongsTo(Status::class);

    }

    public function stops(): BelongsToMany
    {

        return $this->belongsToMany(Stop::class);

    }

}
