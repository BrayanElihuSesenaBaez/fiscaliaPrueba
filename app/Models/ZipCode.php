<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    use HasFactory;

    protected $fillable = ['zip_code', 'municipality_id'];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'zip_code_id');
    }

}
