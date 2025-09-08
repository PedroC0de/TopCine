<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FilmeController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('query');
        $genre = $request->query('genre');

        if (!$query && !$genre) {
            return response()->json(['erro' => 'Parâmetro de consulta ou gênero é obrigatório'], 400);
        }

        // Configuração base da API
        $params = [
            'api_key' => env('TMDB_API_KEY'),
            'language' => 'pt-BR',
        ];

        // Caso apenas o gênero seja informado, é usado o discover
        if (!$query && $genre) {
            $url = 'https://api.themoviedb.org/3/discover/movie';
            $params['with_genres'] = $genre;
            $response = Http::get($url, $params);
            return response()->json($response->json()['results'] ?? []);
        }

        // Caso a query esteja presente (com ou sem gênero)
        $url = 'https://api.themoviedb.org/3/search/movie';
        $params['query'] = $query;
        $response = Http::get($url, $params);

        if ($response->failed()) {
            return response()->json(['erro' => 'Falha ao buscar no TMDB'], 500);
        }

        $results = $response->json()['results'] ?? [];

        if ($genre) {
            $results = array_filter($results, function ($movie) use ($genre) {
                return in_array((int)$genre, $movie['genre_ids'] ?? []);
            });
            $results = array_values($results);
        }

        return response()->json($results);
    }



    public function popular()
    {
        $response = Http::get('https://api.themoviedb.org/3/trending/movie/week', [
            'api_key' => env('TMDB_API_KEY'),
            'language' => 'pt-BR', 
        ]);

        if ($response->failed()) {
            return response()->json(['erro' => 'Falha ao buscar filmes populares'], 500);
        }

        return $response->json();
    }

    public function generos()
    {
        $response = Http::get('https://api.themoviedb.org/3/genre/movie/list', [
            'api_key' => env('TMDB_API_KEY'),
            'language' => 'pt-BR', 
        ]);

        if ($response->failed()) {
            return response()->json(['erro' => 'Falha ao buscar gêneros'], 500);
        }

        return $response->json();
    }

     public function detalhes(Request $request, $id)
    {
        try {
            $response = Http::get("https://api.themoviedb.org/3/movie/{$id}", [
                'api_key' => env('TMDB_API_KEY'),
                'language' => 'pt-BR',
            ]);

            if ($response->failed()) {
                return response()->json(null, 200);
            }

            return response()->json($response->json(), 200);
        } catch (\Exception $e) {
            return response()->json(null, 200);
        }
    }
}
