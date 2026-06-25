<?php

namespace App\Http\Controllers;

use App\Models\technicien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TechnicienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //Validation des données saisies
        $validated = $request->validate([
            'mat_it' => 'required|string|max:6',
            'nom_tech' => 'required|string',
            'Pren_tech' => 'required|string',
            'cont_it' => 'required|string|max:15',
            'adr_it' => 'required|string',
        ]);

        //Insertion en base de données
        DB::table('techniciens')->insert([
            'matri' => $validated['mat_it'],
            'nom' => $validated['nom_tech'],
            'pren' => $validated['Pren_tech'],
            'contact' => $validated['cont_it'],
            'adress' => $validated['adr_it'],
        ]);

         return response()->json([

            'message' => 'Insertion réussie',

        ], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(technicien $technicien)
    {
        //
    }


     public function getTechn()
            {
                // selectionner les sites
                // Assurez-vous d'ajouter la clé primaire (souvent 'id')
                        $tech = technicien::select('id', 'nom', 'pren') 
                        ->get();

                    return response()->json($tech);
            }

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(technicien $technicien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, technicien $technicien)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(technicien $technicien)
    {
        //
    }
}
