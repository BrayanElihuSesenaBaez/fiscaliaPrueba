<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model{

    use HasFactory;

    //Se define la relación uno a muchos con el modelo Subcategory
    public function subcategories(){
        return $this->hasMany(Subcategory::class);
    }
}

