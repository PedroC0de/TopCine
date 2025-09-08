<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favoritos;

class FavoritoController extends Controller
{

public function index(Request $request)
{
    $query = $request->query('query', '');
    $genre = $request->query('genre', '');

    $favoritosQuery = favoritos::query();

    // Filtrar por nome do filme
    if ($query) {
        $favoritosQuery->where('titulo', 'like', '%' . $query . '%');
    }

    // Filtrar por gênero
    if ($genre) {
        $favoritosQuery->whereRaw('FIND_IN_SET(?, genero)', [$genre]);
    }

    $favoritos = $favoritosQuery->get();

    return response()->json($favoritos);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'id_tmdb' => 'required|integer|unique:favoritos',
        'titulo' => 'required|string',
        'genero' => 'nullable|string',
        'sinopse' => 'nullable|string',
        'avaliacao' => 'nullable',
        'data' => 'nullable|string',
        'poster_path' => 'nullable|string',
        
    ]);
    $favorito = favoritos::create($validated);
    return response()->json($favorito, 201);
}

public function destroy($id_tmdb)
{
    $favorito = Favoritos::where('id_tmdb', $id_tmdb)->firstOrFail();
    $favorito->delete();

    return response()->json(null, 204);
}

}
