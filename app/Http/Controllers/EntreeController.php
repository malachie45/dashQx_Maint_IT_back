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
    // Validation complète
    $validated = $request->validate([
        'fichier' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',

        'model' => 'required|string|max:255',
        'dateEntree' => 'required|date',
        'dateDebut' => 'required|date',
        'codeSite' => 'required|string|max:100',
        'numeroSerie' => 'required|string|max:255|unique:entrees,serial_num',
        'motif' => 'required|string',
        'statut' => 'required|string|max:100',

        'id_sit' => 'required|integer',
        'id_eqpt' => 'required|integer',
    ]);

    // Upload image
    $cheminImage = null;

    if ($request->hasFile('fichier')) {

        $cheminImage = $request
            ->file('fichier')
            ->store('images', 'public');
    }

    // Insertion
    DB::table('entrees')->insert([

        'model' => $validated['model'],
        'date_entree' => $validated['dateEntree'],
        'date_deb_trait' => $validated['dateDebut'],
        'cod_sit' => $validated['codeSite'],
        'serial_num' => $validated['numeroSerie'],
        'motif' => $validated['motif'],
        'statut' => $validated['statut'],

        'image' => $cheminImage,

        'id_site' => $validated['id_site'],
        'id_eqpt' => $validated['id_eqpt'],
    ]);

    return response()->json([
        'message' => 'Insertion réussie',
        'image' => $cheminImage
    ], 201);
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
