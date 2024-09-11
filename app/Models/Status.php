<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function trips(): HasMany
    {

        return $this->hasMany(Trip::class);

    }
    public function stops(): HasMany
    {
        return $this->hasMany(Stop::class);
    }
    
}
