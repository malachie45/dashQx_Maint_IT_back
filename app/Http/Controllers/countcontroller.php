<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\entree;
use App\Models\sorties;
use App\Models\mission;
use Illuminate\Http\Request;

class countcontroller extends Controller
{
    //

    public function statistiques()
{
    return response()->json([
        'nombre_entrees'  => DB::table('entrees')->count(),
        'nombre_sorties'  => DB::table('sortis')->count(),
        'nombre_missions' => DB::table('missions')->count(),
    ]);
}
}
