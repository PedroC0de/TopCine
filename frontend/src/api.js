import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api'
});


export async function getFavoritos(genre = '', query = '') {
  try {
    const params = new URLSearchParams();
    if (query) params.append('query', query);
    if (genre) params.append('genre', genre);
    const url = `/favoritos?${params.toString()}`;
    const response = await api.get(url);

    const data = response.data;
    return data;
  } catch (error) {
    console.error('Erro ao buscar favoritos:', error);
    return [];
  }
}

export async function addFavorito(filme) {
  const response = await api.post('/favoritos', {
    id_tmdb: filme.id,
    titulo: filme.title,
    genero: filme.genre_ids ? filme.genre_ids.join(',') : null,
    sinopse: filme.overview,
    avaliacao: filme.vote_average,
    data: filme.release_date,
    poster_path: filme.poster_path
  });
  return response.data;
}

export async function deleteFavorito(id_tmdb) {
  await api.delete(`/favoritos/${id_tmdb}`);
}


export async function buscarFilmes(query, genre = '') {
  try {
    const params = new URLSearchParams({
      query: query || '',
      genre: genre || '',
    });
    const url = `/filmes/search?${params.toString()}`;
    const response = await api.get(url);

    return response.data;
  } catch (error) {
    console.error('Erro ao buscar filmes:', error);
    return [];
  }
}

export async function getFilmesPopulares() {
  const response = await api.get('/filmes/popular');
  return response.data.results || [];
}

export async function getGenerosFilmes() {
  const response = await api.get('/filmes/generos');
  return response.data.genres || [];
}

export async function getFilmeDetalhes(id) {
  try {
    const response = await api.get(`/filmes/detalhes/${id}`);
    if (!response.data) {
      throw new Error('Filme não encontrado');
    }
    return response.data;
  } catch (error) {
    console.error('Erro ao buscar detalhes do filme:', error);
    throw error;
  }
}