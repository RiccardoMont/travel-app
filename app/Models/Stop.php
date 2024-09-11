<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stop extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'description', 'rating', 'lat', 'lng', 'date_and_hour', 'checked', 'user_id', 'trip_id', 'status_id'];

    public function trip() : BelongsTo
    {

        return $this->belongsTo(Trip::class);

    }
    public function status() : BelongsTo
    {

        return $this->belongsTo(Status::class);

    }
}
