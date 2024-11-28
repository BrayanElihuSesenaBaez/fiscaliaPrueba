<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipality;
use App\Models\City;
use App\Models\ZipCode;
use App\Models\Settlement;
use App\Models\SettlementType;


class LocationController extends Controller{
    //
    public function getMunicipalities($stateId)
    {
        $municipalities = Municipality::where('state_id', $stateId)->get();
        return response()->json($municipalities);
    }


    public function getZipCodes($municipalityId)
    {
        $zipCodes = ZipCode::where('municipality_id', $municipalityId)->get();
        $cities = City::where('municipality_id', $municipalityId)->get();

        return response()->json([
            'zipCodes' => $zipCodes,
            'cities' => $cities
        ]);
    }

    public function getColonies($zipCode)
    {
        // Obtener colonias con el tipo de asentamiento cargado
        $settlements = Settlement::with('settlementType') // Aquí se carga la relación settlementType
        ->whereHas('zipCode', function($query) use ($zipCode) {
            $query->where('zip_code', $zipCode);
        })
            ->get();

        return response()->json([
            'settlements' => $settlements
        ]);
    }

}
