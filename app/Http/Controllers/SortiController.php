<?php

namespace App\Http\Controllers;

use App\Models\sorti;
use App\Models\entree;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SortiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function rechercher(Request $request)
{
    $resultat = DB::table('sortis')
                    ->where('cod_sit', $request->recherch)
                    ->orWhere('serial_num', $request->recherch)
                    ->get();

    if ($resultat->isEmpty()) {
        return response()->json([
            'message' => 'Equipement inexistant'
        ], 404);
    }

    return response()->json([
        'data' => $resultat
    ], 200);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(sorti $sorti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sorti $sorti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sorti $sorti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sorti $sorti)
    {
        //
    }
}
