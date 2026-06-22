<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\entree;
use App\Models\sorties;
use App\Models\mission;
use Illuminate\Http\Request;

class countcontroller extends Controller
{
                        // foctio statistique

                        public function statistiques()
                    {
                        return response()->json([
                            'nombre_entrees'  => DB::table('entrees')->count(),
                            'nombre_sorties'  => DB::table('sortis')->count(),
                            'nombre_missions' => DB::table('missions')->count(),
                        ]);
                    }


                // fonction par équipement
                    public function entrees(){

                        $entreesParEquipement = DB::table('entrees')
                                                ->join('eqpuipements', 'entrees.id_eqpt', '=', 'eqpuipements.id')
                                                ->select(
                                                        'eqpuipements.id',
                                                        'eqpuipements.nom_eqpt',
                                                        DB::raw('COUNT(entrees.id) as nombre_entrees')
                                                    )
                                                        ->groupBy('eqpuipements.id', 'eqpuipements.libelle')
                                                        ->get();

                                                        return response()->json([$entreesParEquipement]);

                    }

                    //statpar eqpt sorti et entrés

                    public function statistiquesEquipements()
                    {
                        $stats = DB::table('eqpuipements as e')
                            ->leftJoin('entrees as en', 'e.id', '=', 'en.id_eqpt')
                            ->leftJoin('sortis as so', 'e.id', '=', 'so.id_eqpt')
                            ->select(
                                'e.id',
                                'e.nom_eqpt',
                                DB::raw('COUNT(DISTINCT en.id) as entrees'),
                                DB::raw('COUNT(DISTINCT so.id) as sorties')
                            )
                            ->groupBy('e.id', 'e.nom_eqpt')
                            ->get();

                        return response()->json($stats);
                    }
    

}
