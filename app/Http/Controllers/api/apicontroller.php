<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class apicontroller extends Controller
{
    // creer un compte  avec succes
    public function register(Request $request){

        // validatio des données envoyés par le front
        $request->validate([
            'naame' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        
        ]);

        //création de l'utilisateur dans la base
        $user = User::create([
            'name' => $request->naame,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //créatio du Token sanctum
        //$token = $user->createToken('api-token')->plainTextToken;

        //confirmation de la création du User
        return response()->json([
            'message' => 'Utilisateur créé',
            // 'token' => $token,
            'user' => $user
        ], 201);

    }


    // se connecter avec ses parametres

    public function login (Request $request){

        // validatio des entrées
        $request->validate([
        'email' => 'required|email',
        'password' => 'required'
        ]);

        //récupération des informations de l'utilisateur
        $user = User::where('email', $request->email)->first();

        // vérification du mail etpassword envoyés avec ce qui a été récupéré dans la base
        if (!$user || !Hash::check($request->password, $user->password)) {

                return response()->json([
                    'message' => 'Email ou mot de passe incorrect'
                ], 401);
        }

        //création du Token
        $token = $user->createToken('api-token')->plainTextToken;
        
        // confirmation de connexion
        return response()->json([
                'message' => 'Connexion réussie',
                'token' => $token,
                'user' => $user
            ]);
        
    }

    // se déconnecter
    public function logout (Request $request) {

        $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Déconnexion réussie'
            ]);
        
    }




}
