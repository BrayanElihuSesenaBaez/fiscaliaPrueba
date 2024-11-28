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
        // Obtener el nombre de la hoja si no se pasa como argumento
        if (!$this->sheetName) {
            $this->sheetName = 'Hoja Desconocida'; // Nombre por defecto
        }

        Log::info("Procesando hoja: {$this->sheetName}.");

        // Cachear municipios para evitar múltiples consultas
        $municipalityCache = Municipality::with('state')->get()->keyBy(function ($municipality) {
            return strtolower(trim($municipality->name)) . '|' . strtolower(trim($municipality->state->name));
        });

        foreach ($collection as $row) {
            // Validación de datos esenciales (solo nos interesan ciertos campos)
            if (empty($row['d_codigo']) || empty($row['d_mnpio']) || empty($row['d_estado'])) {
                Log::warning('Fila inválida o incompleta', ['fila' => $row]);
                continue;
            }

            // Normalización y asignación de variables relevantes
            $codigoPostal = trim($row['d_codigo']);
            $municipio = strtolower(trim($row['d_mnpio']));
            $estadoOriginal = strtolower(trim($row['d_estado']));
            $estadoNormalizado = $this->normalizarEstado($estadoOriginal);
            $colonia = trim($row['d_asenta'] ?? '');
            $tipoAsentamiento = trim($row['d_tipo_asenta'] ?? '');
            $ciudad = trim($row['d_ciudad'] ?? '');

            // Validar nuevamente campos obligatorios después del trim
            if (empty($codigoPostal) || empty($municipio) || empty($estadoNormalizado)) {
                Log::warning('Fila inválida o incompleta tras la normalización.', ['fila' => $row]);
                continue;
            }

            // Buscar el municipio asociado usando una clave que combine el nombre del municipio y el estado
            $municipioKey = strtolower(trim($municipio)) . '|' . strtolower(trim($estadoNormalizado));
            $municipality = $municipalityCache[$municipioKey] ?? null;

            if (!$municipality) {
                Log::warning('Municipio no encontrado', [
                    'municipio' => $row['d_mnpio'],
                    'estado' => $row['d_estado']
                ]);
                continue;
            }

            // Verificar si el código postal ya existe
            $zipCode = ZipCode::firstOrCreate([
                'zip_code' => $codigoPostal,
                'municipality_id' => $municipality->id,
            ]);

            // Registrar el tipo de asentamiento (si aplica)
            $settlementType = null;
            if (!empty($tipoAsentamiento)) {
                $settlementType = SettlementType::firstOrCreate(['type' => $tipoAsentamiento]);
            }

            // Registrar el asentamiento (si existe nombre de asentamiento)
            if (!empty($colonia)) {
                Settlement::firstOrCreate([
                    'name' => $colonia,
                    'zip_code_id' => $zipCode->id,
                    'settlement_type_id' => $settlementType->id ?? null,
                ]);
            }

            // Verificar o registrar la ciudad/localidad (si existe)
            if (!empty($ciudad)) {
                City::firstOrCreate([
                    'name' => $ciudad,
                    'municipality_id' => $municipality->id,
                ]);
            }
        }

        // Log al final de cada hoja procesada
        Log::info("Hoja procesada correctamente: {$this->sheetName}.");
    }

    private function normalizarEstado($nombreEstado)
    {
        $mapaEstados = [
            "México" => "Estado de México",
        ];

        return $mapaEstados[$nombreEstado] ?? $nombreEstado;
    }

    // Obtener el nombre de la hoja (por defecto "Hoja Desconocida")
    public function title(): string
    {
        return $this->sheetName ?? 'Hoja Desconocida';
    }
}















