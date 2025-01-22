<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Si l'utilisateur est authentifié, récupérer et retourner les catégories
        $categories = Categorie::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try{
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $categorie=new Categorie([
            "nomcategorie"=>$request->input("nomcategorie"),
            "imagecategorie"=>$request->input("imagecategorie"),
        ]);
        $categorie->save();
        return response()->json($categorie);
    }catch(\Exception $e){
        return response()->json("prob d'ajout");
    }
}
public function show($id)
{
    try {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $categorie = Categorie::findOrFail($id);
        return response()->json($categorie);
    } catch (\Exception $e) {
        return response()->json("problème de récupération de la catégorie");
    }
}


    public function update(Request $request, $id)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $categorie = Categorie::findorFail($id);
            $categorie->update($request->all());
            return response()->json($categorie);
        } catch (\Exception $e) {
            return response()->json("probleme de modification");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $categorie = Categorie::findOrFail($id);
            $categorie->delete();
            return response()->json("catégorie supprimée avec succes");
        } catch (\Exception $e) {
            return response()->json("probleme de suppression de catégorie");
        }
    }
}
