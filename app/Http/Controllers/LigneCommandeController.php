<?php

namespace App\Http\Controllers;

use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LigneCommandeController extends Controller
{

    public function index()
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $lignescommande=LigneCommande::with(['commande','article'])->get();
            return response()->json($lignescommande,200);
        } catch (\Exception $e) {
            return response()->json("Sélection impossible {$e->getMessage()}");
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $lignecommande=new LigneCommande([
            "commandeID"=> $request->input('commandeID'),
            "articleID"=> $request->input('articleID'),
            "quantite"=> $request->input('quantite'),
            "montant"=> $request->input('montant'),
            ]);
            $lignecommande->save();
            return response()->json($lignecommande);
        } catch (\Exception $e) {
            return response()->json("insertion impossible {$e->getMessage()}");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $lignecommande=LigneCommande::findOrFail($id);
            return response()->json($lignecommande);
        } catch (\Exception $e) {
            return response()->json("probleme de récupération des données {$e->getMessage()}");
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $lignecommande=LigneCommande::findorFail($id);
            $lignecommande->update($request->all());
            return response()->json($lignecommande);
        } catch (\Exception $e) {
            return response()->json("probleme de modification {$e->getMessage()}");
        }
    }

    /**
     * Remove the specified resource from storage.
     */  public function destroy($id)
     {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $lignecommande=LigneCommande::findOrFail($id);
            $lignecommande->delete();
            return response()->json("Ligne Commande supprimée avec succes");
        } catch (\Exception $e) {
            return response()->json("probleme de suppression de ligne commande {$e->getMessage()}");
        }
     }
}
