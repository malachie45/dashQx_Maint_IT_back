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
    public function statistiquesEquipements(Request $request)
    {
        $dateDebut = $request->dateDebut;
        $dateFin = $request->dateFin;

        $stats = DB::table('eqpuipements as e')

            ->leftJoin('entrees as en', function ($join) use ($dateDebut, $dateFin) {

                $join->on('e.id', '=', 'en.id_eqpt')
                     ->whereBetween('en.date_entree', [$dateDebut, $dateFin]);

            })

            ->leftJoin('sortis as so', function ($join) use ($dateDebut, $dateFin) {

                $join->on('e.id', '=', 'so.id_eqpt')
                     ->whereBetween('so.date_sorti', [$dateDebut, $dateFin]);

            })

            ->select(
                'e.id',
                'e.nom_eqpt',
                DB::raw('COUNT(DISTINCT en.id) as entrees'),
                DB::raw('COUNT(DISTINCT so.id) as sorties')
            )

            ->groupBy(
                'e.id',
                'e.nom_eqpt'
            )

            ->get();

        return response()->json($stats);
    }
}