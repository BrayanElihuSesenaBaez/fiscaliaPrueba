<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcategory;

class SubcategoryController extends Controller{

    //Obtiene las subcategorias de acuerdo a la categoria seleccionada
    public function getSubcategories($categoryId){

        // Obtiene todas las subcategorias que pertenecen a la categoria seleccionada
        $subcategories = Subcategory::where('category_id', $categoryId)->get();

        //Retorna las subcategorias en formato JSON
        return response()->json($subcategories);
    }
}


