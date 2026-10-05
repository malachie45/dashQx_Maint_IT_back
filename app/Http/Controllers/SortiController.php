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
        // dd($request->all());

        // Validation complète
        $validated = $request->validate([
        'image' => 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:2048',
        'num_ord' => 'required|integer',
        'model' => 'required|string|max:255',
        'eqpt' => 'required|string|max:255',
        'traitement' => 'required|string|max:255',
        'dateDebut' => 'required|date',
        'datesorti' => 'required|date',
        'codeSite' => 'required|string|max:100',
        'numeroSerie' => 'required|string|max:255|unique:sortis,serial_num',
        'motifentre' => 'required|string',
        'statut' => 'required|string|max:100',
        'origine' => 'required|string|max:100',
        ]);

        // Upload image
        $cheminImage = null;

        if ($request->hasFile('image')) {

            $cheminImage = $request
                ->file('image')
                ->store('images', 'public');
        }

        // Insertion
        DB::table('sortis')->insert([
        'model' => $validated['model'],
        'sit' => $validated['origine'],
        'eqpt' => $validated['eqpt'],
        'date_sorti' => $validated['datesorti'],
        'date_entree' => $validated['dateDebut'],
        'cod_sit' => $validated['codeSite'],
        'serial_num' => $validated['numeroSerie'],
        'observ' => $validated['traitement'],
        'statut' => $validated['statut'],
        'motifentree' => $validated['motifentre'],
        'id_eqpt' => $validated['num_ord'],
        'image' => $cheminImage,
        // 'id_site' => $validated['id_sit'],
        // 'id_eqpt' => $validated['id_eqpt'],
        ]);

        return response()->json([
            'message' => 'Insertion réussie',
            'image' => $cheminImage
        ], 201);

        //RECHERCHE DANS TABLE ENTREE L'EQPT SORTI POUR CHANGER LE ENCOURS EN TRAITÉ
        
        DB::table('entrees as e')
            ->join('sortis as s', function ($join) {
                $join->on('e.id_eqpt', '=', 's.id_eqpt')
                    ->on('e.serial_num', '=', 's.serial_num');
            })
            ->where('e.statut', 'en cours')
            ->update([
                'e.statut' => 'traité'
            ]);

             return response()->json([
            'message' => 'Insertion réussie',
        ], 201);

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
