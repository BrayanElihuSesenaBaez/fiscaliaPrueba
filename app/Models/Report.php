<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_date',
        'expedient_number',
        'last_name',
        'mother_last_name',
        'first_name',
        'institution_id',
        'other_institution',
        'rank',
        'unit',
        'description',
        'category_id',
        'subcategory_id',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

}

