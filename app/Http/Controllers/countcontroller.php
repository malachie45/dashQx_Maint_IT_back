<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\entree;
use App\Models\sorties;
use App\Models\mission;
use Illuminate\Http\Request;

class countcontroller extends Controller
{
    // ==============================
    // STATISTIQUES GENERALES
    // ==============================
    public function statistiques(Request $request)
    {
        $dateDebut = $request->dateDebut;
        $dateFin = $request->dateFin;

        return response()->json([

            'nombre_entrees' => DB::table('entrees')
                ->whereBetween('date_entree', [$dateDebut, $dateFin])
                ->count(),

            'nombre_sorties' => DB::table('sortis')
                ->whereBetween('date_sorti', [$dateDebut, $dateFin])
                ->count(),

            'nombre_missions' => DB::table('missions')
                ->whereBetween('dat_deb', [$dateDebut, $dateFin])
                ->count()

        ]);
    }


    // ==============================
    // ENTREES PAR EQUIPEMENT
    // ==============================
    public function entrees(Request $request)
    {
        $dateDebut = $request->dateDebut;
        $dateFin = $request->dateFin;

        $entreesParEquipement = DB::table('entrees')

            ->join(
                'eqpuipements',
                'entrees.id_eqpt',
                '=',
                'eqpuipements.id'
            )

            ->select(
                'eqpuipements.id',
                'eqpuipements.nom_eqpt',
                DB::raw('COUNT(entrees.id) as nombre_entrees')
            )

            ->whereBetween(
                'entrees.date_entree',
                [$dateDebut, $dateFin]
            )

            ->groupBy(
                'eqpuipements.id',
                'eqpuipements.nom_eqpt'
            )

            ->get();

        return response()->json($entreesParEquipement);
    }


    // ==============================
    // ENTREES / SORTIES PAR EQUIPEMENT
    // ==============================

public function bilanStatutEquipement(Request $request)

{
    $dateDebut = $request->dateDebut;
    $dateFin   = $request->dateFin;

    $entrees = DB::table('entrees')
        ->select(
            'id_eqpt',
            DB::raw("COUNT(*) AS total"),
            DB::raw("SUM(CASE WHEN statut = 'en cours' THEN 1 ELSE 0 END) AS en_cours"),
            DB::raw("SUM(CASE WHEN statut = 'rejeté' THEN 1 ELSE 0 END) AS rejetes"),
            
        )
        ->whereBetween('date_entree', [$dateDebut, $dateFin])
        ->groupBy('id_eqpt');

    $sorties = DB::table('sortis')
        ->select(
            'id_eqpt',
            DB::raw("SUM(CASE WHEN statut = 'resolu' THEN 1 ELSE 0 END) AS resolus"),
            DB::raw("SUM(CASE WHEN statut = 'rebut' THEN 1 ELSE 0 END) AS rebuts")
        )
        ->whereBetween('date_sorti', [$dateDebut, $dateFin])
        ->groupBy('id_eqpt');

    $bilan = DB::table('eqpuipements as e')
        ->leftJoinSub($entrees, 'en', function ($join) {
            $join->on('e.id', '=', 'en.id_eqpt');
        })
        ->leftJoinSub($sorties, 's', function ($join) {
            $join->on('e.id', '=', 's.id_eqpt');
        })
        ->select(
            'e.nom_eqpt',

            DB::raw('COALESCE(en.total,0) AS total_entrees'),

            DB::raw('COALESCE(en.en_cours,0) AS en_cours'),

            DB::raw('COALESCE(en.rejetes,0) AS rejetes'),

            DB::raw('COALESCE(s.resolus,0) AS resolus'),

            DB::raw('COALESCE(s.rebuts,0) AS rebuts'),

            DB::raw("
                ROUND(
                    COALESCE(s.resolus,0) * 100 /
                    NULLIF(COALESCE(en.total,0),0),
                    2
                ) AS taux_resolution
            ")
        )
        ->orderBy('e.nom_eqpt')
        ->get();

    return response()->json($bilan);
}


public function statistiquesEquipements(Request $request)
    {
        // $dateDebut = $request->dateDebut;
        // $dateFin = $request->dateFin;

        // $stats = DB::table('eqpuipements as e')

        //     ->leftJoin('entrees as en', function ($join) use ($dateDebut, $dateFin) {

        //         $join->on('e.id', '=', 'en.id_eqpt')
        //              ->whereBetween('en.date_entree', [$dateDebut, $dateFin]);

        //     })

        //     ->leftJoin('sortis as so', function ($join) use ($dateDebut, $dateFin) {

        //         $join->on('e.id', '=', 'so.id_eqpt')
        //              ->whereBetween('so.date_sorti', [$dateDebut, $dateFin]);

        //     })

        //     ->select(
        //         'e.id',
        //         'e.nom_eqpt',
        //         DB::raw('COUNT(DISTINCT en.id) as entrees'),
        //         DB::raw('COUNT(DISTINCT so.id) as sorties')
        //     )

        //     ->groupBy(
        //         'e.id',
        //         'e.nom_eqpt'
        //     )

        //     ->get();

        // return response()->json($stats);

        //=========================
        //par type d'intervention
        //=========================
            $dateDebut = $request->dateDebut;
            $dateFin   = $request->dateFin;

            $bilan = DB::table('eqpuipements as e')
                ->leftJoin('entrees as en', function ($join) use ($dateDebut, $dateFin) {
                    $join->on('e.id', '=', 'en.id_eqpt')
                        ->whereBetween('en.date_entree', [$dateDebut, $dateFin]);
                })
                ->leftJoin('typetraitements as tt', 'en.id_typtrait', '=', 'tt.id')
                ->select(
                    'e.nom_eqpt',

                    DB::raw("
                        SUM(
                            CASE
                                WHEN tt.typ_trait = 'Travaux_neufs'
                                THEN 1 ELSE 0
                            END
                        ) AS Travaux_neufs
                    ")
                )
                ->groupBy('e.id', 'e.nom_eqpt')
                ->orderBy('e.nom_eqpt')
                ->get();

            return response()->json($bilan);

    }


}