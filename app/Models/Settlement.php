<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'zip_code_id', 'settlement_type_id'];

    public function zipCode()
    {
        return $this->belongsTo(ZipCode::class, 'zip_code_id'); // Relación con ZipCode
    }


    public function settlementType()
    {
        return $this->belongsTo(SettlementType::class, 'settlement_type_id');
    }
}
