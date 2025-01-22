<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $commandes=Commande::with('user')->get();
            return response()->json($commandes,200);
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
            $commande=new Commande([
            "num"=> $request->input('num'),
            "prixTotal"=> $request->input('prixTotal'),
            "etat"=> $request->input('etat'),
            "userID"=> $request->input('userID'),
            ]);
            $commande->save();
            return response()->json($commande);
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
            $commande=Commande::findOrFail($id);
            return response()->json($commande);
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
            $commande=Commande::findorFail($id);
            $commande->update($request->all());
            return response()->json($commande);
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
            $commande=Commande::findOrFail($id);
            $commande->delete();
            return response()->json("Commande supprimée avec succes");
        } catch (\Exception $e) {
            return response()->json("probleme de suppression de commande {$e->getMessage()}");
        }
     }
    //  public function getLastCommandeIdAlternative()
    //  {
    //      // Récupérer le dernier enregistrement en triant par l'ID en ordre décroissant
    //      $lastCommande = Commande::orderBy('id', 'desc')->first();

    //      // Si aucune commande n'est trouvée, renvoyer 0
    //     //  $lastID = $lastCommande ? $lastCommande->id : 0;

    //      return response()->json($lastCommande);
    //  }


}
