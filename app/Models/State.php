<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    // Relación con el modelo Municipality
    public function municipalities(){
        return $this->hasMany(Municipality::class);
    }

}
