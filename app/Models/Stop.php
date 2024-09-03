<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stop extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'description', 'rating', 'lat', 'lng', 'date_and_hour', 'checked', 'trip_id'];

    public function trip() : BelongsTo
    {

        return $this->belongsTo(Trip::class);

    }
}
