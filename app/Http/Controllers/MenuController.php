<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $menus = Menu::with('lignesMenu')->get();
        return response()->json($menus);
    }
    public function show($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $menu = Menu::with('lignesMenu')->findOrFail($id);
            return response()->json($menu);
        } catch (\Exception $e) {
            return response()->json(["message" => "Problème de récupération des données", "error" => $e->getMessage()], 500);
        }
    }


    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $menu = Menu::create($request->only('nommenu'));
        return response()->json($menu);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $menu = Menu::findOrFail($id);
        $menu->update($request->all());
        return response()->json($menu);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $menu = Menu::findOrFail($id);
        $menu->delete();
        return response()->json(['message' => 'Menu supprimé avec succès']);
    }
    // public function menusPaginate()
    // {
    //     try {
    //         $perPage = request()->input('pageSize', 2);
    //         // Récupère la valeur dynamique pour la pagination
    //         $menus = Menu::with('lignesmenu')->paginate($perPage);
    //         // Retourne le résultat en format JSON API
    //         return response()->json([
    //         'products' => $menus->items(), // Les articles paginés
    //         'totalPages' => $menus->lastPage(), // Le nombre de pages
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json("Selection impossible {$e->getMessage()}");
    //     }
    // }
}
