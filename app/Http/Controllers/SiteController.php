<?php

namespace App\Http\Controllers;

use App\Models\site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
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
        // insertion dans la table des sites
        DB::table('sites')->insert([
        'nom_site' => $request->site,
        'adress' => $request->adresse,
        'contact' => $request->contact,
        'chef_agce' => $request->chef_agce,

    ]);

        return response()->json([
        'message' => 'site créé avec succès'
    ]);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(site $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(site $site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, site $site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(site $site)
    {
        //
    }
}
