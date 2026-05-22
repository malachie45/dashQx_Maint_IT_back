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
    // Vérification image
    $request->validate([
        'fichier' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
    ]);

    // Upload image
    $cheminImage = null;

    if ($request->hasFile('fichier')) {

        // stocke dans storage/app/public/images
        $cheminImage = $request->file('fichier')->store('images', 'public');
    }

    // insertion dans la table
    DB::table('entrees')->insert([
        'model' => $request->model,
        'date_entree' => $request->dateEntree,
        'date_deb_trait' => $request->dateDebut,
        'cod_sit' => $request->codeSite,
        'serial_num' => $request->numeroSerie,
        'motif' => $request->motif,
        'statut' => $request->statut,

        // chemin enregistré en base
        'image' => $cheminImage,

        'id_site' => is_numeric($request->id_sit)
            ? (int)$request->id_sit
            : null,

        'id_eqpt' => is_numeric($request->id_eqpt)
            ? (int)$request->id_eqpt
            : null,
    ]);
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
