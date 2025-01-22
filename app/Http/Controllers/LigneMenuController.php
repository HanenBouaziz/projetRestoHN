<?php

namespace App\Http\Controllers;

use App\Models\LigneMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LigneMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $ligneMenus = LigneMenu::with(['menu', 'article'])->get();
        return response()->json($ligneMenus);
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $ligneMenu = LigneMenu::create($request->all());
        return response()->json($ligneMenu);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $ligneMenu = LigneMenu::findOrFail($id);
        $ligneMenu->update($request->all());
        return response()->json($ligneMenu);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $ligneMenu = LigneMenu::findOrFail($id);
        $ligneMenu->delete();
        return response()->json(['message' => 'LigneMenu supprimée avec succès']);
    }
}
