<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\FilmeController;   

// Rotas para filmes favoritos (CRUD)
Route::apiResource('favoritos', FavoritoController::class);


// Rota para busca de filmes via TMDB
Route::get('/filmes/search', [FilmeController::class, 'search']);

Route::get('/filmes/popular', [FilmeController::class, 'popular']);

Route::get('/filmes/generos', [FilmeController::class, 'generos']);

Route::get('/filmes/detalhes/{id}', [FilmeController::class, 'detalhes']);
