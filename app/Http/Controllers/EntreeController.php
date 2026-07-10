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
       
            $id_eqpt = DB::table('eqpuipements')
        ->select(
            DB::raw('MIN(id) as id'),
            'nom_eqpt'
        )
        ->groupBy('nom_eqpt')
        ->orderBy('nom_eqpt', 'asc')
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
        'fichier' => 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:2048',

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

        'id_site' => $validated['id_sit'],
        'id_eqpt' => $validated['id_eqpt'],
    ]);

    return response()->json([
        'message' => 'Insertion réussie',
        'image' => $cheminImage
    ], 201);
}


// rechercher l'équipement à sortir

public function recherche(Request $request)
{
    // Validation
     $validated = $request->validate([
        'recherch' => 'required|string|max:255',
    ]); 

    $recherch = $request->recherch;

    // Recherche
    $reche = DB::table('entrees')
    ->join('sites', 'entrees.id_site', '=', 'sites.id')
    ->join('eqpuipements', 'entrees.id_eqpt', '=', 'eqpuipements.id')
    ->select(
        'entrees.model',
        'entrees.date_entree',
        'entrees.date_deb_trait',
        'entrees.cod_sit',
        'entrees.serial_num',
        'entrees.motif',
        'entrees.id_eqpt',
        'eqpuipements.nom_eqpt',
        'sites.nom_site'
    )
    ->where(function ($query) use ($recherch) {
        $query->where('entrees.cod_sit', $recherch)
              ->orWhere('entrees.serial_num', $recherch);
    })
    ->first();

    if (!$reche) {
        return response()->json([
            'message' => 'Aucune entrée trouvé'
        ], 404);
    }

    return response()->json($reche);
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

    // bilan par statut equipements

  public function bilanEquipements(Request $request)
{
    $dateDebut = $request->date_debut;
    $dateFin   = $request->date_fin;

    $bilan = DB::table('eqpuipements as e')

        ->leftJoin('entrees as en', function ($join) use ($dateDebut, $dateFin) {

            $join->on('e.id', '=', 'en.id_eqpt');

            if ($dateDebut) {
                $join->whereDate('en.date_entree', '>=', $dateDebut);
            }

            if ($dateFin) {
                $join->whereDate('en.date_entree', '<=', $dateFin);
            }
        })

        ->select(

            'e.id',
            'e.nom_eqpt',

            DB::raw('COUNT(en.id) as total_entrees'),

            DB::raw("
                SUM(
                    CASE
                        WHEN en.statut='resolu'
                        THEN 1 ELSE 0
                    END
                ) as resolus
            "),

            DB::raw("
                SUM(
                    CASE
                        WHEN en.statut='en cours'
                        THEN 1 ELSE 0
                    END
                ) as en_cours
            "),

            DB::raw("
                SUM(
                    CASE
                        WHEN en.statut='irrecuperable'
                        THEN 1 ELSE 0
                    END
                ) as irrecuperables
            "),

            DB::raw("
                ROUND(
                    (
                        SUM(
                            CASE
                                WHEN en.statut='resolu'
                                THEN 1 ELSE 0
                            END
                        ) /
                        NULLIF(COUNT(en.id),0)
                    )*100,2
                ) as taux_resolution
            ")

        )

        ->groupBy('e.id','e.nom_eqpt')

        ->orderBy('e.nom_eqpt')

        ->get();

    return response()->json($bilan);
}
}
