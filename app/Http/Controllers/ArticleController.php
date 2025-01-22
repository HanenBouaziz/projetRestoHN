<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
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
            $articles=Article::with('categorie')->get(); // Inclut la sous catégorie liée;
            return response()->json($articles,200);
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
            $article=new Article([
                "nomarticle"=> $request->input('nomarticle'),
                "imagearticle"=> $request->input('imagearticle'),
                "prix"=> $request->input('prix'),
                "categorieID"=> $request->input('categorieID'),
            ]);
            $article->save();
            return response()->json($article);
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

        $article = Article::with('categorie')->findOrFail($id);
        return response()->json($article);
    } catch (\Exception $e) {
        return response()->json(["message" => "Problème de récupération des données", "error" => $e->getMessage()], 500);
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
            $article=Article::findorFail($id);
            $article->update($request->all());
            return response()->json($article);
        } catch (\Exception $e) {
            return response()->json("probleme de modification {$e->getMessage()}");
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
            $article=Article::findOrFail($id);
            $article->delete();
            return response()->json("Article supprimée avec succes");
        } catch (\Exception $e) {
            return response()->json("probleme de suppression de article {$e->getMessage()}");
        }
     }
     public function articlesPaginate()
     {
         try {
             $perPage = request()->input('pageSize', 2);
             // Récupère la valeur dynamique pour la pagination
             $articles = Article::with('categorie')->paginate($perPage);
             // Retourne le résultat en format JSON API
             return response()->json([
             'products' => $articles->items(), // Les articles paginés
             'totalPages' => $articles->lastPage(), // Le nombre de pages
             ]);
         } catch (\Exception $e) {
             return response()->json("Selection impossible {$e->getMessage()}");
         }
     }
}
