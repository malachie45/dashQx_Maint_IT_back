<?php

namespace App\Http\Controllers;

use App\Models\entree;
use App\Models\site;
use App\Models\eqpuipement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function getSitesEnt()
            {
                // selectionner les sites
                // Assurez-vous d'ajouter la clé primaire (souvent 'id')
                        $sites = site::select('id', 'nom_site') 
                        ->get();

                    return response()->json($sites);
            }

    public function getEqpt(){

    // selectionner les equipements
       
            $id_eqpt = eqpuipement::select('id', 'nom_eqpt') 
            ->get();

        return response()->json($id_eqpt);

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
    public function show(entree $entree)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(entree $entree)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, entree $entree)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(entree $entree)
    {
        //
    }
}
