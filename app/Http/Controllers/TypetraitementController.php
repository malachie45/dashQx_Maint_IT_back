<?php

namespace App\Http\Controllers;

use App\Models\typetraitement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypetraitementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //Insertion en base de données
        DB::table('typetraitements')->insert([
            'typ_trait' => $request->interv
        ]);

        return response()->json([

            'message' => 'Insertion réussie',

        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(typetraitement $typetraitement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(typetraitement $typetraitement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, typetraitement $typetraitement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(typetraitement $typetraitement)
    {
        //
    }
}
