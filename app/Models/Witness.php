<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Witness extends Model
{
    use HasFactory;

    protected $fillable = ['report_id', 'full_name', 'phone', 'relationship', 'incident_description'];

    public function report() {
        return $this->belongsTo(Report::class);
    }
}
