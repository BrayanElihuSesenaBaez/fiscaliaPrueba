<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcategory;

class SubcategoryController extends Controller{

    public function getSubcategories($categoryId){

        $subcategories = Subcategory::where('category_id', $categoryId)->get();

        return response()->json($subcategories);
    }
}


