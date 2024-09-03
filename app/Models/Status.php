<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function trips(): BelongsToMany
    {

        return $this->belongsToMany(Trip::class);

    }
    
}
