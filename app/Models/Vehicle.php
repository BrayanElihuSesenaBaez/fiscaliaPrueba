<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'marca_vehiculo_id',
        'procedenciaVehiculo',
        'estadoPlaca',
        'numeroSerie',
        'tipoVehiculo',
        'placa',
        'marca',
        'modelo',
        'NRPV',
        'placaPermiso',
        'submarca',
        'color',
        'tipoUso',
        'placaExtranjera',
        'numeroMotor',
        'clase',
        'aseguradora',
        'señasParticulares'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
