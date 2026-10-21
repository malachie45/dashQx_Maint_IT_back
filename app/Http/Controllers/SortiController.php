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

    // Upload de l'image
    $cheminImage = $request->file('image')
        ->store('images', 'public');

    // Enregistrement de la sortie et mise à jour de l'entrée
    $sortie = DB::transaction(function () use ($validated, $cheminImage) {

        // 1. Rechercher l'entrée correspondante
        $entree = DB::table('entrees')
            ->where('serial_num', $validated['numeroSerie'])
            ->where('cod_sit', $validated['codeSite'])
            ->whereDate('date_entree', $validated['dateDebut'])
            ->orderByDesc('id')
            ->lockForUpdate()
            ->first();

        if (!$entree) {
            throw ValidationException::withMessages([
                'numeroSerie' =>
                    "Aucune entrée correspondante n'a été trouvée."
            ]);
        }

        // 2. Enregistrer la sortie
        $idSortie = DB::table('sortis')->insertGetId([
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
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Actualiser le statut de l'entrée correspondante
        DB::table('entrees')
            ->where('id', $entree->id)
            ->update([
                'statut' => $validated['statut'],
                'updated_at' => now(),
            ]);

        return $idSortie;
    });

    return response()->json([
        'message' => 'Sortie enregistrée et statut de l’entrée actualisé.',
        'id_sortie' => $sortie,
        'statut' => $validated['statut'],
        'image' => $cheminImage,
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
