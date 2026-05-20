<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\eqpuipement;
use App\Models\site;
use Illuminate\Http\Request;


class EqpuipementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */

    public function getSites()
{
    // selectionner les sites
       // Assurez-vous d'ajouter la clé primaire (souvent 'id')
            $sites = site::select('id', 'nom_site') 
            ->get();

        return response()->json($sites);
}

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // recuperation de id site
        $id_s = DB::table('sites')
            ->select('id')
            ->where('nom_site', $request->siite)
            ->get();
        

        // insertion dans la table des sites
        DB::table('eqpuipements')->insert([
            'nom_eqpt'   => $request->nom_eqpt,
            'model'      => $request->model_eqpt,
            'cod_sit'    => $request->code_sit,
            'serial_num' => $request->num_seri,
            // On force la conversion en entier, ou null si c'est vide
            'id_site'    => is_numeric($request->id_site) ? (int)$request->id_site : null,
]);

        return response()->json(['message' => 'site créé avec succès']);
    }

    /**
     * Display the specified resource.
     */
    public function show(eqpuipement $eqpuipement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(eqpuipement $eqpuipement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, eqpuipement $eqpuipement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(eqpuipement $eqpuipement)
    {
        //
    }
}
