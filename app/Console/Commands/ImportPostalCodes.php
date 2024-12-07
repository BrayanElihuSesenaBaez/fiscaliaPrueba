<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PostalCodeImport;

class ImportPostalCodes extends Command
{
    protected $signature = 'import:postalcodes {file}';
    protected $description = 'Importar códigos postales desde un archivo Excel.';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("El archivo especificado no existe: $file");
            return;
        }

        $this->clearOldData();

        $this->info("Importando archivo: $file");
        try {
            Excel::import(new PostalCodeImport, $file);
            $this->info("Importación completada.");
        } catch (\Exception $e) {
            $this->error("Error al importar $file: " . $e->getMessage());
        }
    }

    private function clearOldData()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('cities')->truncate();
        \DB::table('settlement_types')->truncate();
        \DB::table('settlements')->truncate();
        \DB::table('zip_codes')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $this->info("Tablas de ciudades, tipos de asentamientos, asentamientos y códigos postales limpiadas.");
    }

}




