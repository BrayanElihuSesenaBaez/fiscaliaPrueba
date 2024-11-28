<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'state_id'];


    // Relación con el modelo State
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function zipCodes()
    {
        return $this->hasMany(ZipCode::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
