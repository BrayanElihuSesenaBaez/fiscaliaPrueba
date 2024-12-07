<?php

namespace App\Imports;

use App\Models\Municipality;
use App\Models\ZipCode;
use App\Models\Settlement;
use App\Models\SettlementType;
use App\Models\City;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithTitle;

class PostalCodeImport implements ToCollection, WithHeadingRow, WithTitle
{
    protected $sheetName;

    public function collection(Collection $collection)
    {

        if (!$this->sheetName) {
            $this->sheetName = 'Hoja Desconocida';
        }

        Log::info("Procesando hoja: {$this->sheetName}.");

        $municipalityCache = Municipality::with('state')->get()->keyBy(function ($municipality) {
            return strtolower(trim($municipality->name)) . '|' . strtolower(trim($municipality->state->name));
        });

        foreach ($collection as $row) {
            if (empty($row['d_codigo']) || empty($row['d_mnpio']) || empty($row['d_estado'])) {
                Log::warning('Fila inválida o incompleta', ['fila' => $row]);
                continue;
            }

            $codigoPostal = trim($row['d_codigo']);
            $municipio = strtolower(trim($row['d_mnpio']));
            $estadoOriginal = strtolower(trim($row['d_estado']));
            $estadoNormalizado = $this->normalizarEstado($estadoOriginal);
            $colonia = trim($row['d_asenta'] ?? '');
            $tipoAsentamiento = trim($row['d_tipo_asenta'] ?? '');
            $ciudad = trim($row['d_ciudad'] ?? '');

            if (empty($codigoPostal) || empty($municipio) || empty($estadoNormalizado)) {
                Log::warning('Fila inválida o incompleta tras la normalización.', ['fila' => $row]);
                continue;
            }

            $municipioKey = strtolower(trim($municipio)) . '|' . strtolower(trim($estadoNormalizado));
            $municipality = $municipalityCache[$municipioKey] ?? null;

            if (!$municipality) {
                Log::warning('Municipio no encontrado', [
                    'municipio' => $row['d_mnpio'],
                    'estado' => $row['d_estado']
                ]);
                continue;
            }

            $zipCode = ZipCode::firstOrCreate([
                'zip_code' => $codigoPostal,
                'municipality_id' => $municipality->id,
            ]);

            $settlementType = null;
            if (!empty($tipoAsentamiento)) {
                $settlementType = SettlementType::firstOrCreate(['type' => $tipoAsentamiento]);
            }

            if (!empty($colonia)) {
                Settlement::firstOrCreate([
                    'name' => $colonia,
                    'zip_code_id' => $zipCode->id,
                    'settlement_type_id' => $settlementType->id ?? null,
                ]);
            }

            if (!empty($ciudad)) {
                City::firstOrCreate([
                    'name' => $ciudad,
                    'municipality_id' => $municipality->id,
                ]);
            }
        }

        Log::info("Hoja procesada correctamente: {$this->sheetName}.");
    }

    private function normalizarEstado($nombreEstado)
    {
        $mapaEstados = [
            "México" => "Estado de México",
        ];

        return $mapaEstados[$nombreEstado] ?? $nombreEstado;
    }

    public function title(): string
    {
        return $this->sheetName ?? 'Hoja Desconocida';
    }
}















